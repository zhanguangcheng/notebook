Redis的安装与使用
================

> Redis is an in-memory database that persists on disk. The data model is key-value, but many different kind of values are supported: Strings, Lists, Sets, Sorted Sets, Hashes, HyperLogLogs, Bitmaps.

官网：
<https://redis.io>

github地址：<https://github.com/antirez/redis>


## 安装

> 环境：Centos7.0  
> 现在（2017-12-17）安装的Redis的为最新版4.0.6。

1.环境需求准备

gcc、gcc-c++编译器、wget下载工具，如已安装，进行下一步。

```shell
yum -y install gcc gcc-c++ wget
```

2.下载Redis源码包

```shell
wget https://github.com/antirez/redis/archive/4.0.6.tar.gz
```

3.安装&运行

```shell
cd redis-4.0.6

# 使用libc为分配器编译，默认为jemalloc会报错：“jemalloc/jemalloc.h：没有那个文件或目录”
# 安装完毕后在`src`目录中有`redis-server`、`redis-cli`等文件时则表示安装成功。
make MALLOC=libc

# 复制编译好的程序到软件安装目录
mkdir /usr/local/redis
cp src/redis-cli src/redis-server redis.conf /usr/local/redis

# 编辑redis.conf，把参数daemonize no 改为 daemonize yes（表示后台运行），然后运行。
cd /usr/local/redis
./redis-server redis.conf
```


## PHP简单操作Redis

安装PHP的客户端Redis参考 [CentOS之LNMP yum安装的PHP安装部分](../environment/lnmp-install-yum.md#安装mysqlnginxphp)

```php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
if ($redis) {
    $redis->set('name', 'Grass');
    echo $redis->get('name');
    $redis->close();
} else {
    echo 'error';
}
```


## 扩展阅读

文件说明

* `redis-benchmark`        压力测试
* `redis-check-aof`        检查redis持久化命令文件的完整性
* `redis-check-dump`       检查redis持久化数据文件的完整性
* `redis-cli`              redis在linux上的客户端
* `redis-sentinel`         做集群用的
* `redis-server`           linux上的服务端

更多信息

* [A PHP extension for Redis](https://github.com/phpredis/phpredis)
* [Redis配置详细介绍](http://blog.csdn.net/neubuffer/article/details/17003909)
* [PHP Redis中文手册](http://www.cnblogs.com/ikodota/archive/2012/03/05/php_redis_cn.html)
* [Windows版的Redis安装](https://github.com/MicrosoftArchive/redis)
