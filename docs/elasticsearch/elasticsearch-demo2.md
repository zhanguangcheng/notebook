Elasticsearch 案例二
========================

## 案例背景

现在有一个文章类网站，文章有作者信息，需要支持文章和作者能够全文检索

该文档所使用的Elasticsearch 版本为7.7.0

## 实现方案


1. 创建数据表
2. 创建索引
3. 同步数据
4. 数据查询

## 创建数据表

文章的数据表结构如下

```sql
CREATE TABLE `article` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int unsigned NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `view` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

作者的数据表结构如下
```sql
CREATE TABLE `author` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) NOT NULL,
  `age` tinyint unsigned NOT NULL,
  `interest` varchar(250) NOT NULL DEFAULT '',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

插入测试数据
```sql
INSERT INTO `test`.`article`(`id`, `author_id`, `title`, `content`, `view`, `created_at`, `updated_at`, `is_deleted`) VALUES (1, 1, 'Elasticsearch简介', '<p>Elasticsearch是一个非常强大的搜索引擎。它目前被广泛地使用于各个IT公司。Elasticsearch是由Elastic公司创建并开源维护的。它的开源代码位于<a href=\"https://github.com/elastic/elasticsearch\">https://github.com/elastic/elasticsearch</a>。同时，Elastic公司也拥有<a href=\"https://github.com/elastic/logstash\">Logstash</a>及<a href=\"https://github.com/elastic/kibana\">Kibana</a>开源项目。这个三个开源项目组合在一起，就形成了 <strong>ELK</strong>软件栈。他们三个共同形成了一个强大的生态圈。简单地说，<strong>L</strong>ogstash负责数据的采集，处理（丰富数据，数据转型等），<strong>Ki</strong>bana负责数据展，分析及管理。Elasticsearch处于最核心的位置，它可以帮我们对数据进行快速地搜索及分析。</p>', 1, '2020-06-14 15:18:13', '2020-06-21 22:23:34', 0);
INSERT INTO `test`.`article`(`id`, `author_id`, `title`, `content`, `view`, `created_at`, `updated_at`, `is_deleted`) VALUES (2, 1, 'Elasticsearch分布式，高度可用', '<p>\r\nElasticsearch是一个高度可用的分布式搜索引擎。每个索引都分解为碎片，每个碎片可以有一个或多个副本。默认情况下，创建一个索引，每个分片有1个分片和1个副本（1/1）。可以使用许多拓扑，包括1/10（提高搜索性能）或20/1（提高索引性能）。</p><p>为了使用Elasticsearch的分布式特性，只需启动更多节点并关闭节点。系统将继续为索引的最新数据提供请求（确保使用正确的http端口）。</p>', 0, '2020-06-14 15:18:13', '2020-06-21 22:23:36', 0);
INSERT INTO `test`.`author`(`id`, `nickname`, `age`, `interest`, `updated_at`, `is_deleted`) VALUES (1, '小草', 18, '爱电脑、<b>爱编程<b>、爱生活、爱妹子', '2020-06-21 22:42:23', 0);
```

## 创建索引

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
      "author_id": {
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

PUT /author
{
  "mappings" : {
    "dynamic": false,
    "properties" : {
      "id": {
        "type": "long"
      },
      "age": {
        "type": "byte"
      },
      "interest" : {
        "type" : "text",
        "analyzer": "ik_max_word",
        "search_analyzer": "ik_smart"
      },
      "is_deleted" : {
        "type" : "byte"
      },
      "updated_at" : {
        "type" : "date"
      }
    }
  }
}
```

## 同步数据
新建同步配置文件`C:\portable-env\elasticsearch-7.7.0\config\article-author.conf`：
```conf
input {
    jdbc {
        type => "article"
        jdbc_driver_class => "com.mysql.jdbc.Driver"
        jdbc_driver_library => "C:/portable-env/logstash-7.7.0/config/mysql-connector-java-8.0.19.jar"
        jdbc_connection_string => "jdbc:mysql://127.0.0.1:3306/test?characterEncoding=utf8&useSSL=false&serverTimezone=GMT%2B8"
        jdbc_user => "root"
        jdbc_password => ""
        jdbc_paging_enabled => true
        jdbc_page_size => 5000
        statement => "SELECT id,author_id,title,content,view,created_at,updated_at,is_deleted,UNIX_TIMESTAMP(updated_at) AS unix_timestamp FROM `article`  WHERE (UNIX_TIMESTAMP(updated_at) > :sql_last_value AND updated_at < NOW()) ORDER BY updated_at ASC"
        record_last_run => true
        tracking_column_type => "numeric"
        tracking_column => "unix_timestamp"
        use_column_value => true
        last_run_metadata_path => "C:/portable-env/logstash-7.7.0/data/article_last_run_time"
        schedule => "*/10 * * * * *"
    }
    jdbc {
        type => "author"
        jdbc_driver_class => "com.mysql.jdbc.Driver"
        jdbc_driver_library => "C:/portable-env/logstash-7.7.0/config/mysql-connector-java-8.0.19.jar"
        jdbc_connection_string => "jdbc:mysql://127.0.0.1:3306/test?characterEncoding=utf8&useSSL=false&serverTimezone=GMT%2B8"
        jdbc_user => "root"
        jdbc_password => ""
        jdbc_paging_enabled => true
        jdbc_page_size => 5000
        statement => "SELECT id,nickname,interest,updated_at,is_deleted,UNIX_TIMESTAMP(updated_at) AS unix_timestamp FROM `author`  WHERE (UNIX_TIMESTAMP(updated_at) > :sql_last_value AND updated_at < NOW()) ORDER BY updated_at ASC"
        record_last_run => true
        tracking_column_type => "numeric"
        tracking_column => "unix_timestamp"
        use_column_value => true
        last_run_metadata_path => "C:/portable-env/logstash-7.7.0/data/author_last_run_time"
        schedule => "*/10 * * * * *"
    }
}

filter {
    mutate{
        gsub => [ "content", "<\/?\w+(\s+\w+=(['"]).*\2)*\s*\/?\s*>", "" ]
        gsub => [ "interest", "<\/?\w+(\s+\w+=(['"]).*\2)*\s*\/?\s*>", "" ]
        remove_field => ["unix_timestamp"]
    }
}

output {
    if [type] == "article" {
        elasticsearch {
            hosts => ["localhost:9200"]
            index => "article"
            document_id => "%{id}"
        }
    }
    if [type] == "author" {
        elasticsearch {
            hosts => ["localhost:9200"]
            index => "author"
            document_id => "%{id}"
        }
    }
    stdout {
        codec => json_lines
    }
}
```

进入目录：`C:\portable-env\logstash-7.7.0\bin`，启动Logstash
```bash
logstash -f ../config/article-author.conf
```

正常情况会将数据同步到Elasticsearch中

## 数据查询

### 如果是子表article中的条件

先查询article、再根据结果中的author_id查询主表信息，程序中合成最终数据

### 如果是主表author中的条件
先查询author、再根据结果中的id查询子表信息，程序中合成最终数据

### 如果是两个表中的条件
先查询主表，再根据结果中的id加上子表的条件查询子表，程序中合成最终数据
