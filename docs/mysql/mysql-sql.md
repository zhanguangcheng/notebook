MySQL SQL汇总
==============

## 快速找到SQL帮助

```bash
# 连接MySQL
mysql -h127.0.0.1 -uroot -p

# 帮助列表
help Contents

# 尽情发挥
help SELECT
help ALTER TABLE
help INT
……
```

## DCL
数据控制语言 Data Control Language

### [GRANT](https://dev.mysql.com/doc/refman/5.7/en/grant.html)
用户授权

主要语法
```sql
CREATE USER 用户 密码配置;
GRANT 权限列表 ON 权限级别 TO 用户 密码配置;
SET PASSWORD [FOR user] = 密码;
```

示例
```sql
# 创建用户并设置密码
CREATE USER 'grass'@'localhost' IDENTIFIED BY '123456';

# 授权，可叠加，需先创建用户
GRANT SELECT ON *.* TO 'grass'@'localhost';
GRANT INSERT,UPDATE ON *.* TO 'grass'@'localhost';

# 授权，如用户不存在会自动创建，用户存在时会修改密码
GRANT ALL ON *.* TO 'grass'@'localhost' IDENTIFIED BY '123456';

# 修改当前用户密码
SET PASSWORD = '123456';

# 修改指定用户密码
SET PASSWORD FOR 'grass'@'localhost' = '123456';
```

* 权限列表参考
  * <https://dev.mysql.com/doc/refman/5.7/en/grant.html#grant-privileges)>
* 权限级别
  * 所有库和表：`*.*`
  * 单库所有表：`db_name.*`
  * 单表：`db_name.tbl_name`
  * 列权限：`GRANT SELECT (col1), INSERT (col1, col2) ON db_name.tbl_name`

### REVOKE
收回用户授权

主要语法
```sql
REVOKE 权限列表 ON 权限级别 FROM 用户;
REVOKE ALL, GRANT OPTION FROM 用户;
DROP USER 用户;
DROP USER IF EXISTS 用户;
```

示例
```sql
# 收回INSERT权限
REVOKE INSERT ON *.* FROM 'grass'@'localhost';

# 收回所有权限
REVOKE ALL, GRANT OPTION FROM 'grass'@'localhost'

# 删除用户
DROP USER 'grass'@'localhost';
DROP USER IF EXISTS 'grass'@'localhost';
```

## TCL
事务控制语言 Transaction Control Language

```sql
# 等价 BEGIN
START TRANSACTION;
COMMIT;
ROLLBACK;
SET autocommit=0;

START SLAVE;
STOP SLAVE;
CHANGE MASTER TO 配置项;
```

## DDL
数据定义语言 Data Definition Languages

### [CREATE DATABASE](https://dev.mysql.com/doc/refman/5.7/en/create-database.html)

主要语法
```sql
CREATE DATABASE [IF NOT EXISTS] db_name 配置项;
```

示例
```sql
CREATE DATABASE db_name;
CREATE DATABASE db_name CHARSET utf8mb4;;
CREATE DATABASE IF NOT EXISTS db_name CHARSET utf8mb4;
USE db_name;
```

### [CREATE TABLE](https://dev.mysql.com/doc/refman/5.7/en/create-table.html)

主要语法
```sql
CREATE TABLE [IF NOT EXISTS] tbl_name (列定义) [table_options] [partition_options];
CREATE TABLE [IF NOT EXISTS] tbl_name 查询语句;
CREATE TABLE [IF NOT EXISTS] tbl_name LIKE old_tbl_name;
```

示例
```sql
CREATE TABLE tbl_name (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `mobile_phone` char(11) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  KEY `idx_username` (`username`(10),`mobile_phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tbl_name(column_definition……);

# 创建结构和old_tbl_name一样的表，并插入数据
CREATE TABLE tbl_name SELECT * FROM old_tbl_name;

# 创建结构和old_tbl_name一样的表
CREATE TABLE tbl_name LIKE old_tbl_name;
```


### [ALTER TABLE](https://dev.mysql.com/doc/refman/5.7/en/alter-table.html)

主要语法
```sql
ALTER TABLE [alter_specification...] [partition_options];
```

alter_specification包含
```sql
# 表配置
table_options

# 字段操作
ADD [COLUMN] col_name column_definition [FIRST | AFTER col_name];
CHANGE [COLUMN] old_col_name new_col_name column_definition [FIRST | AFTER col_name];
MODIFY [COLUMN] col_name column_definition [FIRST | AFTER col_name];
DROP [COLUMN] col_name;

# 索引操作
ADD PRIMARY KEY [index_type] (index_col_name,...) [index_option];
ADD {INDEX|KEY} [index_name] [index_type] (index_col_name,...) [index_option];
ADD UNIQUE [INDEX|KEY] [index_name] [index_type] (index_col_name,...) [index_option];
DROP PRIMARY KEY;
DROP {INDEX|KEY} index_name;

# 分区操作
ADD PARTITION (partition_definition)
DROP PARTITION partition_names
```

示例
```sql
ALTER TABLE ADD COLUMN col_name column_definition FIRST;
ALTER TABLE
  ADD COLUMN col2 column_definition AFTER col1
  ADD COLUMN col3 column_definition AFTER col2;
