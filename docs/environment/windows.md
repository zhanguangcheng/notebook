Windows 绿色版软件开发环境
===================

## 软件环境列表

* [Apache2.4.25](http://ofyijnqas.bkt.clouddn.com/apache-2.4.25.7z)
* [MySQL 5.6.35](http://ofyijnqas.bkt.clouddn.com/mysql-5.6.35.7z)
* [PHP 7.1.3: vc14-ts-x86](http://ofyijnqas.bkt.clouddn.com/php-7.1.3.7z)
* [PHP 5.6.30: vc11-ts-x86](http://ofyijnqas.bkt.clouddn.com/php-5.6.30.7z)
* [PHP 5.3.28: vc9-ts-x86](http://ofyijnqas.bkt.clouddn.com/php-5.3.28.7z)
* [nodejs 4.2.3](http://ofyijnqas.bkt.clouddn.com/nodejs-4.2.3.7z)
* [Memcached 1.2.6](http://ofyijnqas.bkt.clouddn.com/memcached-1.2.6.7z)
* [Git 2.12.1](http://ofyijnqas.bkt.clouddn.com/git-2.12.1.7z)
* [Curl 7.53.1](http://ofyijnqas.bkt.clouddn.com/curl7.53.1.7z)
* [Java 1.8.0_40](http://ofyijnqas.bkt.clouddn.com/java1.8.0.7z)
* [Yui compressor 2.4.8](http://ofyijnqas.bkt.clouddn.com/yuicompressor2.4.8.7z)
* [Redis 3.2.100](http://ofyijnqas.bkt.clouddn.com/redis3.2.100.7z)
* [Ruby 2.3.3 + Sass 3.4.23](http://ofyijnqas.bkt.clouddn.com/ruby2.3.3.7z)
* [Python 3.6.1](http://ofyijnqas.bkt.clouddn.com/python3.6.1.7z)
* [Ctags 5.8](http://ofyijnqas.bkt.clouddn.com/ctags5.8.7z)

### 注意事项

* 确保你的系统为64位系统
* Apache配置的`DocumentRoot`目录为`D:/www`, 请务必创建之
* 如果Apache不能启动, 尝试安装对应的vc库
* php5apache2_2.dll表示apache2.2.\*的版本才能用

## 使用方法

1. 下载需要的软件环境包 (点击**软件环境列表**中的软件即可)
2. 将下载后的软件环境包解压到`C:\greenEnvironment`
3. 将对应的软件环境加入环境变量
4. 将对应的软件环境加入服务, 如Apache、MySQL、Memcached 等
5. 走你

### 环境变量 PATH

```
C:\greenEnvironment\apache\2.4.25\bin;
C:\greenEnvironment\mysql\5.6.35\bin;
C:\greenEnvironment\nodejs\4.2.3;
C:\greenEnvironment\php\5.6.30;
C:\greenEnvironment\memcached\1.2.6;
C:\greenEnvironment\git\2.12.1\bin;
C:\greenEnvironment\curl\7.53.1;
C:\greenEnvironment\java\1.8.0\bin;
C:\greenEnvironment\redis\3.2.100;
C:\greenEnvironment\ruby\2.3.3\bin;
C:\greenEnvironment\python\3.6.1;
C:\greenEnvironment\ctags\5.8;
```

### 服务创建

```bash
# Apache
sc create 0_Apache binPath= "C:\greenEnvironment\apache\2.4.25\bin\httpd.exe -k runservice" start= auto

# MySQL
sc create 0_MySQL binPath= "C:\greenEnvironment\mysql\5.6.35\bin\mysqld.exe 0_MySQL" start= auto

# Memcached
sc create 0_Memcached binPath= "C:\greenEnvironment\memcached\1.2.6\memcached.exe -d runservice" start= auto

# Redis
sc create 0_Redis binPath= "C:\greenEnvironment\redis\3.2.100\redis-server.exe --service-run" start= auto

# 其他服务命令
net start 服务名称
net stop 服务名称
sc delete 服务名称
```

## 测试安装状态

```bash
httpd -v
mysql --version
php -v
composer --version
node -v
npm -v
curl -v
java -version
redis-server -v
ruby -v
gem -v
python -V
memcached -h
ctags --version
```

## 官网原始下载地址

```
Apache:
    http://www.apachehaus.com/cgi-bin/download.plx

PHP:
    http://windows.php.net/downloads/releases/archives/

MySQL:
    https://dev.mysql.com/downloads/mysql/
    https://dev.mysql.com/get/Downloads/MySQL-5.6/mysql-5.6.35-winx64.zip

PHP扩展:
    http://pecl.php.net/
    http://windows.php.net/downloads/
    http://windows.php.net/downloads/pecl/releases/

node:
    https://nodejs.org/en/download/

composer:
    https://getcomposer.org/download/

git:
    https://git-scm.com/download/win

yuicompressor:
    https://github.com/yui/yuicompressor/releases

redis:
    https://github.com/MSOpenTech/redis/releases

ruby:
    http://rubyinstaller.org/downloads/

python:
    https://www.python.org/downloads/windows/

ctags:
    http://ctags.sourceforge.net/

VC库:
    VC9-x86:https://www.microsoft.com/zh-CN/download/details.aspx?id=5582
    VC9-x64:https://www.microsoft.com/zh-CN/download/details.aspx?id=15336
    VC11-x86&x64:https://www.microsoft.com/zh-CN/download/details.aspx?id=30679
    VC14-x86&x64:https://www.microsoft.com/zh-CN/download/details.aspx?id=48145
```

## 问题

* PHP的curl扩展不生效解决方法:

```
将文件:

    libeay32.ll
    ssleay32.dll
    libssh2.dll
    ext/php_curl.dll

复制到以下两个目录:

    C:\windows\system32
    C:\windows\syswow64
```

* PHP的imagick扩展安装方法:

<https://mlocati.github.io/articles/php-windows-imagick.html>
