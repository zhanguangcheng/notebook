MySQL技巧
===========

## 使用crc32摘要算法优化唯一查询

* 将要检查唯一的一列或多列字段拼接起来再进行crc32取摘要，为该字段加上索引
* 由于会存在hash冲突，查询时摘要字段和唯一字段要一起查询
* 由于crc32()函数返回的时4字节整数（无符号），所以查询相比字符串更快

## 常用函数
```sql
-- 最近？时间
DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= created_at

-- 时间转时间戳
UNIX_TIMESTAMP('2020-06-21 21:33:19');

-- 时间戳转时间
FROM_UNIXTIME(1592746399, '%Y-%m-%d %H:%i:%s');

-- 加密解密
AES_ENCRYPT('data', 'password')
AES_DECRYPT('data', 'password')

-- 查看详细的表结构
SHOW FULL COLUMNS FROM `table_name`;
```

## MySQL枚举和tinyint类型之间选择的依据

如以后枚举类型会变动，则使用tinyint（因为改变枚举类型可能会影响到数据），不会变更则使用枚举，语义更友好，同时底层也是用tinyint存储。

## 关于NULL值的使用

避免使用null，除非null值有意义。原因：null值很难优化，占额外空间，查询时麻烦。