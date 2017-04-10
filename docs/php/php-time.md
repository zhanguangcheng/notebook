title: PHP中的时间处理方法&技巧
=============================

* 获取一个秒级别的时间戳
```php
time(); // 1473089498
```

* 获取一个微妙级别的时间戳
```php
microtime(true); // 1473089522.1572
```

* 指定时间转为时间戳
```php
strtotime('2016-09-05 08:08:00');
```

* 上个礼拜当前时间戳
```php
strtotime('-1 week');
```

* 下个月当前时间戳
```php
strtotime('+1 month');
```

* 前三个月当前时间戳 (最近三个月)
```php
strtotime('-3 month');
```

* 本月初  2016-09-01 00:00:00
```php
strtotime('first day of 00:00:00');
```


* 本月底 2016-09-30 23:59:59
```php
strtotime('last day of 23:59:59');
```

* 本周一 00:00:00
```php
strtotime('Monday this week');
```

* 下个礼拜一 00:00:00
```php
strtotime('Monday next week');
```

* 更多请参考 [http://php.net/manual/zh/datetime.formats.relative.php](http://php.net/manual/zh/datetime.formats.relative.php)
