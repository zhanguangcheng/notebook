MySQL 队列实现思路
===================

场景
-------------
多个生产者往数据库里面插入新任务，多个消费者从数据库中取出新任务执行并更新任务状态为`已执行`。


关键问题
---------

避免多个消费者重复执行同一个任务


解决方案
--------

例如表结构如下：

```sql
CREATE TABLE `job_queue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) DEFAULT '0',
  `data` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

数据库引擎必须为`InnoDB`这样才能使用行锁

`status`为任务状态，其有三个值：

* 0：`STATUS_PREPROCESS` 待处理
* 1：`STATUS_PROCESSING` 处理中
* 2：`STATUS_FINISHED` 已完成

`data`为示例字段，根据实际业务调整


### 1.使用SELECT... FOR UPDATE行锁，确保原子性
```sql
# 获取需处理的任务，标记任务为处理中
START TRANSACTION;
SELECT id, status, data FROM job_queue WHERE status=STATUS_PREPROCESS ORDER BY id ASC LIMIT 1 FOR UPDATE;
UPDATE job_queue SET status=STATUS_PROCESSING WHERE id=:ID;
COMMIT;

# 处理业务...

# 处理完成，标记任务为处理完成
UPDATE job_queue SET status=STATUS_FINISHED WHERE id=:ID;
```

优点是可以一次性取出多个任务进行处理，缺点是有行锁。


### 2.UPDATE成功后再处理
```sql
# 获取需处理的任务，标记任务为处理中
SELECT id, status, data FROM job_queue WHERE status=STATUS_PREPROCESS ORDER BY id ASC LIMIT 1;
UPDATE job_queue SET status=STATUS_PROCESSING WHERE id=:ID;

# 如果更新的行数为1，继续处理，如果为0则不处理

# 处理业务...

# 处理完成，标记任务为处理完成
UPDATE job_queue SET status=STATUS_FINISHED WHERE id=:ID;
```

优点是无锁，缺点是不能一次取出多个任务进行处理。


### 3.先UPDATE，再SELECT，使用用户变量保存更新的ID

单个任务
```sql
# 更新待处理的任务为处理中，保存已更新的主键到用户自定义变量`@id`中，查询出已更新的任务
SET @id=null;
UPDATE job_queue SET status=STATUS_PROCESSING WHERE status=STATUS_PREPROCESS AND @id:=id ORDER BY id ASC LIMIT 1;
SELECT id, status, data FROM job_queue WHERE id=@id;

# 查询到任务则继续处理，否则不处理

# 处理业务...

# 处理完成，标记任务为处理完成
UPDATE job_queue SET status=STATUS_FINISHED WHERE id=:ID;
```

优点是无锁，缺点是不能一次取出多个任务进行处理、使用了自定义变量，使用变量的地方需要同时执行，防止连接断开后变量丢失。

多个任务
```sql
# 更新待处理的任务为处理中，保存已更新的主键到用户自定义变量`@ids`中，查询出已更新的任务编号
SET @ids=null;
UPDATE job_queue SET status=STATUS_PROCESSING WHERE status=STATUS_PREPROCESS AND @ids:=CONCAT_WS(',',id,@ids) ORDER BY id ASC LIMIT 2;
SELECT @ids;

# 查询到任务则继续处理，否则不处理

# 程序中解析 @ids，查询待处理的任务
SELECT id, status, data FROM job_queue WHERE id IN(:ID1, :ID2...);

# 处理业务...

# 处理完成，标记任务为处理完成
UPDATE job_queue SET status=STATUS_FINISHED WHERE IN(:ID1, :ID2...);
```

优点是无锁、可以处理多个任务，缺点是使用了自定义变量，使用到的地方需要同时执行，防止连接断开后变量丢失。


### 4.先UPDATE，再SELECT，使用`更新批次`字段来记录待处理的任务

需要新增一个记录更新批次的字段：`batch_id`
```sql
ALTER TABLE `job_queue`
ADD COLUMN `batch_id` bigint UNSIGNED NULL
ADD INDEX(`batch_id`);
```

