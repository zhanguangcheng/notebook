---
layout: post
title: LNMP编译安装过程
tags: Linux PHP MySQL Nginx
categories: 环境
---

* TOC
{:toc}

## 环境

* CentOS6.6 64位 Basic Server

## 文件列表

> 下载地址1: http://ofyijnqas.bkt.clouddn.com/PHP5.6_nginx1.8_MySQL5.7.tar.zip  

> 下载地址2: http://pan.baidu.com/s/1jI7CtP8  

* autoconf-2.13.tar.gz 生成可以自动地配置软件源代码(MakeFile文件)
* curl-7.42.1.tar.gz 利用URL规则在命令行下工作的文件传输工具
* freetype-2.4.12.tar.gz 字体引擎
* jpegsrc.v6b.tar.gz jpg图片库
* libgd-2.1.0.tar.gz gd库（图片处理）
* libmcrypt-2.5.8.tar.gz 加密库
* libpng-1.4.1.tar.gz png图片库
* libtool-2.2.tar.gz 一个用户库安装工具，自动处理库的依赖关系
* libxml2-2.9.1.tar.gz xml功能库
* zlib-1.2.3.tar.gz 数据压缩库
* mcrypt-2.6.8.tar.gz 加密库(需先安装libmcrypt)
* mhash-0.9.9.9.tar.gz 加密库(需先安装libmcrypt)
* ncurses-5.9.tar.gz 字符终端处理库
* pcre-8.36.tar.gz 包括 perl 兼容的正则表达式库
* nginx-1.8.0.tar.gz
* php-5.6.16.tar.gz
* boost_1_59_0.tar.gz MySQL5.7必须
* mysql-5.7.15.tar.gz

## 装备工作&注意事项

* 上传文件`PHP5.6_nginx1.8_MySQL5.7.tar.zip`到`~/tar/`目录
* 安装过程中不能出现 `error` `错误` 字样, 如果出现应立即排查解决


## 执行过程

