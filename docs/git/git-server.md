Git服务器搭建
============

## 环境

> CentOS6.6 64位 Basic Server

## 安装git-编译安装

```shell
# 下载链接 <https://www.kernel.org/pub/software/scm/git/>
#将git-1.7.9.1.tar.gz上传到 ~/tar/ 目录下

#解压git包
cd ~/tar
tar zxf git-1.7.9.1.tar.gz

#安装依赖库
yum -y install perl-devel perl-CPAN tcl build-essential tk gettext perl-ExtUtils-MakeMaker package curl curl-devel

#安装git
useradd git
cd ~/tar/git-1.7.9.1
./configure --prefix=/usr/local/git
make
make install
ln -s /usr/local/git/bin/git-upload-pack /usr/bin/git-upload-pack
ln -s /usr/local/git/bin/git-receive-pack /usr/bin/git-receive-pack

#加入环境变量并立即生效
echo 'export PATH=/usr/local/git/bin:$PATH' >> /etc/profile
source /etc/profile

#运行 如下命令 显示"git version 1.7.9.1"即安装成功
git --version
```

## 安装git-yum安装

```bash
yum -y install git
su -c 'adduser git'
```

## 配置rsa秘钥环境

```shell
mkdir /home/git/.ssh
touch /home/git/.ssh/authorized_keys
chown -R git:git /home/git/.ssh
chmod 700 /home/git/.ssh
chmod 600 /home/git/.ssh/authorized_keys
```

> 至此git服务器环境就搭建完毕了, 是不是很简单呢  

------------------------

> 下面演示一个正常流程  
> 从<新建项目仓库>到<用户授权>, 再简单演示一下推送一个文件

## 新建项目仓库

```shell
#所有的项目仓库都放在/repo目录下
mkdir /repo
cd /repo

#初始化项目仓库,  project1 是项目名称, 请自行修改
git --bare init project1
chown -R git:git /repo/project1
```

## 用户授权


1. 客户端生成秘钥

```shell
ssh-keygen -t rsa
```

> 第一次会提示你秘钥保存位置, 直接回车使用默认位置  
> 第二次和第三次提示你输入该秘钥的密码, 根据情况自己设置, 直接回车密码为空.  
> 使用[git bash](https://git-scm.com/downloads)操作, 不是cmd啊  

2. 将客户端生成的公钥里面的内容粘贴到服务器上`/home/git/.ssh/authorized_keys`文件中, 一行一个. 

> 公钥默认生成的位置  
Windows: C:\Users\你的用户名\\.ssh\id_rsa.pub  
Linux: ~/.ssh/id_rsa.pub  


## 客户端git初体验

>  [客户端git命令参考](http://www.xcx1.com/2016-09-04/git-command/)

```shell
git clone git@192.168.2.115:/repo/project1 myproject
#如果设置了秘钥的密码就输入
cd myproject
touch demo.txt
git add demo.txt
git commit -m 'demo'
git push origin master
```

> 使用git bash操作, 不是cmd啊  
> 192.168.2.115是git服务器的ip, 请自行修改  


## 最后说两句

### 第一次使用git bash请配置

```shell
# 配置用户名
git config --global user.name "你的名字"

# 配置邮箱
git config --global user.email "你的邮箱"
```

### 项目仓库惯例配置

> 位置：项目仓库目录下的config

```ini
[core]
    repositoryformatversion = 0
    filemode = true
    bare = true
    ignorecase = false
[receive]
    denyCurrentBranch = ignore
    denyNonFastForwards = false
```

### 安装&使用git时可能会遇到的错误解决办法

> git push的时候  
master -> master (branch is currently checked out)  
remote: error: refusing to update checked out branch: refs/heads/master  
remote: error: By default, updating the current branch in a non-bare repository  

> 原因: 这是由于git默认拒绝了push操作，需要进行设置，修改.git/config添加如下代码：

```ini
[receive]
denyCurrentBranch = ignore
```

> git clone的时候  
error: insufficient permission for adding an object to repository database ./objects

> 原因:.git仓库没有权限  

```shell
chown -R git:git .git
```

> Git在make的时候报错：Can't locate ExtUtils/MakeMaker.pm in @INC

```shell
yum -y install perl-devel perl-CPAN
#git 需要perl来编译。然后重新make
```

> Git Make时出现：tclsh failed; using unoptimized loading
MSGFMT    po/bg.msg make[1]: *** [po/bg.msg] 错误 127

```shell
yum -y install tcl  build-essential tk gettext
```
> make[1]: *** [perl.mak] Error 2

```shell
yum -y install perl-ExtUtils-MakeMaker package
```

> 安装之后使用https操作git 出现 ：fatal: Unable to find remote helper for 'https'

```shell
yum -y install curl curl-devel
```

> git clone的时候: bash: git-upload-pack: command not found

```shell
ln -s /usr/local/git/bin/git-upload-pack /usr/bin/git-upload-pack
```

> git push的时候: bash: git-receive-pack: command not found

```shell
ln -s /usr/local/git/bin/git-receive-pack /usr/bin/git-receive-pack
```



