Redis
==========

[TOC]

## 是什么？

[Redis](https://redis.io/)是开源、远程的非关系型内存数据库

## 特点

* 提供了丰富的数据类型帮助用户解决问题
* 通过复制、持久化和事务等手段保证数据的完整性
* 多数据库
* 单线程
* 支持分布式


## 常用命令

### Keys
* `TYPE` 获取key的存储类型，如、string、list、hash、set、zset等
* `KEYS pattern` 查找所有符合[模式pattern](#模式pattern)的key 
* `EXISTS key` 检测key是否存在 
* `DEL key [key ...]` 删除指定的一个或多个key
* `SCAN cursor [MATCH pattern] [COUNT count]` 增量迭代key
* `EXPIRE key seconds` 设置一个key的过期的秒数
* `TTL key` 获取一个key的过期的秒数

### Strings
* `GET key`  获取key的值
* `SET key value [EX seconds]` 设置key的值
* `SETNX key value` 设置key的值，如果不存在（if **n**ot e**x**ists）
* `MGET key [key ...]` 获取多个key的值
* `MSET key value [key value ...]` 设置多个key的值
* `INCR key` 自增数字1
* `INCRBY key increment` 自增数字increment
* `DECR key` 自减数字1
* `DECRBY key decrement` 自减数字decrement

### Hashes
* `HKEYS key` 获取hash所有的字段
* `HSET key field value` 设置hash字段的值
* `HGET key field` 获取hash字段的值
* `HDEL key field [field ...]` 删除hash的字段
* `HEXISTS key field` 检测hash中的字段是否存在
* `HMGET key field [field ...]` 获取hash多个字段的值
* `HMSET key field value [field value ...]` 设置hash多个字段的值

### Lists
* `LRANGE key start stop` 获取list中范围内的元素，下标从0开始，负数表示倒数
* `LPUSH key value [value ...]` 从list的左边入队一个或多个元素
* `LPOP key` 从list的左边出队一个元素
* `RPUSH key value [value ...]` 从list的右边入队一个或多个元素` 
* `RPOP key` 从list的右边出队一个元素
* `LLEN` 获取list的长度
* `LTRIM key start stop` 修剪到指定范围内的list

### Sets
* `SMEMBERS key` 获取集合里面所有的元素
* `SADD key member [member ...]` 添加一个或多个成员到集合中
* `SREM key member [member ...]` 从集合中删除一个或多个成员
* `SISMEMBER key member` 检测集合中的成员是否存在
* `SCARD key` 获取集合中的元素数量
* `SDIFF key [key ...]` 获取集合差集
* `SINTER key [key ...]` 获取集合并集

### Sorted Sets
* `ZADD key score member [score member ...]` 添加一个或多个成员第有序集合中
* `ZRANGE key start stop` 获取有序集合中范围内的元素
* `ZCARD` 获取有序集合中元素数量
* `ZREM key member [member ...]` 从有序集合中删除一个或多个成员

### Transitions
* `MULTI` 开始事务
* `EXEC` 提交事务
* `DISCARD` 回滚事务

### Server
* `INFO [section]` 返回服务器各种信息和统计数据
* `DBSIZE` 返回当前数据库的 key 的数量
* `CONFIT GET parameter` 获取指定配置参数的值
* `CONFIG SET parameter value` 设置指定配置参数的值
* `CONFIG REWRITE` 将当前配置重写到配置文件中（启动redis时指定的配置文件）
* `FLUSHDB` 删除当前数据库中所有的key
* `FLUSHALL` 删除所有数据库中的key

### Connection

* `SELECT index` 切换到指定的数据库，连接后默认为0
* `AUTH password` 验证服务端密码
* `QUIT` 关闭连接，退出


## 应用场景
* 缓存
* 计数器
* 队列
* 数据存储


## 持久化
* RDB
    * save 同步，大数据会阻塞
    * bgsave 异步，fork子进程save
* AOF
    * appendonly yes


## 其他

### 模式pattern

> pattern使用了glob风格

* `?` 匹配任意一个字符
* `*` 匹配任意零个或多个字符
* `[a-c]` 匹配范围字符