```shell

#进入软件包目录
cd ~/tar

#解压软件包
unzip PHP5.6_nginx1.8_MySQL5.7.tar.zip

#解压所有安装包(.tar.gz结尾的)
for i in *.tar.gz;do tar zxvf $i;done

#安装基础库
yum -y gcc gcc-c++ install lrzsz cmake bison openssl openssl-devel python-devel libXpm libXpm-devel
yum -y install c-ares-devel

#安装autoconf
cd ~/tar/autoconf-2.13
./configure --prefix=/usr/local/autoconf
make && make install

#安装libmcrypt
cd ~/tar/libmcrypt-2.5.8
./configure --prefix=/usr/local/libmcrypt
make && make install

#安装libltdl
cd ~/tar/libmcrypt-2.5.8/libltdl
./configure --enable-ltdl-install
make && make install

#安装mhash
cd ~/tar/mhash-0.9.9.9
./configure
make && make install

#安装freetype
cd ~/tar/freetype-2.4.12
./configure --prefix=/usr/local/freetype/
make && make install

#安装libxml2
cd ~/tar/libxml2-2.9.1
./configure --prefix=/usr/local/libxml2/
make && make install

#安装zlib
cd ~/tar/zlib-1.2.3
./configure
make
make install >> ~/zlib.log

#安装curl
cd ~/tar/curl-7.42.1
./configure --prefix=/usr/local/curl --enable-ares --without-nss --with-ssl
make && make install

#安装ncurses
cd ~/tar/ncurses-5.9
./configure --with-shared --without-debug --without-ada --enable-overwrite
make && make install

#安装libpng
cd ~/tar/libpng-1.4.1
./configure --prefix=/usr/local/libpng
make && make install

#安装libtool
cd ~/tar/libtool-2.2
./configure --prefix=/usr/local/libtool
make && make install

#安装jpeg6
cd ~/tar/jpeg-6b/
mkdir /usr/local/jpeg6
mkdir /usr/local/jpeg6/bin
mkdir /usr/local/jpeg6/lib
mkdir /usr/local/jpeg6/include
mkdir -p /usr/local/jpeg6/man/man1
./configure --prefix=/usr/local/jpeg6/ --enable-shared --enable-static
\cp /usr/local/libtool/share/libtool/config/config.sub .
\cp /usr/local/libtool/share/libtool/config/config.guess .
make && make install

#安装gd2
cd ~/tar/libgd-2.1.0
./configure --prefix=/usr/local/gd2/ --with-jpeg=/usr/local/jpeg6/ --with-freetype=/usr/local/freetype/ --with-png=/usr/local/libpng/ #gd2.1
make && make install

#安装pcre
cd ~/tar/pcre-8.36
./configure
make && make install
ln -s /usr/local/lib/libpcre.so.1 /lib

#安装nginx
#Configuration summary
#  + using system PCRE library
#  + using system OpenSSL library
#  + md5: using OpenSSL library
#  + sha1: using OpenSSL library
#  + using system zlib library
cd ~/tar/nginx-1.8.0
groupadd www
useradd -s /sbin/nologin -g www www
./configure --user=www --group=www --prefix=/usr/local/nginx --with-http_stub_status_module --with-http_ssl_module --with-http_spdy_module --with-http_gzip_static_module --with-ipv6 --with-http_sub_module
make && make install

#安装php
cd ~/tar/php-5.6.16
./configure --prefix=/usr/local/php/ --with-config-file-path=/usr/local/php/etc/ --with-fpm-user=www --with-fpm-group=www  --with-mysql=mysqlnd --with-libxml-dir=/usr/local/libxml2/ --with-jpeg-dir=/usr/local/jpeg6/ --with-png-dir=/usr/local/libpng/ --with-freetype-dir=/usr/local/freetype/ --with-gd=/usr/local/gd2/ --with-mcrypt=/usr/local/libmcrypt/ --with-mysqli=mysqlnd  --with-gettext --enable-inline-optimization --with-curl=  --with-pdo-mysql=mysqlnd --with-mysql-sock=/tmp/mysql.sock --enable-soap --enable-mbstring=all --enable-sockets  --without-pear --enable-fpm --enable-xml --enable-ftp  --enable-opcache
make && make install

#安装MySQL(略慢)
mkdir -p /data/mysql
useradd -s /sbin/nologin -g mysql mysql
cd ~/tar/mysql-5.7.15
cmake . -DCMAKE_INSTALL_PREFIX=/usr/local/mysql -DMYSQL_DATADIR=/data/mysql -DDOWNLOAD_BOOST=1 -DWITH_BOOST=../boost_1_59_0 -DSYSCONFDIR=/etc -DWITH_INNOBASE_STORAGE_ENGINE=1 -DWITH_PARTITION_STORAGE_ENGINE=1 -DWITH_FEDERATED_STORAGE_ENGINE=1 -DWITH_BLACKHOLE_STORAGE_ENGINE=1 -DWITH_MYISAM_STORAGE_ENGINE=1 -DENABLED_LOCAL_INFILE=1 -DENABLE_DTRACE=0 -DDEFAULT_CHARSET=utf8mb4 -DDEFAULT_COLLATION=utf8mb4_general_ci -DWITH_EMBEDDED_SERVER=1
make -j `grep processor /proc/cpuinfo | wc -l`
make install

#复制nginx php php-fpm mysql配置文件
cp /usr/local/php/etc/php-fpm.conf.default /usr/local/php/etc/php-fpm.conf
\cp ~/tar/nginx.conf /usr/local/nginx/conf/nginx.conf
cp ~/tar/php-5.6.16/php.ini-production /usr/local/php/etc/php.ini
\cp ~/tar/my.cnf /etc/my.cnf

#初始化MySQL 账号:root 密码:空
/usr/local/mysql/bin/mysqld --initialize-insecure --user=mysql --basedir=/usr/local/mysql --datadir=/data/mysql

#修改配置文件
sed -i '25a pid = run/php-fpm.pid' /usr/local/php/etc/php-fpm.conf

#安装nginx php-fpm mysql控制脚本并加入开机启动
cp ~/tar/init.d.php-fpm56.sh /etc/init.d/php-fpm
cp ~/tar/init.d.nginx18.sh /etc/init.d/nginx
cp /usr/local/mysql/support-files/mysql.server /etc/init.d/mysqld

chmod +x /etc/init.d/php-fpm
chmod +x /etc/init.d/nginx
chmod +x /etc/init.d/mysqld

chkconfig --add nginx
chkconfig --add php-fpm
chkconfig --add mysqld
chkconfig nginx on
chkconfig php-fpm on
chkconfig mysqld on


#加入环境变量
sed -i '$a export PATH=/usr/local/php/bin/:$PATH' ~/.bash_profile
sed -i '$a export PATH=/usr/local/mysql/bin/:$PATH' ~/.bash_profile

#启动nginx php-fpm mysql
service php-fpm start
service nginx start
service mysql start

#测试
mkdir /www
echo -e '<?php\n    phpinfo();' > /www/index.php

```

