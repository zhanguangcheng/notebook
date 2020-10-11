docker
=================

概念：
------------

* [Docker](https://www.docker.com/)是一个开源的应用容器引擎，基于go语言并遵从Apache2.0协议[开源](https://github.com/docker)。
* Docker 使用(C/S) 架构模式，使用远程API来管理和创建Docker容器。Docker 容器通过 Docker 镜像来创建。容器与镜像的关系类似于面向对象编程中的对象与类。
* 可以打包应用和依赖包到一个可移植的容器中，然后发布到任何流行的Linux 64bit机器上。
* 容器使用kernel的namespace将进程, 网络, 消息, 文件系统和hostname隔离开，直接使用主机的资源，不同于虚拟机。
* 镜像（images）：是一种轻量级、可执行的独立软件包，它包含运行某个软件所需的所有内容，包括代码、运行时、库、环境变量和配置文件。
* 容器（container）：是镜像的运行时实例 - 实际执行时镜像会在内存中变成什么。默认情况下，它完全独立于主机环境运行，仅在配置为访问主机文件和端口的情况下才执行此操作。


安装：
--------

### 预知


* 运行Docker需要64位操作系统，需要支持Virtualization。
* 系统内核版本为 3.10 以上，使用命令`uname -r`即可 查看。
* Docker相关工具说明
    * docker：操作Docker的客户端。
    * docker-machine：Windows7和Mac需要安装，目的是模拟Linux环境，这样就能运行Docker容器了。
    * docker-compose：构建多容器应用镜像工具。

### Docker for Windows

1. 在Windows上安装Docker需要安装`Docker Toolbox`，其中已经集成了docker，docker-machine，docker-compose，Oracle VM VirtualBox，Git。
2. 因为某些原因，官网的镜像下载速度非常慢，附上镜像资源[下载地址](https://get.daocloud.io/toolbox/)。（选择最新版本）
3. 一路Next，弹出需要安装设备时点安装。
4. 安装完毕后，执行“Docker Quickstart Terminal”，第一次执行会下载docker-machine所需要的镜像。（如果下载失败，多试几次 ）
5. 执行命令`docker info`就能看到是否安装成功了，可以使用`docker-mechine ssh`进入Docker运行的虚拟机内部，也可以 使用ssh工具连接：192.168.99.100@docker:tcuser。

注意事项：

* 挂载到源目录/文件是相对于虚拟机内部的，挂载失败的检查是否为该原因。


### Docker for Centos7

```
# 安装docker
yum -y install docker
systemctl start docker

# 安装docker-compose
curl -L https://github.com/docker/compose/releases/download/1.22.0/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose
```

更换国内源

```bash
vi /etc/docker/daemon.json
```
加入如下代码

```json
{
  "registry-mirrors": ["https://registry.docker-cn.com"]
}
```

遇到的错误

* SELinux is not supported with the overlay2 graph driver on this kernel
```
1. 关闭selinux
2. 修改配置
vi /etc/sysconfig/docker
修改 OPTIONS='--selinux-enabled=false
```

docker 常用命令：
-----------

镜像标识： 镜像名[:标签]，默认标签为`:latest`，表示最新版

### 镜像
* `docker pull [OPTIONS] 镜像标识`：拉取镜像
* `docker images`：列出本地安装的镜像
    * `-a` 查看全部
* `docker run [OPTIONS] 镜像标识`：通过镜像创建并运行容器实例
    * `-d` 后台运行
    * `-i` 以交互模式运行容器，通常与 -t 同时使用；
    * `-v` 挂载卷
* `docker build -t 标签名 目录`：使用Dockerfile构建镜像
* `docker rmi 镜像名`：删除镜像
* `docker search 镜像名`：搜索镜像

### 容器

* `docker ps`：列出运行的容器
    * `-a`：查看全部到容器
* `docker start/stop/restart` 容器状态控制
* `docker rm 容器ID`：删除容器
* `docker inspect 容器ID`：检查容器

### 其他

* `docker`：命令列表
    * `--help`：查看命令帮助
* `docker 命令 --help`：查看具体命令的帮助
* `version`：查看Docker版本
* `info`：查看Docker信息


### docker-compose

* `docker-compose up` 启动
* `docker-compose stop` 停止
* `docker-compose rm` 删除
* `docker-compose logs` 观察各个容器的日志
* `docker-compose ps` 列出服务相关的容器


docker-compose.yml 语法：
----------

* version
* services
* build 本地创建镜像
* depends_on 声明依赖关系（连接容器）
* posts 端口映射
* image
* volumes 文件映射
* environment 环境变量
* volumes 挂载卷
* images pull镜像

### docker-compose使用注意：

* 不要把 docker 当做数据容器来使用，数据一定要用 volumes 放在容器外面
* 不要把 docker-compose 文件暴露给别人， 因为上面有你的服务器信息
* 多用 docker-compose 的命令去操作， 不要用 docker 手动命令&docker-compose 去同时操作
* 写一个脚本类的东西，自动备份docker 映射出来的数据。
* 不要把所有服务都放在一个 docker 容器里面


### docker-machine

* docker-machine ls
* docker-machine start
* docker-machine kill
* docker-machine restart

Dockerfile 语法
------------
* FROM 指定一个车基础镜像
* MAINTINER 作者信息
* RUN 执行命令
* ADD 添加文件，支持远程文件
* COPY 拷贝文件/目录
* CMD 执行命令
* EXPOSE 暴露端口
* WORKDIR 指定运行命令的路径
* ENV 设置环境变量
* ENTRYPOINT 容器入口
* USER 指定用户
* VOLUME mount point 


错误
---------

* Are you trying to mount a directory onto a file (or vice-versa)?

原因为把host机器的文件挂载到vm机器中变成目录了
https://stackoverflow.com/questions/45972812/are-you-trying-to-mount-a-directory-onto-a-file-or-vice-versa


参考
---------

* <https://www.jianshu.com/p/2217cfed29d7>
