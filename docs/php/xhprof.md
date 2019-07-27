XHProf
============

## 简介

[XHProf](https://github.com/phacility/xhprof)是一个PHP轻量级的性能分析工具，由于性能开销低，可以用在生产环境中

* XHProf最初是在Facebook开发的，于2009年3月开源。
* XHProf由C语言开发，是一个PHP的扩展。


## 安装

### Windows

只支持PHP5.3 ~ 5.5

<http://windows.php.net/downloads/pecl/releases/xhprof/0.10.6/>


### Linux

安装编译扩展
> **注意：** 没有php-config时需要安装php-devel包

```bash
cd ~

# PHP5.3 ~ PHP5.6
git clone https://github.com/phacility/xhprof.git
# PHP7+
git clone https://github.com/longxinH/xhprof.git

cd xhprof/extension
phpize
./configure --with-php-config=php-config
make && make install
```

修改`php.ini`加入如下代码启用扩展。

```ini
[xhprof]
extension=xhprof.so
xhprof.output_dir=/var/run/xhprof
```

这个目录需要在PHP运行时有写权限，保存的是性能分析报告。
```bash
mkdir /var/run/xhprof
chown -R apache:apache /var/run/xhprof
```

## 简单使用

假设web目录为`/var/www/html`

### 准备
```bash
# 展示性能分析报告的web页面和一些有用的类库。
cp -r ~/xhprof/xhprof_html /var/www/html
cp -r ~/xhprof/xhprof_lib /var/www/html

# 为查看图形化报告作准备。
yum -y install libpng graphviz
```

### 采集性能报告
/var/www/html/index.php:
```php
<?php
// 开启采样
xhprof_enable();

// 中间运行需要分析的代码
sleep(1);

// 停止采样，返回性能分析报告
$xhprof_data = xhprof_disable();

// 持久化报告
include_once __DIR__ . "/xhprof_lib/utils/xhprof_lib.php";
include_once __DIR__ . "/xhprof_lib/utils/xhprof_runs.php";
$xhprof_runs = new XHProfRuns_Default();
$run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_namespace");
```

通过浏览器访问这个文件


### 查看报告

`http://<xhprof-ui-address>`

正常的话会看到一个报告列表，点击进去可以查看每个报告详情，点击报告详情中的`View Full Callgraph`可以查看图形化的报告。

不但可以查看单次的报告详情，还可以查看2个报告的差异

`http://<xhprof-ui-address>/index.php?run1=<run_id1>&run2=<run_id2>&source=<namespace>`

以及汇总多个报告

`http://<xhprof-ui-address>/index.php?run=<run_id1><run_id2><run_id3>&source=<namespace>`


## 项目中使用

建议

* 不采样CPU数据，采样内存数据。
* 可根据情况选择性地开启xhprof，如指定的url、指定的GET参数、几率性等方式。



## API

### `xhprof_enable`

启动 xhprof 进行性能分析。

```php
xhprof_enable ([ int $flags = 0 [, array $options ]] ) : void
```

$flags，多个可以使用 `|` 连接

* XHPROF_FLAGS_NO_BUILTINS 使得跳过所有内置（内部）函数。
* XHPROF_FLAGS_CPU 使输出的性能数据中添加 CPU 数据。（Linux中不推荐使用，CPU有很高的开销）
* XHPROF_FLAGS_MEMORY 使输出的性能数据中添加内存数据。

$options

* ignored_functions 可以忽略性能分析中的某些函数。


### `xhprof_disable`

停止性能分析，并返回此次运行的 xhprof 数据。
```php
xhprof_disable ( void ) : array
```


## 更多

* 详细文档：`http://<xhprof-ui-address>/docs`
* XHProf文档：<https://www.php.net/xhprof>