Elasticsearch 基础入门
======================

该文档所使用的Elasticsearch 版本为7.7.0

概述
-------------

[Elasticsearch](https://www.elastic.co/)是一个开源的、分布式、高扩展、高实时的**搜索**与**数据分析**引擎，上手简单，使用Java语言开发，底层使用[Lucene](https://lucene.apache.org)。

### 主要功能

* 分布式搜索引擎
* 大数据近实时分析引擎

### 基本概念

#### 近实时 NRT
* 从插入文档到可以被搜索到通常只有1秒左右的延迟
* 可以实现秒级别的大数据分析

#### 集群 Cluster
* 集群是一个或多个节点的集合
* 集群的默认名称为elasticsearch
* 可以突破单机的存储限制，增加高可用性

#### 节点 Node
* 是一个单独的服务器，一个节点只能属于一个集群，相同的节点集群名称会组成一个集群
* 节点名称默认是随机的，但为了方便管理最好是设置一个Node名称

#### 索引 Index
* 存储文档的集合，类似数据库中表的概念
* 同一个Index中的Document的字段应保持相同，有利于提高搜索效率
* 一个集群可以存储多个索引
* 索引名称必须为小写
* 索引还有可能是动词，比如索引一个文档，表示将文档保存进Elasticsearch中，能够被搜索到

#### 文档 Document
* 就是一条JSON数据，类似数据库中的一行记录

#### 分片和副本 Shards & Replicas
* 一个Index可以被拆分成多个Shard存储在多个Node上
* Shard分主分片（Primary Shard）和副本分片（Replica Shard)
* Primary Shard的备份就是Replica Shard
* 为了数据安全同一个Primary Shard和Replica Shard不会保存在同一个节点上
* 创建Index时确定Primary Shard的数量，创建之后不能修改，Replica Shard的数量可修改
* Replica Shard的作用
    * 防止发生意外导致数据丢失，提升高可用性
    * 由于Replica Shard和Primary Shard是一样的，所以Primary Shard和Replica Shard都可以查询，可以提高查询效率
* 每个Shard是一个Lucene索引

#### 词项 term
* 将一句话进行分词就可以得到多个term，是倒排索引中保存的最小单元。

#### 和关系型数据库的类比

| 关系型数据库 | Elasticsearch          |
| -------- | ---------------------- |
| Table    | Index                  |
| Row      | Document               |
| Column   | FIeld                  |
| Schema   | Mapping                |
| SQL      | URI Search & Query DSL |



### Elastic Stack 家族成员及其应用场景
* ElasticSearch：数据存储、查询与分析
* Kibana：数据可视化分析
* Logstash + Beats：数据收集与处理


### 使用流程

* 作为搜索引擎：

    ```
    应用程序 ⇨ 写入/更新数据库 ⇨ 同步数据 ⇨ Elasticsearch ⇦ 应用程序查询
    ```

* 作为日志分析：
    ```
    应用程序 ⇨ 生成日志 ⇨ 文件/队列系统 ⇨ Elasticsearch ⇦ Kibana可视化分析
    ```


安装
---------
1. 打开 <https://www.elastic.co/cn/downloads/elasticsearch>
2. 下载对应系统的压缩包并解压缩
3. 运行 `bin/elasticsearch`、Windows运行 `bin/elasticseaech.bat`
4. 访问 `http://localhost:9200`

如下载速度慢导致无法下载可以使用镜像网站进行下载，如[华为开源镜像站](https://mirrors.huaweicloud.com/)

Mapping
----------
* 类似数据库的表定义
* 可以设置Index下面的字段名
* 可以设置Index下面字段的类型
* 可以设置Index下面字段的倒排索引的配置
* 创建mapping有隐式和显式两种类型，隐式是插入document时自动创建，显式是手动创建
* 不能修改已经创建好的field，因为Lucene的倒排索引不能修改，可以新增field

### 索引配置
* `dynamic` 动态Mapping配置，创建后可修改
    * `true` 自动新增字段定义（默认）
    * `false` 不自动新增字段，新增的数据会保存但不能查询（推荐）
    * `strict` 严格默认，插入文档字段定义不存在时报错，数据不能保存成功
### 字段配置
* `index` 是否记录索引，默认为`true`，`false`即不能搜索
* `index_options` 索引选项
* `null_value` null值替换
* `copy_to` 将现有的多个字段复制到新字段
* `ignore_above` 超过该值就会忽略索引，一般可keyword搭配使用，默认值为256
* `fields` 定义子字段，如文章标题类型为text，可以设置一个keywor的子字段，整个标题当作一个term，当搜索整个标题的时候得分就会很高
### 核心字段数据类型
* 文本类型
    * `keyword` 关键字类型，保存结构化数据，不分词字段
    * `text` 文本类型，保存结非构化数据，如文章标题或文章详情，就是需要全文检索的数据
* 数值类型
    * `btye` 1字节
    * `short` 2字节
    * `integer` 4字节
    * `long` 8字节
    * `float` 4字节
    * `double` 8字节
* 范围
    * `integer_range`
    * `float_range`
    * `long_range`
    * `double_range`
    * `date_range`
* 复合类型
    * `object`
    * `nested`
* 其他类型
    * `date`
    * `boolean`
    * `binary`
    * `ip`
    * `geo_point`
    * `geo_shape`
    * `join`
* 数组
    * 数组不是专门的字段，默认情况所有的字段类型都可以是数组，都可以包含零个或多个值，数组中的值类型必须相同。
* 多字段（multi-fields）
    * 作用是允许一个字段使用多个不同的配置，如中文可以使用拼音搜索的，就可以新增一个拼音的子字段来实现

文档CURD
---------


分词器 Analyzer
---------------


数据查询
-----------
### URI Search
### Query DSL


聚合分析
---------------


运维
-----------
### 主要的配置
### 集群状态
### 主分片规划
### Reindex

## 其他
cerebro


## Elasticsearch资源

<https://www.elastic.co/guide>
<https://elasticstack.blog.csdn.net>
<https://developer.aliyun.com/group/es>
<http://www.ruanyifeng.com/blog/2017/08/elasticsearch.html>