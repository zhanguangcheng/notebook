Composer使用
============


## Composer简介

> PHP的一个依赖管理工具, 不是一个包管理器, 它涉及"packages" 和 "libraries"

Composer网站

* composer官网 https://getcomposer.org
* composer中文网 http://www.phpcomposer.com

## Composer安装

> PHP版本要求5.3.2以上  

### Linux: 

```bash
wget https://getcomposer.org/composer.phar
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer
```

### Windows:  

* 下载 [composer.phar](https://getcomposer.org/composer.phar)  
* 复制 composer.phar 到php.exe同级目录  
* 新建一个composer.bat, 将下面代码保存到该文件中  

```bash
@php "%~dp0composer.phar" %*
```

### 校验安装结果

```
composer --version
```


## 更换Composer的源

### 更换源

全局(全部项目生效)

```bash
composer config -g repo.packagist composer https://packagist.phpcomposer.com
```

局部(当前项目生效)

```bash
composer config repo.packagist composer https://packagist.phpcomposer.com
```

###  查看配置

```
composer config --global --list
```


## Composer使用

### composer init

生成composer.json 根据提示操作

### composer install

*参数*

* --prefer-dist 从 dist 获取包
* --dev 安装 `require-dev` 字段中列出的包（这是一个默认值）。
* --no-dev: 跳过 `require-dev` 字段中列出的包。

根据`composer`配置文件并将其安装/卸载到`vendor`目录下

执行过程：

1. `composer.lock`文件是否存在
2. 存在则从该文件中读取安装包信息进行安装，确保了该库的每个使用者都能得到相同的依赖版本
3. 不存在则读取`composer.json`进行安装，安装完毕生成`composer.lock`

> 如果`composer.lock`已经存在了，然后在`composer.json`中增加或删除了包，执行`composer install`程序并不会执行安装，并会抛出警告：需要执行update命令来更新。  
> 所以推荐的做法是使用`composer require`和`composer remove`来增加或删除了包，之后将`composer.lock`提交到版本库中供其他小伙伴安装。

### composer update

*参数*

* --prefer-dist 从 dist 获取包  
* --lock: 仅更新 lock 文件的 hash，取消有关 lock 文件过时的警告。
* --dev 安装 `require-dev` 字段中列出的包（这是一个默认值）。
* --no-dev: 跳过 `require-dev` 字段中列出的包。

根据`composer.json`中的版本约束来更新包，并且升级`composer.lock`，包括在`composer.json`中新增或删除的包。  
如果只想安装`composer.json`中新增的包，又不更新原来的包，则加上--lock参数：`composer update --lock`

### composer require

*参数*

* --prefer-dist 从 dist 获取包  

增加新的依赖包到当前目录的`composer.json`文件中，并更新`composer.lock`。

```
composer require curl/curl

# 版本约束
composer require curl/curl:1.5.0
composer require curl/curl:^1.5
```


### 其他

```bash
#全局，可用于install,update,require等
composer global 命令

#删除包
composer remove 包

#配置
composer config --list

#搜索包
composer search 名称

#显示包信息
composer --all show 名称

#创建项目
composer create-project 名称 --参数

#更新composer
composer self-update
```

## 更多

* [更多命令](http://docs.phpcomposer.com/03-cli.html)  
* [常用命令和版本约束](https://segmentfault.com/a/1190000005898222)  
