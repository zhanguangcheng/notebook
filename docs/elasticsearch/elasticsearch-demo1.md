Elasticsearch 案例一
=============================


## 案例背景

现在有一个文章类网站，需要文章能够支持全文检索

该文档所使用的Elasticsearch 版本为7.7.0


## 实现方案

1. 创建数据表
2. 创建索引
3. 同步数据
4. 数据查询
5. 数据展示


## 创建数据表

文章的数据表结构如下
```sql
CREATE TABLE `article`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `view` int NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_deleted` tinyint NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```
>  其中`updated_at`为数据的更新时间，`is_deleted`为是否已删除，删除后将标记为`1`且修改更新时间为最新时间

插入2条测试数据
```sql
INSERT INTO article (title,content) VALUES("Elasticsearch简介", '<p>Elasticsearch是一个非常强大的搜索引擎。它目前被广泛地使用于各个IT公司。Elasticsearch是由Elastic公司创建并开源维护的。它的开源代码位于<a href="https://github.com/elastic/elasticsearch">https://github.com/elastic/elasticsearch</a>。同时，Elastic公司也拥有<a href="https://github.com/elastic/logstash">Logstash</a>及<a href="https://github.com/elastic/kibana">Kibana</a>开源项目。这个三个开源项目组合在一起，就形成了 <strong>ELK</strong>软件栈。他们三个共同形成了一个强大的生态圈。简单地说，<strong>L</strong>ogstash负责数据的采集，处理（丰富数据，数据转型等），<strong>Ki</strong>bana负责数据展，分析及管理。Elasticsearch处于最核心的位置，它可以帮我们对数据进行快速地搜索及分析。</p>');
INSERT INTO article (title,content) VALUES("Elasticsearch分布式，高度可用", '<p>Elasticsearch是一个高度可用的分布式搜索引擎。每个索引都分解为碎片，每个碎片可以有一个或多个副本。默认情况下，创建一个索引，每个分片有1个分片和1个副本（1/1）。可以使用许多拓扑，包括1/10（提高搜索性能）或20/1（提高索引性能）。</p><p>为了使用Elasticsearch的分布式特性，只需启动更多节点并关闭节点。系统将继续为索引的最新数据提供请求（确保使用正确的http端口）。</p>');
```

表中数据如下：


| id  | title                         | content | view | created_at          | updated_at          | is_deleted |
| --- | ----------------------------- | ------- | ---- | ------------------- | ------------------- | --------- |
| 1   | Elasticsearch简介             | ……      | 0    | 2020-06-14 15:18:13 | 2020-06-14 15:18:13 | 0         |
| 2   | Elasticsearch分布式，高度可用 | ……      | 0    | 2020-06-14 15:18:13 | 2020-06-14 15:18:13 | 0         |

## 创建索引

安装[中文分词插件](https://github.com/medcl/elasticsearch-analysis-ik)
```bash
elasticsearch-plugin install https://github.com/medcl/elasticsearch-analysis-ik/releases/download/v7.7.0/elasticsearch-analysis-ik-7.7.0.zip
```
或者下载后离线安装
```bash
elasticsearch-plugin install file:///C:\portable-env\elasticsearch-7.7.0\elasticsearch-analysis-ik-7.7.0.zip
```

创建索引的定义如下：
```json
PUT /article
{
  "mappings" : {
    "dynamic": false,
    "properties" : {
      "id": {
        "type": "long"
      },
      "title" : {
        "type" : "text",
        "analyzer": "ik_max_word",
        "search_analyzer": "ik_smart",
        "fields" : {
          "keyword" : {
            "type" : "keyword",
            "ignore_above" : 256
          }
        }
      },
      "content" : {
        "type" : "text",
        "analyzer": "ik_max_word",
        "search_analyzer": "ik_smart"
      },
      "created_at" : {
        "type" : "date"
      },
      "is_deleted" : {
        "type" : "byte"
      },
      "updated_at" : {
        "type" : "date"
      },
      "view" : {
        "type" : "integer"
      }
    }
  }
}
```

## 同步数据

使用Logstash的插件[jdbc input plugin](https://www.elastic.co/guide/en/logstash/current/plugins-inputs-jdbc.html)做好文章数据的同步
新建同步配置文件`C:\portable-env\elasticsearch-7.7.0\config\article.conf`：
```conf
input {
    jdbc {
        jdbc_driver_class => "com.mysql.jdbc.Driver"
        jdbc_driver_library => "C:/portable-env/logstash-7.7.0/config/mysql-connector-java-8.0.19.jar"
        jdbc_connection_string => "jdbc:mysql://127.0.0.1:3306/test?characterEncoding=utf8&useSSL=false&serverTimezone=GMT%2B8"
        jdbc_user => "root"
        jdbc_password => ""
        jdbc_paging_enabled => true
        jdbc_page_size => 5000
        statement => "SELECT id,title,content,view,created_at,updated_at,is_deleted,UNIX_TIMESTAMP(updated_at) AS unix_timestamp FROM `article`  WHERE (UNIX_TIMESTAMP(updated_at) > :sql_last_value AND updated_at < NOW()) ORDER BY updated_at ASC"
        record_last_run => true
        tracking_column_type => "numeric"
        tracking_column => "unix_timestamp"
        use_column_value => true
        last_run_metadata_path => "C:/portable-env/logstash-7.7.0/data/article_last_run_time"
        schedule => "*/10 * * * * *"
    }
}

