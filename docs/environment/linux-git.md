Linux服务器之搭建git服务
=======================

# 环境&软件  

* CentOS 6.3  
* git-2.9.2.tar.gz  
* git安装位置: `/usr/local/git`
* 仓库设置位置:`/repo/project1`

# 安装git

下载  

[http://pan.baidu.com/s/1cFrIWI](http://pan.baidu.com/s/1cFrIWI)

```shell

#解压
cd ~
tar zxf git-1.7.9.1.tar.gz

#安装
cd git-1.7.9.1
./configure --prefix=/usr/local/git
make
make install

#将git命令加入环境变量
echo 'export PATH="/usr/local/git/bin/":$PATH' >> ~/.bash_profile
#立即生效
source ~/.bash_profile
```

# 为git创建用户

```shell
#添加git用户组
groupadd git

#添加git用户, 禁止登陆, 所属组为git
useradd -s /sbin/nologin -g git git
```

# 初始化仓库

```shell
#准备目录
mkdir -p /repo/project1
cd /repo/project1

#初始化仓库
git --bare init
chown -R git:git *
```

# 秘钥配置

## 客户端生成秘钥

```shell
#使用git bash生成
ssh-keygen -t rsa

#三个回车(密码空), 出现如下图形则成功

+---[RSA 2048]----+
|   .*=    ....   |
| . ....    ..    |
|  + .... ..o     |
|   + . =o.= o    |
|  .   * S+ + o . |
|     E *  o . o o|
|    . *    . + oo|
|   . + o    ..*.+|
|    o .    .. .*+|
+----[SHA256]-----+

```

> 生成成功会产生一个公钥和一个私钥

公钥位置  

* Windows C:\Users\<你的用户名>\.ssh\id_rsa.pub
* Linux ~/.ssh/id_rsa.pub

## 服务端存放公钥

```shell
mkdir /home/git/.ssh/
touch /home/git/.ssh/authorized_keys
chmod 700 /home/git/.ssh
chmod 600 /home/git/.ssh/authorized_keys
```

