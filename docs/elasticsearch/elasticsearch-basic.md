# Elasticsearch 基础


## 简介

### 是什么

* [Elasticsearch](https://www.elastic.co/)是一个开源的、分布式、高扩展、高实时的搜索与数据分析引擎。
* 使用Java语言开发，底层使用[Lucene](https://lucene.apache.org)，作者是：·Shay Banon。
* 特点：分布式、全文搜索、数据分析的集合，开箱即用，上手简单。

### 可以做什么

* 为你的应用提供搜索服务
* 日志分析
* 指标分析

## 基本概念

### 近实时 NRT
* 从插入文档到可以被搜索到通常只有1秒左右的延迟
* 可以实现秒级别的大数据分析

### 集群 Cluster
* 集群是一个或多个节点的集合
* 集群的默认名称为elasticsearch
* 可以突破单机的存储限制，增加高可用性

### 节点 Node
* 是一个单独的服务器，一个节点只能属于一个集群，相同的节点集群名称会组成一个集群
* 节点名称默认是随机的，但为了方便管理最好是设置一个Node名称

### 索引 Index
* 存储文档的集合，类似数据库中表的概念
* 同一个Index中的Document的字段应保持相同，有利于提高搜索效率
* 一个集群可以存储多个索引
* 索引名称必须为小写

### 文档 Document
* 就是一条JSON数据，类似数据库中的一行记录

### 分片和副本 Shards & Replicas
* 一个Index可以被拆分成多个Shard存储在多个Node上
* Shard的备份就是Replica
* 为了数据安全同一个Shard和Replica不会保存在同一个节点上
* 创建Index时确定Shard的数量，创建之后不能修改，Replica的数量可修改
* Replica的作用
    * 防止发生意外导致数据丢失，提升高可用性
    * 由于Replica和Shard是一样的，所以Shard和Replica都可以查询，可以提高查询效率
* 每个Shard是一个Lucene索引


## 使用步骤

1. 安装启动
2. 创建Index
3. 将数据同步到Elasticsearch的Index中
4. 通过api查询数据


## 安装和启动

* 这里演示的版本出Elasticsearch5.6
* 环境是Centos，至少2核CPU以上才能运行Elasticsearch
* 运行Elasticsearch需要非root账号，所以需要提前准备一个账号
* 由于国内下载速度慢，这里使用了镜像地址加快速度
* 我们安装一个Kibana，使用Dev Tools来操作Elasticsearch
* 默认情况下，Elasticsearch 只允许本机访问，如果需要远程访问，可以修改安装目录的`config/elasticsearch.yml`文件，去掉`network.host`的注释，将它的值改成`0.0.0.0`，Kibana修改`config/kibana.yml`的`server.host`的值为`"0.0.0.0"`，然后重新启动 Elasticsearch和Kibana。

```bash
yum install java-1.8.0-openjdk
sudo sysctl -w vm.max_map_count=262144
wget https://mirrors.huaweicloud.com/elasticsearch/5.6.16/elasticsearch-5.6.16.tar.gz
wget https://mirrors.huaweicloud.com/kibana/5.6.16/kibana-5.6.16-linux-x86_64.tar.gz
tar zxf elasticsearch-5.6.16
tar zxf kibana-5.6.16-linux-x86_64
./bin/elasticsearch
./bin/kibana
```

## 基本使用
* 安装分词插件
```bash
./bin/elasticsearch-plugin install https://github.com/medcl/elasticsearch-analysis-ik/releases/download/v5.6.16/elasticsearch-analysis-ik-5.6.16.zip
```

1. 新建Index
2. 新增Document
3. 搜索Document
4. 修改Document
5. 删除Document


## 链接
[官方在线文档](https://www.elastic.co/guide/)