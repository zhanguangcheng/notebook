Memcache的安装和使用
===================

##  Memcache简介:

官网：<http://memcached.org/>

github地址：<https://github.com/memcached/memcached>

>高性能的分布式的内存对象缓存系统  
>Key-value型存储 

## Linux下安装:

1. 需要工具:gcc,make,cmake,autoconf,libtool
2. 分别到 libevent.org 和 memcached.org下载最新的 stable 版本(稳定版).
3. 安装memcache之前需要安装libevent
4. `cd libevent-2.0.21-stable`
5. `./configure --prefix=/usr/local/libevent`
6. 如果出错,读报错信息,查看原因,一般是缺少库
7. `make && make install`
8. `cd memcached-1.4.5`
9. `./configure--prefix=/usr/local/memcached --with-libevent=/usr/local/libevent`
10. `make && make install`


## 启动memcached:
`/usr/local/memcached/bin/memcached -m 64 -p 11211 -l 192.168.25.115 -u nobody -d`

### 选项

* m:内存分配大小,单位MB,默认64MB
* p:监听的端口,默认11211
* l:本机ip
* u:用那个用户来运行
* d:后台运行
* c:最大的连接数

### 运行参数
* -d install 安装memcached
* -d uninstall 卸载memcached
* -d start 启动memcached服务
* -d restart 重启memcached服务
* -d stop 停止memcached服务
* -d shutdown 停止memcached服务

## 客服端连接和使用:
> 使用telnet协议连接

* 设置 set add replace
* 获得 get
* 删除 delete flush_all
* 断开 quit

`set 键名 是否压缩(0|1) 失效时间(秒|时间戳) 字节数`
内容

`get 键名`

## PHP安装memcache:
* 下载http://pecl.php.net/package/memcache
* `cd memcache-3.0.8`
* `/usr/local/php/bin/phpize` #动态添加库文件
* `./configure -enable-memcache --with-php-config=/usr/local/php/bin/php-config --with-zlib-dir`
* `cd /usr/local/php/lib/php/extensions/no-debug-zts-20100525/`  #(上面安装好的目录,看看有没有)
* 添加php.ini->  extension=memcache.so
* 重启apache


## Memcache对象:
- Memcache::add — 增加一个条目到缓存服务器
- Memcache::addServer — 向连接池中添加一个memcache服务器
- Memcache::close — 关闭memcache连接
- Memcache::connect — 打开一个memcached服务端连接
- Memcache::decrement — 减小元素的值
- Memcache::delete — 从服务端删除一个元素
- Memcache::flush — 清洗（删除）已经存储的所有的元素
- Memcache::get — 从服务端检回一个元素
- Memcache::getExtendedStats — 缓存服务器池中所有服务器统计信息
- Memcache::getServerStatus — 用于获取一个服务器的在线/离线状态
- Memcache::getStats — 获取服务器统计信息
- Memcache::getVersion — 返回服务器版本信息
- Memcache::increment — 增加一个元素的值
- Memcache::pconnect — 打开一个到服务器的持久化连接
- Memcache::replace — 替换已经存在的元素的值
- Memcache::set — Store data at the server
- Memcache::setCompressThreshold — 开启大值自动压缩
- Memcache::setServerParams — 运行时修改服务器参数和状态

## stats返回数据说明:
- pid     memcache服务器的进程ID
- uptime     服务器已经运行的秒数
- time     服务器当前的unix时间戳
- version     memcache版本
- pointer_size     当前操作系统的指针大小（32位系统一般是32bit）
- rusage_user     进程的累计用户时间
- rusage_system     进程的累计系统时间
- curr_items     服务器当前存储的items数量
- total_items     从服务器启动以后存储的items总数量
- bytes     当前服务器存储items占用的字节数
- curr_connections     当前打开着的连接数
- total_connections     从服务器启动以后曾经打开过的连接数
- connection_structures     服务器分配的连接构造数
- cmd_get     get命令（获取）总请求次数
- cmd_set     set命令（保存）总请求次数
- get_hits     总命中次数
- get_misses     总未命中次数
- evictions     为获取空闲内存而删除的items数（分配给memcache的空间用满后需要删除旧的items来得到空间分配给新的items）
- bytes_read     总读取字节数（请求字节数）
- bytes_written     总发送字节数（结果字节数）
- limit_maxbytes     分配给memcache的内存大小（字节）
- threads     当前线程数

## 缓存失效问题:

> 缓存过期

    在执行get命令的时候才会执行删除,采用了懒惰模式处理方法

> 空间已满

    会删除get次数最少的缓存项,(RLU 策略)

## 实例:

> 单一memcache服务器:

```php
<?php
$memcache = new Memcache();
$memcache->connect('192.168.25.115',11211);
$memcache->set('xiaocao','hello,world',0,3600);
echo $memcache->get('xiaocao');
$memcache->close();
```

> 集群memcache服务器:

```php
<?php
$memcache = new Memcache();
$memcache->addServer('192.168.25.115',11211);
$memcache->addServer('127.0.0.1',11211);
.......
```

## 注意事项:
1. 键最大长度为255字节,值的最大值为1MB
2. (增删改)需要清空缓存,查不用
3. 集群服务器的ip列表顺序要一致
4. 可以保存复合数据类型(自动序列化),保存标量会被转换成字符串
5. 缓存的key值要加上自定义的前缀,防止数据覆盖
6. Memcache的过期时间最大为30天
7. `Memcache::addServer`默认为持久化连接，无需手动close
8. Memcache服务是不安全的，注意防火墙的配置


分布式集群架构图:
![分布式集群架构图](../images/memcache.png)


## 其他

### Web客户端

[A GUI Administration for memcached](https://github.com/junstor/memadmin)