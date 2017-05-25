
```bash
http://www.centoscn.com/mysql/2016/0626/7537.html
https://dev.mysql.com/downloads/repo/yum/
Linux:CentOS-7-x86_64-Minimal-1611
nginx:1.10.2
MySQL:5.7.18
PHP:7.0.19


yum -y install wget vim

#更新 yum 源,自带的源没有 PHP5.6 : 
rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm
rpm -Uvh http://dev.mysql.com/get/mysql57-community-release-el7-8.noarch.rpm

#安装 epel: 
yum install epel-release

#然后更新下系统: 
yum -y update

#MySQL
yum -y install mysql-community-server
systemctl start mysqld
systemctl enable mysqld
grep 'temporary password' /var/log/mysqld.log
validate_password = off
set password=password('root')


#nginx
yum -y install nginx
systemctl start nginx
systemctl enable nginx

#PHP
yum -y install php70w-fpm php70w-cli php70w-gd php70w-pdo php70w-mysql php70w-xml php70w-mbstring php70w-opcac he php70w-pgsql php70w-intl php70w-mcrypt php70w-soap
systemctl start php-fpm
systemctl enable php-fpm

-A INPUT -p tcp -m state --state NEW -m tcp --dport 80 -j ACCEPT
systemctl restart iptables

setenforce 0
```
