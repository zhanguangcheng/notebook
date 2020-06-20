短网址实现
===============

说明
-------

* 案例采用Yii2框架实现、也很容易换成其他框架。
* 采用自增序列的方法实现，短码永远不会重复，同时加入了62组随机序列让生成的短码看起来不那么有规律
* 数据库新增crc32算法字段加快url的查询，以解决一个短码对应一个url
* 无论是hash算法还是自增序列，生成的短码不能视为安全的，如有需要可以加上密码或者有效期


使用方法
----------

1. 调用`echo json_encode(ShortUrlHelper::makeBaseList())`生产62组随机序列并更新属性`ShortUrlHelper::$baseList`
2. 创建数据库，执行`short-url.sql`创建表并更改数据库配置`config/db.php`
3. 生产短链接：`http://your-domain/short-url/make?url=rawurlencode($url)`
4. 短链接解析：`http://your-domain/$code` => `http://your-domain/short-url/redirect?code=$code`


url重写配置以实现`/短码`可以被识别
```php
[
    'components' => [
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<code:[a-zA-Z0-9]{7}>' => '/short-url/redirect'
            ],
        ],
    ],
]
```