filter {
    mutate{
        gsub => [ "content", "<[^>]+>", "" ]
        gsub => [ "content", "&nbsp;", "" ]
        remove_field => ["unix_timestamp"]
    }
}

output {
    elasticsearch {
        hosts => ["localhost:9200"]
        index => "article"
        document_id => "%{id}"
    }
    stdout {
        codec => json_lines
    }
}
```

这里我们解释一下：
* `mysql-connector-java-8.0.19.jar`[下载地址](https://dev.mysql.com/downloads/connector/j/)，选择`Platform Independent`
* `schedule => "*/10 * * * * *"`表示设置为每10秒同步一次
* 我们将每次同步的时间：`unix_timestamp`保存到文件：`C:/portable-env/logstash-7.7.0/data/article_last_run_time`中，SQL语句中就能使用`:sql_last_value`代替最后同步时间
* 我们使用gsub过滤文章内容的html标签和html实体符号空格
* 这里我们新增了条件：`updated_at < NOW()`的目的是防止同一时间插入多条数据时，未插入完毕时就执行同步导致的同步遗漏，详情参考[这里]( https://developer.aliyun.com/article/762059 )

进入目录：`C:\portable-env\logstash-7.7.0\bin`，启动Logstash
```bash
logstash -f ../config/article.conf
```

正常情况会将数据同步到Elasticsearch中

我们试着修改数据
```sql
UPDATE article SET view=view+1 WHERE id=1
```
或者删除数据
```sql
UPDATE article SET is_deleted=1 WHERE id=1
```
会发现也会正常同步


## 数据查询

使用Query DSL语法查询：
```json
GET article/_search
{
  "query": {
    "bool": {
      "filter":{
        "term":{"is_deleted":0}
      },
      "must": {
        "multi_match": {
          "query":"Elasticsearch是一个高度可用的分布式搜索引擎",
          "fields": ["title", "content"]
        }
      }
    }
  },
  "highlight" : {
      "pre_tags" : ["<strong>"],
      "post_tags" : ["</strong>"],
      "fields" : {
          "title" : {},
          "content" : {}
      }
  },
  "size": 10,
  "from": 0
}
```

* `highlight`是设置高亮配置
* `from`和`size`类似MySQL中的`OFFSET`和`LIMIT`，用于分页获取数据

返回结果如下：
```json
{
  "took" : 5,
  "timed_out" : false,
  "_shards" : {
    "total" : 1,
    "successful" : 1,
    "skipped" : 0,
    "failed" : 0
  },
  "hits" : {
    "total" : {
      "value" : 2,
      "relation" : "eq"
    },
    "max_score" : 3.440079,
    "hits" : [
      {
        "_index" : "article",
        "_type" : "_doc",
        "_id" : "2",
        "_score" : 3.440079,
        "_source" : {
          "view" : 0,
          "created_at" : "2020-06-14T07:18:13.000Z",
          "updated_at" : "2020-06-14T14:45:39.000Z",
          "content" : """
Elasticsearch是一个高度可用的分布式搜索引擎。每个索引都分解为碎片，每个碎片可以有一个或多个副本。默认情况下，创建一个索引，每个分片有1个分片和1个副本（1/1）。可以使用许多拓扑，包括1/10（提高搜索性能）或20/1（提高索引性能）。为了使用Elasticsearch的分布式特性，只需启动更多节点并关闭节点。系统将继续为索引的最新数据提供请求（确保使用正确的http端口）。""",
          "id" : 2,
          "@version" : "1",
          "@timestamp" : "2020-06-14T14:45:40.133Z",
          "is_deleted" : 0,
          "title" : "Elasticsearch分布式，高度可用"
        },
        "highlight" : {
          "title" : [
            "<strong>Elasticsearch</strong><strong>分布式</strong>，<strong>高度</strong><strong>可用</strong>"
          ],
          "content" : [
            "<strong>Elasticsearch</strong><strong>是</strong><strong>一个</strong><strong>高度</strong><strong>可用</strong><strong>的</strong><strong>分布式</strong><strong>搜索引擎</strong>。每个索引都分解为碎片，每个碎片可以有<strong>一个</strong>或多个副本。默认情况下，创建<strong>一个</strong>索引，每个分片有1个分片和1个副本（1/1）。",
            "为了使用<strong>Elasticsearch</strong><strong>的</strong><strong>分布式</strong>特性，只需启动更多节点并关闭节点。系统将继续为索引<strong>的</strong>最新数据提供请求（确保使用正确<strong>的</strong>http端口）。"
          ]
        }
      },
      {
        "_index" : "article",
        "_type" : "_doc",
        "_id" : "1",
        "_score" : 0.4603077,
        "_source" : {
          "view" : 1,
          "created_at" : "2020-06-14T07:18:13.000Z",
          "updated_at" : "2020-06-14T14:45:41.000Z",
          "content" : "Elasticsearch是一个非常强大的搜索引擎。它目前被广泛地使用于各个IT公司。Elasticsearch是由Elastic公司创建并开源维护的。它的开源代码位于https://github.com/elastic/elasticsearch。同时，Elastic公司也拥有Logstash及Kibana开源项目。这个三个开源项目组合在一起，就形成了 ELK软件栈。他们三个共同形成了一个强大的生态圈。简单地说，Logstash负责数据的采集，处理（丰富数据，数据转型等），Kibana负责数据展，分析及管理。Elasticsearch处于最核心的位置，它可以帮我们对数据进行快速地搜索及分析。",
          "id" : 1,
          "@version" : "1",
          "@timestamp" : "2020-06-14T14:45:50.076Z",
          "is_deleted" : 0,
          "title" : "Elasticsearch简介"
        },
        "highlight" : {
          "title" : [
            "<strong>Elasticsearch</strong>简介"
          ],
          "content" : [
            "<strong>Elasticsearch</strong><strong>是</strong><strong>一个</strong>非常强大<strong>的</strong><strong>搜索引擎</strong>。它目前被广泛地使用于各个IT公司。<strong>Elasticsearch</strong><strong>是</strong>由Elastic公司创建并开源维护<strong>的</strong>。",
            "它<strong>的</strong>开源代码位于https://github.com/elastic/<strong>elasticsearch</strong>。同时，Elastic公司也拥有Logstash及Kibana开源项目。",
            "他们三个共同形成了<strong>一个</strong>强大<strong>的</strong>生态圈。简单地说，Logstash负责数据<strong>的</strong>采集，处理（丰富数据，数据转型等），Kibana负责数据展，分析及管理。",
            "<strong>Elasticsearch</strong>处于最核心<strong>的</strong>位置，它可以帮我们对数据进行快速地搜索及分析。"
          ]
        }
      }
    ]
  }
}
```

## 数据展示

通过查询到的数据渲染页面，要注意的是当返回结果中`highlight`中包含要获取的字段时优先使用，否则使用`_source`中的原字段