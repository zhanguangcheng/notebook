## foreach 陷阱

```php
$arr = array('a', 'b', 'c');
foreach ($arr as &$v) {
}
foreach ($arr as $v) {
    echo $v;
}
/*
结果为abb
解决方法: 
① 第二次foreach循环，别用$v了
② 第二次foreach循环之前，unset($v)
$v的引用在 foreach 循环之后仍会保留。建议使用unset()将其销毁
③ 第二次循环也用&
 */
```


## 接受POST PUT PATCH DELETE等请求参数

```php
// x-www-form-urlencoded的方式发送, 不是form-data的方式
parse_str(file_get_contents('php://input'), $arr);
var_dump($arr);
```


## 彻底防止SQL注入

使用PDO预处理的方式操作数据库

预处理语句可以带来两大好处：

* 提高运行效率
* 防止SQL注入

使用方法:

1. 设置属性PDO::ATTR_EMULATE_PREPARES为false(默认为true)
2. PHP5.3.6以上将设置字符集写在dsn中(`new PDO('mysql:host=127.0.0.1;dbname=test;charset=utf8', 'root', 'root');`)
3. 同样需要执行`set names utf8`

> 参考 <http://zhangxugg-163-com.iteye.com/blog/1835721>


## 关于PHP短标记<?=

自 PHP 5.4.0 起，短格式的 echo 标记 <?= 总会被识别并且合法，而不管 short_open_tag 的设置是什么。

> <http://php.net/manual/en/language.basic-syntax.phptags.php>


## 通过table>tr>th|td 下载Excel格式的文件
```php
header("Content-Disposition:filename=filename.xls");
header("Content-type:application/vnd.ms-excel");
// 输出table
```


## array_column() 的第二个参数的数据类型也要对应, 如下就是错误的
```php
$arr = [[1 => 'a'], [1 => 'b'], [1 => 'c']];
var_dump(array_column($arr, '1'));
```


## 三种跳转的方式

```php
// 立即跳转:
header("Location:$url")

// 3秒跳转:
header("refresh:3;url=$url");

// 3秒跳转(html): 
echo "<meta http-equiv='refresh' content='{$time};url={$url}' />"
```


## 当在第二页搜索的时候, 结果不足2页就会显示空

解决:判断点击了搜索按钮就把页码置为1, 判断是否是点击了搜索按钮: isset($\_GET['submit'])


## IE文件下载时中文名称乱码

```php
$filename = rawurlencode('中文.zip');
header("Content-Disposition: attachment; filename=$filename"); 
```

## PHP 模拟 HTTP 基本认证（Basic Authentication）

```php
// 认证
function validate()
{
    $users = ['admin' => '123456'];
    return isset($_SERVER['PHP_AUTH_USER']) 
        && isset($_SERVER['PHP_AUTH_PW']) 
        && isset($users[$_SERVER['PHP_AUTH_USER']])
        && $users[$_SERVER['PHP_AUTH_USER']] === $_SERVER['PHP_AUTH_PW'];
    return true;
}

if (!validate()) {
    http_response_code(401);
    header('WWW-Authenticate:Basic realm="My Website"');
    echo 'failed';
    exit(-1);
}

echo 'successful';
```
```php
// 发送头信息请求认证
$header[] = 'Authorization: Basic ' . base64_encode('admin:123456')
```


## 批量编辑多条数据时的 数据分类技巧 (数字为id)

```php
$a = [1, 2, 3];// 原始数据(id)
$b = [1, 3, 4];// 改变后的数据

// 分别计算出新增的, 更新的和删除的

// 应该新增的
var_dump(array_diff($b, $a));// 4

// 应该更新的
var_dump(array_intersect($b, $a));// 1,3

// 应该删除的
var_dump(array_diff($a, $b));// 2
```


## min(), max()使用技巧

```php
$num = 11;
// 需求1:限制数值不能大于10

// 三元表达式方法
echo $num > 10 ? $num : $num;

// min()方法
echo min(10, $num);

// 需求2:限制数值在1~10之间, min(), max()方法
echo min(10, max(1, $num));
```


## 位运算使用技巧

### 使用位运算让一个数值做多组开关

**原理**

十进制数转换为二进制数之后为100110的格式，每一个位都可以表示一个开关。  
假设这个数为6，二进制为110，即第一个关，第二个和第三个为开。

**如何实现开关的控制和检测**

$data：数据  
$index：第几位  
$status：状态数  
> (表示某位的状态的整数，特点是，相应位为1，其他位为0.例如，第三位的状态数：100, 2^(3-1))

```php
$data = 6;
$index = 1;
$status = pow(2, $index - 1);

// 检测开关的状态
var_dump(($data & $status) > 0);

// 设置开关的状态为开
var_dump($data | $status);

// 设置开关的状态为关
var_dump($data & ~$status);

// 切换开关的状态(0修改成1，1修改成0)
var_dump($data ^ $status);
```

**最大支持的开关数量**

31位: PHP中的int为4字节, 一个字节8个位, 共32位, 去掉高位符号位, 剩31位可用  
超过31位的可以使用gmp扩展计算更大的数据  
<http://php.net/manual/zh/book.gmp.php>

## 中文按照拼音排序

```php
$data = ['詹', '啊', '过', '国', '果', '郭'];
$coll = new \Collator('zh-cn');
usort($data, [$coll, 'compare']);
var_dump($data);// output： ['啊', '郭', '国', '果', '过', '詹']
```

## 中文转拼音

```php
$data = transliterator_transliterate('Any-Latin; Latin-ASCII; Upper()', '詹');
var_dump($data);// output: ZHAN
```

## 处理大于2038年的时间数据
> 最大支持到 9999-12-31 23:59:59

```php
// 日期转时间戳
$obj = new DateTime("9999-12-31 23:59:59");
echo $obj->format("U"); // output: string: 253402271999


// 时间戳转日期
$obj = new DateTime("@253402271999");
$obj->setTimezone(timezone_open('Asia/ShangHai')); 
echo $obj->format("Y-m-d H:i:s"); // output: 9999-12-31 23:59:59
```

## 让SESSION不依赖COOKIE

> 用途:写无状态应用时，比如手机端api。

```php
session_id($_GET['token']);
session_start();
// 开始使用...
```

## 提高COOKIE安全性

> 设置COOKIE的httpOnly为true来增加安全，这样js就无法操作了，避免了一些XSS攻击。
```php
// 1. 全局配置
ini_set('session.cookie_httponly', true);

// 2. 单个设置, setcookie()的第7个参数设置为true
bool setcookie ( string $name [, string $value = "" [, int $expire = 0 [, string $path = "" [, string $domain = "" [, bool $secure = false [, bool $httponly = false ]]]]]] )
```
