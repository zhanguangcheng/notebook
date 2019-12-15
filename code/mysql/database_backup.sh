#!/bin/bash

backupdir=/tmp
time=`date +%Y%m%d%H%M%S`
name=clf_backup_
mysqldump -uroot -proot -h127.0.0.1 51clf_web --ignore-table=51clf_web.clf_ip_log | gzip > $backupdir/$name$time.sql.gz
find $backupdir -name "$name*.sql.gz" -type f -mtime +7 -exec rm {} \; > /dev/null 2>&1
