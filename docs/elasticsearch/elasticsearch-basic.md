Elasticsearch 基础入门
======================

该文档所使用的Elasticsearch 版本为7.7

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
1. 打开<https://www.elastic.co/cn/downloads/elasticsearch>
2. 下载对应系统的压缩包并解压缩
3. 运行`bin/elasticsearch`、Windows运行`bin/elasticseaech.bat`
4. 访问<http://localhost:9200>


Mapping
----------

### 索引配置
### 字段配置
### 字段类型


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