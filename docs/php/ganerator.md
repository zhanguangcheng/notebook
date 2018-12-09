生成器(Generator)
==================

版本要求：(PHP 5 >= 5.5.0, PHP 7)

## 概念

> 生成器提供了一种更容易的方法来实现简单的对象迭代，相比较定义类实现 Iterator 接口的方式，性能开销和复杂性大大降低。


## 类摘要
```php
Generator implements Iterator {
    public mixed current ( void )
    public mixed key ( void )
    public void next ( void )
    public void rewind ( void )
    public mixed send ( mixed $value )// 向生成器中传入一个值，并返回下一个yield的值
    public void throw ( Exception $exception )// 向生成器中抛入一个异常
    public bool valid ( void )
    public void __wakeup ( void )
}
```

除了send,throw,\_\_wakeup方法外，其他方法都是迭代器（Iterator）中的方法

## 简单使用

### 创建生成器

```php
function gen1() {
    yield 1;
    yield 'str';
    yield 'a'=>'b';
}

$gen1 = gen1();
var_dump($gen1);// class Generator#1 (0) {}
```
辨别普通函数和generator函数的区别就在于看函数内部是否使用了yield关键字  
创建生成器的方式是申明一个函数，内部使用`yield`关键字“产出”值，调用该函数时会自动返回一个Generator对象。  
如果您试图实例化一个`Generator`，将会抛出一个`Fatal Error`。

### 获取产出(yield)的值
```php
foreach ($gen1 as $key => $value) {
    echo "$key => $value, ";
}
// 0 => 1, 1 => str, a => b, 
```

在内部会为生成的值配对连续的整型索引，就像一个非关联的数组。  
因为Generator函数实现了Iterator接口，所以可直接遍历，也可以像这样手动获取

```php
$gen1->current();// int(1)
$gen1->next();
$gen1->current();// string(3) "str"
$gen1->valid();// bool(true)
$gen1->next();
$gen1->key();// string(1) "a"
$gen1->current();// string(1) "b"
```

### 向generator函数内部传值

```php
function gen2() {
    $a = yield;// 使用变量接收传入的值
    var_dump($a);// string(5) "value"
    var_dump('Hello ' . yield);// string(11) "Hello World"
}

$gen2 = gen2();
$gen2->send('value');// 这个值将会被作为生成器当前所在的 yield 的返回值
$gen2->send('World');
```

## Generator的作用

* 节省内存空间：处理大数据集合时不用一次性的加载到内存中.甚至你可以处理无限大的数据流.
* [协程的支持](http://www.laruence.com/2015/05/28/3038.html)
