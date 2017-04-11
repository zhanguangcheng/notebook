Linux命令之logrotate
====================

# 概述  

> logrotate是一个日志的管理工具。  
> 可以按照指定的规则对日志进行压缩、切割、轮替、转存等。

# 命令格式  

```shell
logrotate [选项] 配置文件
```

选项:  

* -d 调试日志轮替结果 debug
* -v 显示日志轮替过程
* -f 强制执行轮替

示例:  

```shell
logrotate -d /etc/logrotate.conf #查看一下下次日志轮替结果
logrotate -f /etc/logrotate.conf #强制执行一下日志轮替
```

配置文件:  

* /etc/logrotate.conf  
* /etc/logrotate.d/*

> `/etc/logrotate.conf`为主配置文件  
> `/etc/logrotate.d/`目录下文件的为子配置文件  
> 子配置文件优先级大于主配置文件, 所以在子配置文件的设置会覆盖主配置文件中的设置
 
## 配置文件语法   

```
* include       选项读取其他配置文件
* daily         日志转存周期为每天
* weekly        日志转存周期为每周
* monthly       日志转存周期为每月
* rotate 数字   保留的日志文件个数, 0值没有备份
* compress      将日志进行压缩(gzip)
* nocompress    不压缩日志
* mail address  把转存的日志文件发送到指定的E-mail 地址
* nomail        转存时不发送日志文件
* missingok     日志文件不存在, 则忽略警告信息
* notifempty    如果是空文件的话，不转存
* minsize 大小  日志转存的最小值
* size 大小     日志只有大于指定大小才进行日志轮替,而不是按照时间轮替
* dateext       使用日期作为转存日志的后缀log-20160915(默认配置)
* create [权限] [用户] [组] 使用指定的用户、权限、组来创建日志文件
* sharedscripts 所有日志文件都轮转完毕后统一执行一次脚本
* prerotate     在转存之前需要执行的命令的<起始标签对>
* postrotate    在转存之后需要执行的命令的<起始标签对>
* endscript     在转存之前/之后需要执行的命令的<结束标签对>
```

> 大小单位: bytes(默认)以及KB (5k)或者MB (50M).

# 案例  

## Apache日志轮替

* 轮替访问日志和错误日志
* 每天轮替, 保留最近10次轮替日志
* 不进行压缩
* 最小50M日志文件才进行轮替
* 轮替完毕后需要告知Apache重新加载配置文件, 否则会继续往轮替后的日志文件中写入日志 

```shell
vi /etc/logrotate.d/apache
```

```shell
/usr/local/apache2/logs/access_log
/usr/local/apache2/logs/error_log
{
    daily
    rotate 10
    nocompress
    minsize 50M

    sharedscripts
    postrotate
        if [ -f /usr/local/apache2/logs/httpd.pid ];then
            kill -1 $(cat /usr/local/apache2/logs/httpd.pid);
        fi
    endscript
}
```

## Nginx日志轮替

* 轮替所有日志
* 每天轮替, 保留最近一个月的日志
* 日志为空不进行轮替
* 最小50M日志文件才进行轮替
* 轮替完毕后需要告知Nginx重新加载配置文件, 否则会继续往轮替后的日志文件中写入日志 


```shell
vi /etc/logrotate.d/nginx
```

```shell
/usr/local/nginx/logs/*.log
{
    daily
    rotate 30
    nocompress
    notifempty
    minsize 50M

    sharedscripts
    postrotate
        if [ -f /usr/local/nginx/logs/nginx.pid ];then
            kill -USR1 $(cat /usr/local/nginx/logs/nginx.pid);
        fi
    endscript
}
```

# 其他  
