PHP中的时间处理方法&技巧
======================

```php

// 获取一个秒级别的时间戳
time(); // 1473089498

// 获取一个微妙级别的时间戳
microtime(true); // 1473089522.1572

// 指定时间转为时间戳
strtotime('2016-09-05 08:08:00');

// 上个礼拜当前时间戳
strtotime('-1 week');

// 下个月当前时间戳
strtotime('+1 month');

// 前三个月当前时间戳 (最近三个月)
strtotime('-3 month');

// 本月初  2016-09-01 00:00:00
strtotime('first day of 00:00:00');

// 本月底 2016-09-30 23:59:59
strtotime('last day of 23:59:59');

// 本周一 00:00:00
strtotime('Monday this week');

// 上个礼拜一 00:00:00
strtotime('Monday last week');

// 前两个礼拜二 00:00:00
strtotime('Tuesday -2 week');

// 下个礼拜一 00:00:00
strtotime('Monday next week');

// 今天 00:00:00
strtotime('today');

```

* 更多请参考 <http://php.net/manual/zh/datetime.formats.relative.php>
