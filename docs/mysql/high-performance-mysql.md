高性能MySQL笔记
=================

[TOC]

## 1.MySQL架构与历史

### MySQL逻辑架构

分为三层

* 连接和线程处理
    * 连接处理、授权认证、安全等等
* 解析器，优化器
    * 查询解析、分析、优化、缓存
    * 所有的内置函数
    * 跨存储引擎的功能：存储过程、触发器、试图等
* 存储引擎
    * 数据的存储与读取
    * 服务器通过API与储存引擎通讯，API屏蔽了不同存储引擎之间的差异
    * 不同的储存引擎不会通讯

### 并发控制

同一时间处理多个查询的行为

* 读写锁
    * 共享锁、排他锁
* 锁粒度
    * 锁定的范围大小
    * 表锁
        * 并发性能不好，但锁的开销小
    * 行锁
        * 最大程度地支持并发处理，同时也带来了最大的锁开销

### 事务

一组原子性的sql查询，或者说一个独立工作的单元。

* 特性：ACID

* 原子性
    * 最小单元，要么全部成功，要么全部失败
* 一致性
    * 全部执行成功才提交
* 隔离性
    * 事务提交前，对其他事务是不可见的（通常来说）
* 持久性
    * 提交成功后，所做的修改就会永久保存在数据库中

#### 隔离级别

* READ UNCOMMITTED（未提交读）
    * 事务中的修改，即使没有提交，对其他的事务都是可见的
    * 事务可以读取未提交的数据，这也被称为脏读
* READ COMMITTED（提交读）（大多数数据库默认的级别）
    * 也称为不可重复读
    * 事务中的修改，对于其他的事务是不可见的
    * 一个事务先后读取同一条记录，而两次读取之间可能会被其他事务所修改，则两次读取的数据不一样。
* REPEATABLE READ（可重复读）（MySQL默认的级别）
    * 可重复读解决了脏读的问题
    * 该级别保证了多次读取同一条记录的结果是一致的
    * 理论上讲，该级别会产生幻读的问题，幻读指一个事务读取某个范围内的记录时，其他事务在该范围内插入新的记录，再次读取范围记录时数据不一致
    * InnoDB和XtraDB存储引擎解决了幻读的问题
* SERIALIZABLE（可串行化）
    * 该级别会在读取的每一行上都加锁，所以可能会导致大量的超时和锁征用的问题
    * 是最高的级别，通过强制事务串行执行，解决了前面的幻读的问题
    * 最大程度的保证了数据的一致性，但是并发性能差


| 隔离级别         | 脏读可能性 | 不可重复读可能性 | 幻读可能性 | 加锁读 |
|-----------------|-----------|-----------------|-----------|--------|
| READ UNCOMMITED | Yes       | Yes             | Yes       | No     |
| READ COMMITED   | No        | Yes             | Yes       | No     |
| REPEATABLE READ | No        | No              | Yes       | No     |
| SERIALIZABLE    | No        | No              | No        | Yes    |


#### 死锁

两个事务同时锁定对方的记录，都在等待对方释放锁。
InnoDB处理死锁的方法是将持有最少行级排它锁(写锁)的事务进行回滚

#### 事务日志

用于提高事务的效率，持久化的事务保存在内存中，会在后台慢慢刷回磁盘，如果未刷回时系统崩溃，存储引擎则会在重启时能够自我恢复。

#### MySQL中的事务

* 默认为自动提交，也就是说每条语句都会当成事务执行提交，
* 显示调用事务：
```sql
SET AUTOCOMMIT=0
-- 执行语句
COMMIT
-- or
ROLLBACK
```

* 隐式和显式锁定
    * 隐式：InnoDB会根据隔离级别自动加锁，当执行COMMIT或ROLLBACK时才释放锁，并且所有的锁在同一时刻才会释放
    * 显示：
        * innodb级别：`SELECT ... LOCK IN SHARE MODE`
        * 服务器级别：`LOCK TABLES`, `UNLOCK TABLES`
    * 都应该避免显示调用，严重影响性能

### 多版本并发控制（MVCC）

* 几乎主流的数据库都实现了MVCC，实现方式也是不尽相同，因为没有标准。
* MVCC多数情况下避免了加锁操作，因此开销更小，实现了非阻塞的读操作，写操作也只锁定必要的行，
* InnoDB的MVCC实现原理：给每行增加了隐藏的两列：创建时间，删除时间，只兼容隔离级别：提交读，可重复读

MySQL存储引擎

* InnoDB
    * MySQL5.1之后默认的存储引擎
    * 很多个人和公司都对其进行贡献代码
    * 为了改善InnoDB的性能，Oracle投入了大量的资源，并做了很多卓有成就的工作
    * 行锁
    * 采用MVCC来支持高并发，通过间隙锁策略防止幻读的出现
* MyISAM
    * MySQL5.1之前默认的存储引擎
    * 表锁
    * 提供了大量的特性：全文索引、压缩、空间函数等，但不支持事务和行级锁
    * 系统崩溃后无法安全恢复
* 其他
    * Archive
    * Backhole
    * CSV
    * Federated
    * Memory
    * Merge
    * NDB


## 2.MySQL基准测试

针对系统设计的一种压力测试，通常的目标是为了掌握系统的行为。

### 基准测试策略

* 整体测试
* 单独测试

### 测试指标

* 吞吐量
    单位时间内的事务处理数
* 响应时间或延迟* 并发性
* 可扩展性

### 获取系统性能和状态
* cpu使用率
* 磁盘I/O
* 网络流量统计
* `show global status`
* `show engine innodb status`
* `show full processlist`

绘图工具gnuplot

### 测试工具

* 集成测试
    * [ab](http://httpd.apache.org/docs/2.0/programs/ab.html)
    * [http_load](http://www.acme.com/software/http_load/)
* 单组建测试
    * [sysbench](https://github.com/akopytov/sysbench)
    * [mysqlslap](https://dev.mysql.com/doc/refman/8.0/en/mysqlslap.html)
    * mysql函数benchmark()

## 3.服务器性能剖析

测量任务所花费的时间，然后对结果进行统计和排序，将重要的任务放在前面
数据库测量


### 应用程序测量
* [NEW Relic](https://newrelic.com/)
* [xhprof](http://pecl.php.net/package/xhprof)
* [ifp](http://code.google.com/p/instrumentation-for-php)


### 剖析mysql查询
* 慢查询日志，开销最低，精度最高
* 工具pt-query-digest
* `show profile`
* `flush status` `show status`
* 使用Performance Schema
* explain是估计得到的结果
* 计数器是实际的测量结果

## 4.Schema与数据类型优化
## 5.创建高性能的索引
## 6.查询性能优化
## 7.MySQL高级特性
## 8.优化服务器设置
## 9.操作系统和硬件优化
## 10.复制
## 11.可扩展的MySQL
## 12.高可用性
## 13.云端的MySQL
## 14.应用层优化
## 15.备份与恢复
## 16.MySQL用户工具