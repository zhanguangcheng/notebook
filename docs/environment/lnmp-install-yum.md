CentOS之LNMP yum安装
===================

## 环境

* Linux:CentOS-7-x86_64-Minimal-1611
* nginx:1.10.2
* MySQL:5.7.18
* PHP:7.0.19


## 增加软件源

```bash
# CentOs 6.x
rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-6.noarch.rpm
rpm -Uvh http://mirror.webtatic.com/yum/el6/latest.rpm
rpm -Uvh https://dev.mysql.com/get/mysql57-community-release-el6-11.noarch.rpm

# CentOs 7.x
rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
rpm -Uvh http://mirror.webtatic.com/yum/el7/webtatic-release.rpm
rpm -Uvh http://dev.mysql.com/get/mysql57-community-release-el7-8.noarch.rpm

yum -y update
```


## 安装MySQL、nginx、PHP

```bash
yum -y install mysql-community-server
yum -y install nginx
yum -y install php70w-fpm php70w-cli php70w-gd php70w-pdo php70w-mysql php70w-xml php70w-mbstring php70w-opcache php70w-pgsql php70w-intl php70w-mcrypt php70w-soap
```


## 启动

```bash
systemctl start mysqld php-fpm nginx
systemctl enable mysqld php-fpm nginx
```


## 配置文件路径

* /etc/my.cnf
* /etc/nginx/*
* /usr/share/nginx/*
* /etc/php.ini
* /etc/php.d/*
* /etc/php-fpm.conf
* /etc/php-fpm.d/www.conf


## 注意事项

**防火墙 firewalld**
```bash
systemctl stop firewalld
```

**临时关闭 selinux**

> 永久关闭在配置文件`/etc/selinux/config`中

```bash
setenforce 0
```

*[nginx配置](https://github.com/zhanguangcheng/notebook/tree/master/code/nginx/etc/nginx)*

*查看mysql默认设置的密码:*

```bash
grep 'password' /var/log/mysqld.log
```

*测试环境可以设置:*

```bash
[mysqld]
validate_password = off
```

## Reference

* <http://www.centoscn.com/mysql/2016/0626/7537.html>
* <http://www.cnblogs.com/grimm/p/5300819.html>
* <https://webtatic.com/projects/yum-repository/>
* <https://dev.mysql.com/downloads/repo/yum/>
