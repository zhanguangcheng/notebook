title: Linux命令之文本处理
=========================

# 文本处理相关命令

* cat
* grep
* cut
* awk
* sed
* sort
* uniq


# cat
> 将指定的文件全部内容输出

格式

```
cat [选项] [文件]...
```
选项

* -n 输出内容时显示行号


# grep  
> grep全称是Global Regular Expression Print，表示全局正则表达式版本，它的使用权限是所有用户  
> 在指定的文件中用正则查找字符串, 并把匹配到的行打印出来  

```shell
grep [选项]... PATTERN [FILE]...
```
选项  

* -i 忽略大小写
* -v 排除指定的字符串(取反)

示例  

```shell
#在file文件中匹配包含text的行
grep text file

#在file文件中匹配不包含text的行
grep -v text file
```

# cut  
> 在指定的文件中输出指定的列内容

格式  

```shell
cut [选项]... [文件]...
```
选项  

* -b <num> 截取指定的字节数
* -c <num> 截取指定的字符数
* -f <num> 截取指定取的列数
* -d <str> 指定分割符(默认为制表符)

> num:可以是精确数字, 可以是值列表(1,3), 可以是值范围(1-3)  
> str:字符串


示例  

```shell
cut -c 2-4 file        #在file文件中截取每行的第2个字符到第4个字符的字符串
cut -d ' ' -f 1 file   #在file文件中按照空格作为分隔符取第一列字符串
cut -d ':' -f 1,2 test #在file文件中按照:作为分隔符取第一列和第二列字符串(包含分隔符)
```

# awk
> awk是一个非常强大的文本处理工具

格式  

```shell
awk [选项] '[条件][{动作}]...' 文件
```

选项  

* -F <str> 指定列分隔符(默认空格)

条件  

* BEGIN 读取文件之前
* END   所有行处理完毕之后
* 正则表达式
* 自定义条件

动作  

* 动作中可用进行编程, 最常用的就是打印`print`或者`printf`

条件和动作中可用的变量  

* $0 $1 $2...   $0:整行字符串, $1:第一列....
* ARGC          命令行参数个数
* ARGV          命令行参数排列
* ENVIRON       支持队列中系统环境变量的使用
* FILENAME      awk浏览的文件名
* FNR           浏览文件的记录数
* FS            设置输入域分隔符，等价于命令行 -F选项
* NF            浏览记录的域的个数
* NR            已读的记录数
* OFS           输出域分隔符
* ORS           输出记录分隔符
* RS            控制记录分隔符

示例  

```shell
awk '/reg/' file #打印在file中间中包含reg的所有行(类似grep)
awk '{print $1}' file #打印file文件中所有行用空格分隔的第一列字符串
awk -F : '{print $1 $3}' file #打印file文件中所有行用:分隔的第一列和第三列字符串
awk 'NR<3{print $1}' file #打印file文件中前两行用空格分隔的第一列字符串
awk 'BEGIN{print "before"} {print $0}' file #先打印字符串before, 再打印所有行字符串
```

# sed
> sed是一种流编辑器, 可以对文本进行插入,替换,删除等

格式  

```shell
sed [选项] '[操作]' 文件...
```

选项  

* -n 只输出经过sed 特殊处理的那一行(或者动作)才会被列出来
* -f
* -i 处理的结果直接影响修改的文件, 而不是输出

操作  

> 操作由位置+动作+字符串组成, 表示在什么位置干什么, 需要什么字符串.

位置  

* 省略不写           #表示所有行
* 精确数字
* $                  #表示最后一行
* 开始数字,结束数字  #表示范围,可以和$组合

动作  

* a 后插入
* i 前插入
* c 替换
* d 删除
* p 打印, 支持正则
* s 替换, 支持正则

示例  

```shell
sed '2a str' file           #在file文件中的第2行后面插入str
sed '1,3a str' file         #在file文件中的第1行到第3行后面都插入str

sed '$i str' file           #在file文件中的最后1行前面都插入str

sed '3c str' file           #将file文件中的第3行替换为str

sed 'd' file                #将file文件中的内容全部删除
sed '3,$d' file             #将file文件中的第3行到最后一行都删除

sed -n '3p' file            #将file文件中的第3行输出 -n表示只输出第3行
sed -n '3,$p' file          #将file文件中的第3行到最后一行输出
sed -n '/reg/p' file        #打印在file中间中包含reg的所有行(类似grep)

sed 's/old/new/' file       #将file文件中的所有行的old替换为new, 每行最多替换一次
sed '2s/old/new/g' file     #将file文件中的第2行的old替换为new, 每行会全局替换
sed '1,5s/old/new/gi' file  #将file文件中的第2行到第5行的old替换为new, 每行会全局替换, 不区分大小写
```

# sort
> sort可以根据不同的数据类型进行排序

格式  

```shell
sort [选项]... [文件]...
```

选项  

* -f   排序时，忽略大小写字母。
* -n   依照数值的大小排序。
* -r   降序排序。
* -u   去除重复的行
* -M   将前面3个字母依照月份的缩写进行排序。
* -t<分隔字符>   指定排序时所用的栏位分隔字符。
* -k<列数>   选择以哪个区间进行排序。
* -b   忽略每行前面开始出的空格字符。

示例  

```shell
sort -f file        #将file文件中的内容进行排序, 并忽略大小写字母。
sort -n file        #将file文件中的内容进行排序, 按照数字的方式。
sort -r file        #将file文件中的内容进行降序排列。
sort -u file        #将file文件中的内容进行排序, 并去重。
sort -t: -k2 file   #将file文件中的内容的每行用:分割并用第2列进行排序。
```




# uniq

格式  

```
uniq [选项]... [文件]
```

选项  

* -c 在行首输出重复的数量
* -d 输出重复的行
* -u 输出不重复的行(不包含重复的行)

示例  

```shell
uniq file      #将file文件中的相同行去重
uniq -c file   #将file文件中的相同行去重, 并在行首显示重复的数量
uniq -d file   #输出file文件中重复的行文本
uniq -u file   #输出file文件中不重复的行
```

