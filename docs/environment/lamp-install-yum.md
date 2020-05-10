CentOS之LAMP yum安装
===================

## 环境

* Linux:CentOS-7-x86_64-Minimal-1611
* PHP:7.2
* Apache:2.4
* MySQL:5.7


```
yum -y update
```

## PHP

```bash
rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
rpm -Uvh http://mirror.webtatic.com/yum/el7/webtatic-release.rpm
yum -y install php72w php72w-cli php72w-gd php72w-pdo php72w-mysql php72w-xml php72w-mbstring php72w-opcache php72w-pgsql php72w-intl php72w-mcrypt php72w-soap php72w-pecl-memcached php72w-pecl-redis
```

## Apache

```bash
yum -y install httpd
systemctl start httpd
systemctl enable httpd
```

## MySQL

```bash
rpm -Uvh http://dev.mysql.com/get/mysql57-community-release-el7-8.noarch.rpm
yum -y install mysql-community-server
systemctl start mysqld
systemctl enable mysqld
```