```sql
# 程序中生成唯一的`更新批次`编号，PHP 可以使用`base_convert(uniqid(), 16, 10)`

# 更新待处理的任务为处理中、`更新批次`为生成的数据
UPDATE job_queue SET status=STATUS_PROCESSING, batch_id=:BATCH_ID WHERE status=STATUS_PREPROCESS ORDER BY id ASC LIMIT 1;

# 如果更新的行数大于0，继续处理，否则不处理

# 通过`更新批次`查询出待处理的任务
SELECT id, status, data FROM job_queue WHERE batch_id=:BATCH_ID;

# 处理业务...

# 处理完成，标记任务为处理完成
UPDATE job_queue SET status=STATUS_FINISHED WHERE batch_id=:BATCH_ID;
```

优点是无锁、可以处理多个任务，缺点是新增了新字段。

PHP中使用`uniqid()`函数并发或分布式有可能重复，但我们这里是消费者生成，无并发情况可安全使用。


方案选择
---------

以上四种解决方案都可以解决问题，各有优缺点，前两种使用较简单，后两种使用稍繁琐，业务中推荐使用前两种。

如果是单任务处理推荐第二种方案，如果是多任务推荐第一种，虽然有行锁，但性能影响并不大，如果追求高性能的话又何必选择MySQL来作为队列使用，可以选择更专业的队列系统，如Kafka、RabbitMQ或RocketMQ等等。

不过中小型系统使用MySQL作为队列系统是一个非常好的选择，具有很好的稳定性。


运行机制
-------

### 生产者

生产者很简单，只需要往数据库中写数据即可，并标记为待处理

### 消费者

消费者主要有2个关键问题，一是如何运行消费者、二是消费者代码如何编写。

#### 如何运行消费者

由于消费者需要轮询检测是否有新的任务需要消费，首先想到的可能是使用Linux的定时任务`crontab`来定时启动，但`crontab`至少1分钟检测一次，有时候不一定能满足需求，这里我们使用`systemd`来启动一个或多个PHP脚本作为服务运行在后台的方式，Systemd 是 Linux 系统工具，用来启动守护进程，已成为大多数发行版的标准配置。

更多资料请移步[Systemd 入门教程：实战篇](http://www.ruanyifeng.com/blog/2016/03/systemd-tutorial-part-two.html)

新增一个systemd服务配置
```bash
vim /etc/systemd/system/myjob@.service
```

```ini
[Unit]
Description=myjob
After=network.target

[Service]
Type=simple
Restart=always
Restart=on-failure
User=root
ExecStart=/usr/bin/php /myjob/t.php

[Install]
WantedBy=multi-user.target
```

重新加载配置，让我们新增的配置生效
```bash
systemctl daemon-reload
```

```bash
# 启动多个服务，具体启动几个根据需求
systemctl start myjob@1 myjob@2 myjob@3

# 查查服务的状态
systemctl status "myjob@*"

# 设置为开机启动
systemctl enable myjob@1 myjob@2 myjob@3
```

有什么问题请及时检查`/var/log/messages`以排查问题

#### 消费者代码如何编写

先上代码 `/myjob/t.php`
```php
// 连接数据库
$pdo = new PDO('mysql:host=127.0.0.1;dbname=test;charSET=utf8', 'root', '');
$pdo->exec('SET NAMES utf8');

// 无限循环来保证程序不会停止
where (true) {
    // 是否有任务
    if (hasTask()) {
        // 启动事务
        $pdo->beginTransaction();

        // 查询任务队列
        $data = $pdo->query('SELECT id, status, data FROM job_queue WHERE status=0 ORDER BY id ASC LIMIT 5 FOR UPDATE')->fetchAll();

        // 标记为处理中
        if ($data) {
            $pdo->exec('UPDATE job_queue SET status=1 WHERE id IN(' . implode(',', array_column($data, 'id', 'id')) . ')');
        }

        // 提交事务
        $pdo->commit();

        // 处理任务队列，标记为已处理
        if ($data) {
            foreach ($data as $row) {
                // 处理任务……

                // 标为为已处理
                $pdo->exec('UPDATE job_queue SET status=2 WHERE id=' . $row['id']);
            }
        } else {
            // 设置为无任务
            setNoTask();
        }
    } else {
        // 轮询间隔
        sleep(1);
    }
}
```

这里有两点需要说明一下：

1. 使用`where (true)`来保证程序不会停止。
2. 函数`hasTask()`和`setNoTask()`是为了防止过多的数据库查询，只有当检测到有任务时才查询数据库，原理也很简单，但消费者产生新的任务时让`hasTask()`返回`true`即可。


参考
-----

* <https://blog.csdn.net/FrancisHe/article/details/72871905>
* <https://my.oschina.net/miaoyushun/blog/260778>