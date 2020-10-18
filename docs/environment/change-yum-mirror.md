更换yum源为阿里云，加速国内软件安装速度
==================================

适用于CentOS7.x

```bash
# 更换base源为阿里云
mv /etc/yum.repos.d/CentOS-Base.repo /etc/yum.repos.d/CentOS-Base.repo.bak
wget -O /etc/yum.repos.d/CentOS-Base.repo http://mirrors.aliyun.com/repo/Centos-7.repo

# 安装epel源并更换为阿里云，epel源为base源的扩展
yum install -y epel-release
wget -O /etc/yum.repos.d/epel.repo http://mirrors.aliyun.com/repo/epel-7.repo

# 安装remi源并更换为阿里云，remi是PHP软件源
yum install -y http://mirrors.aliyun.com/remi/enterprise/remi-release-7.rpm
sed -i 's/^#baseurl/baseurl/' /etc/yum.repos.d/remi*
sed -i 's/^mirrorlist/#mirrorlist/' /etc/yum.repos.d/remi*
sed -i 's/rpms.remirepo.net/mirrors.aliyun.com\/remi/' /etc/yum.repos.d/remi*

# 更换PHP的base源为remi源，比如7.2
yum install -y yum-utils && yum-config-manager --enable remi-php72

# 新增nginx源
cat > /etc/yum.repos.d/nginx.repo << EOF
# http://nginx.org/en/linux_packages.html
[nginx-stable]
name=nginx stable repo
baseurl=http://nginx.org/packages/centos/$releasever/$basearch/
gpgcheck=1
enabled=1
gpgkey=https://nginx.org/keys/nginx_signing.key
module_hotfixes=true
EOF

# 新增MySQL官方源
yum install -y http://dev.mysql.com/get/mysql57-community-release-el7-8.noarch.rpm

# 新增MariaDB阿里云源
cat > /etc/yum.repos.d/MariaDB.repo << EOF
[mariadb]
name=MariaDB 10.5
baseurl=http://mirrors.aliyun.com/mariadb/yum/10.5/centos7-amd64
gpgkey=http://mirrors.aliyun.com/mariadb/yum/RPM-GPG-KEY-MariaDB
gpgcheck=1
EOF

# 重新建立缓存
yum clean all && yum makecache

# 安装软件示例，mysql和MariaDB二选一
yum install -y nginx
yum install -y mysql-community-server
yum install -y MariaDB-server
yum install php php-fpm php-gd php-curl php-pdo php-mysql

# 查看软件安装的文件
rpm -ql nginx

# yum源列表
yum repolist
```