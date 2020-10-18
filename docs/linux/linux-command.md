```bash
# htop安装
yum -y install htop

# sar安装
yum -y install sysstat
```

```bash
# 实时显示系统中各个进程的资源占用状况及总体状况
top
htop

# 查看进程信息
ps aux

# 查看端口占用情况
netstat -anp

# 查看系统信息
uname -a

# 查看CPU信息
ls cpu
cat /proc/cpuinfo

# 查看负载
w
uptime

# 查看CPU使用情况
sar 1
sar -P ALL 1

# 查看内存使用情况
free -h

# 查看硬盘使用情况
df -h

# 查看网络
sar -n DEV 1

# 查看磁盘I/O的使用情况
sar -b 1
sar -d -p 1

# 查看内核信息以解决硬件故障
dmesg

# 查看目录大小
du -sh 目录

# 查看文件大小
du -h 文件名
ls -lh 文件名

# 查看路由
route
netstat -r

# 时间同步
yum -y install ntp && echo "*/5 * * * * root /usr/sbin/ntpdate ntp.aliyun.com" >> /etc/crontab

# 后台运行程序
nohup wget http://xxx.tar.gz &

# 左边的标准输出作为右边的参数，grep是左边的标准输出作为右边的标准输入，但不是所有程序都支持，这时需要使用xargs
echo "/" | xargs ls
```