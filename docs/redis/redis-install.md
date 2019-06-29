Redis的安装
=============

## Windows

安装包下载地址：<https://github.com/microsoftarchive/redis/releases>

## Linux

### Yum安装

```bash
yum -y install redis
```

### 源码安装

```bash
cd
yum -y install gcc wget
wget http://download.redis.io/releases/redis-stable.tar.gz
tar zxf redis-stable.tar.gz
cd redis-stable
make MALLOC=libc
mkdir /usr/local/redis
cp redis.conf src/redis-server src/redis-cli src/redis-benchmark src/redis-check-aof src/redis-check-rdb src/redis-sentinel src/redis-trib.rb /usr/local/redis
cd /usr/local/redis
./redis-server redis.conf
```
