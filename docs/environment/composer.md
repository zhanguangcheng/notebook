title: Composer快速入门
======================

## Composer简介

> PHP的一个依赖管理工具, 不是一个包管理器, 它涉及"packages" 和 "libraries"

Composer网站

* composer官网 https://getcomposer.org
* composer中文网 http://www.phpcomposer.com

## Composer安装

> PHP版本要求5.3.2以上  
> composer.phar下载地址:  
https://getcomposer.org/download/ (Manual Download下面)

### Linux: 

```shell
wget https://getcomposer.org/download/1.2.2/composer.phar
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer
```

### Windows:  

* 下载composer.phar  
* 复制 composer.phar 到php.exe同级目录  
* 新建一个composer.bat, 将下面代码保存到该文件中  

```shell
@php "%~dp0composer.phar" %*
```

### 校验

```
composer --version
```

## 更换Composer的源

###  查看当前源

```
composer config -g repo.packagist
```

### 更换源

全局(全部项目生效)

```
composer config -g repo.packagist composer https://packagist.phpcomposer.com
```

局部(当前项目生效)

```
composer config repo.packagist composer https://packagist.phpcomposer.com
```

## Composer使用


```
#生成composer.json 根据提示操作
composer init

#搜索包
composer search 名称

#显示包信息
composer --all show 名称

#执行安装
composer install

#执行更新
composer update

#导入包
composer require 名称

#创建项目
composer create-project 名称 --参数
```

> 更多命令 [http://docs.phpcomposer.com/03-cli.html](http://docs.phpcomposer.com/03-cli.html)