ALTER TABLE CHANGE COLUMN old_col_name new_col_name column_definition AFTER col_name;
ALTER TABLE MODIFY COLUMN col_name column_definition AFTER col_name;
ALTER TABLE DROP COLUMN col_name;
ALTER TABLE DROP PRIMARY KEY;
ALTER TABLE DROP INDEX index_name;
```

### 其他
```sql
DROP DATABASE db_name;
DROP TABLE tbl_name;
TRUNCATE tbl_name;
RENAME TABLE old_table TO new_table;
RENAME TABLE old_table1 TO new_table1,old_table2 TO new_table2;
```

## DQL
数据查询语言 Data Query language

### [SELECT](https://dev.mysql.com/doc/refman/5.7/en/select.html)

主要语法
```sql
SELECT
  [ALL | DISTINCT | DISTINCTROW ]
  select_expr [, select_expr] ...
  [FROM table_references]
  [WHERE where_condition]
  [GROUP BY {col_name | expr} [ASC | DESC],...]
  [HAVING where_condition]
  [ORDER BY {col_name | expr} [ASC | DESC],...]
  [LIMIT {[offset,] row_count | row_count OFFSET offset}]
  [FOR UPDATE | LOCK IN SHARE MODE]
```

示例
```sql
SELECT 1 + 1,CURRENT_TIMESTAMP,CONCAT('A', '-', 'B');

SELECT * FROM user WHERE `name` = 'grass' AND `status` = 'Y' ORDER BY created_at DESC,id DESC LIMIT 1;

SELECT `name`,`status`,COUNT(*) total
  FROM user
  WHERE id < 100
  GROUP BY `status`
  HAVING total > 2
  ORDER BY total DESC
  LIMIT 10;

SELECT `user`.name,post.title
  FROM post INNER JOIN `user` ON post.userid = `user`.id
  WHERE user.`status` = 'Y' AND post.`status` = 'Y'
  ORDER BY post.created_at DESC
  LIMIT 5,10;
```

## DML
数据操作语言 Data Manipulation Language

### [INSERT](https://dev.mysql.com/doc/refman/5.7/en/insert.html)

主要语法
```sql
INSERT [IGNORE] [INTO] tbl_name (列集合) VALUE(值集合);
INSERT [IGNORE] [INTO] tbl_name (列集合) VALUES(值集合),(值集合) [ON DUPLICATE KEY UPDATE 赋值语句];
INSERT [IGNORE] [INTO] tbl_name (列集合) 查询语句 [ON DUPLICATE KEY UPDATE 赋值语句];
INSERT [IGNORE] [INTO] tbl_name SET 赋值语句 [ON DUPLICATE KEY UPDATE 赋值语句];
```

示例
```sql
INSERT INTO tbl_name (col1,col2) VALUE(val1,val2);
INSERT INTO tbl_name (col1,col2) VALUES(val1,val2),(val3,val4);
INSERT INTO tbl_name (col1,col2) VALUES(val1,val2) ON DEPLICATE KEY UPDATE col1=val1,col2=val2;
INSERT IGNORE INTO tbl_name (col) VALUES(val);
INSERT tbl_name (col1,col2) SELECT col1,col2 FROM tbl2_name;
INSERT tbl_name SET col1=val1,col2=val2;
```

### [UPDATE](https://dev.mysql.com/doc/refman/5.7/en/update.html)

主要语法

[table_reference参考](https://dev.mysql.com/doc/refman/5.7/en/join.html)
```sql
# 单表
UPDATE table_reference SET 赋值语句 [WHERE 条件] [ORDER BY ...] [LIMIT row_count];

# 多表
UPDATE table_reference SET 赋值语句 [WHERE 条件];
```

示例
```sql
UPDATE tbl_name SET col1=val1,col2=val2 WHERE id = 1 LIMIT 1;
UPDATE tbl_name SET id = id + 1 ORDER BY id DESC;

# 禁用grass用户和其发布的文章
UPDATE `post`
  INNER JOIN `user` ON post.userid = user.id
  SET post.status = 'N',user.status = 'N'
  WHERE user.name='grass';
```

### [DELETE](https://dev.mysql.com/doc/refman/5.7/en/delete.html)

主要语法
```sql
# 单表
DELETE FROM tbl_name [WHERE where_condition] [ORDER BY ...] [LIMIT row_count];

# 多表
DELETE tbl1_name,tbl2_name... FROM table_references [WHERE where_condition];
```

示例
```sql
DELETE FROM tbl_name WHERE id = 1 LIMIT 1;

# 删除grass发布的文章
DELETE post FROM post INNER JOIN user ON post.userid=user.id WHERE user.name='grass';

# 删除grass和其发布的文章
DELETE post,user FROM post INNER JOIN user ON post.userid=user.id WHERE user.name='grass';
```


## 其他
```sql
SET NAMES utf8mb4;
USE db_name;

FLUSH PRIVILEGES;
FLUSH BINARY LOGS;
FLUSH SLOW LOGS;
FLUSH RELAY LOGS;
FLUSH STATUS;

RESET MASTER;
RESET SLAVE;
RESET QUERY CACHE;

SHOW CREATE DATABASE db_name;
SHOW CREATE TABLE tbl_name;
SHOW CREATE VIEW view_name;
SHOW DATABASES [like_or_where];
SHOW TABLES [like_or_where];
SHOW COLUMNS FROM tbl_name;
SHOW FULL COLUMNS FROM tbl_name LIKE 'id';
SHOW FULL COLUMNS FROM tbl_name WHERE `Key` = 'PRI';
SHOW INDEX FROM tbl_name;
SHOW GRANTS FOR 'grass'@'localhost';
SHOW [GLOBAL | SESSION] VARIABLES [like_or_where];
SHOW [GLOBAL | SESSION] STATUS [like_or_where];
SHOW PLUGINS;
SHOW PROFILES;
SHOW PROFILE FOR QUERY n;
SHOW WARNINGS;
SHOW ERRORS;
SHOW MASTER STATUS;
SHOW SLAVE STATUS;
SHOW TABLE STATUS [like_or_where];
SHOW PROCESSLIST;
```
