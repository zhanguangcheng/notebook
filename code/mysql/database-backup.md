# 数据库备份


```bash
#!/bin/bash

backupdir=/tmp
name=database_backup_

time=`date +%Y%m%d%H%M%S`
mysqldump -h127.0.0.1 -uroot -proot 库名 --ignore-table=库名.不备份的表名 | gzip > $backupdir/$name$time.sql.gz
find $backupdir -name "$name*.sql.gz" -type f -mtime +7 -exec rm {} \; > /dev/null 2>&1
```



如果提示：`Using a password on the command line interface can be insecure`，表示命令行上不能使用密码  
解决方法：将密码写在配置文件中

/etc/my.cnf
```ini
[mysqldump]
password=xxx
```
