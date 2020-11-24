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

-- 加密解密，默认加密模式：aes-128-ecb（SHOW VARIABLES LIKE 'block_encryption_mode'），填充模式：PKCS7
AES_ENCRYPT('data', 'password')
AES_DECRYPT('data', 'password')

-- 查看详细的表结构
SHOW FULL COLUMNS FROM `table_name`;
```

## MySQL枚举和tinyint类型之间选择的依据

如以后枚举类型会变动，则使用tinyint（因为改变枚举类型可能会影响到数据），不会变更则使用枚举，语义更友好，同时底层也是用tinyint存储。

## 关于NULL值的使用

避免使用null，除非null值有意义。原因：null值很难优化，占额外空间，查询时麻烦。

## 线上大表加索引
> 并发大的情况尽量不要使用，容易出现锁等待，阻塞业务，经测试并发在100/秒以下无问题
```sql
# 创建一样的表结构，创建好索引
CREATE TABLE message_copy LIKE message;
ALTER TABLE message_copy ADD INDEX ( `status` );

# 迁移老数据，id<=100是确认数据范围，防止锁表，然后再迁移新产生的数据并替换表名
INSERT INTO message_copy SELECT * FROM message WHERE id<=100;
INSERT INTO message_copy SELECT * FROM message WHERE id>100;
RENAME TABLE message TO message_bak, message_copy to message;

# 检查无误后，删除临时表
DROP TABLE message_bak;
```

## 快速导出、导入数据
```sql
# 导出
SELECT * INTO OUTFILE 'd:/person.txt'
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\n'
FROM test.person;

# 导入
LOAD DATA INFILE 'd:/person.txt'
INTO TABLE test.person
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\n';
```