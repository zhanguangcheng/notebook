yii2-queue的使用
===================

[yii2-queue](https://github.com/yiisoft/yii2-queue)是yii官方开发的队列扩展，可以异步运行任务以提高程序效率，支持基于DB，Redis，RabbitMQ，AMQP，Beanstalk，ActiveMQ和Gearman的队列


## 安装

```bash
composer require --prefer-dist yiisoft/yii2-queue
composer require --prefer-dist yiisoft/yii2-redis
```

## 基本使用(Redis驱动)

### 配置

配置在web和控制台程序配置文件中

```php
return [
    'bootstrap' => ['queue'],// 把这个组件注册到控制台
    'components' => [
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
        'queue' => [
            'class' => \yii\queue\redis\Queue::class,
            'as log' => \yii\queue\LogBehavior::class,
            'redis' => 'redis',// redis组件标识，可使用不同的redis组件
            'channel' => 'my-first-queue',// 队列标识
            'commandOptions' => [
                'isolate' => false,// 非隔离模式，性能更好
            ],
        ],
    ]
]
```

### 新建任务

app\queue\MyJob.php

```php
<?php

namespace app\queue;

use yii\base\BaseObject;

class MyJob extends BaseObject implements \yii\queue\JobInterface
{
    public $time;

    public function execute($queue)
    {
        echo $this->time;
        echo PHP_EOL;
    }
}
```

### 将任务添加到队列中

```php
$job_id = Yii::$app->queue->push(new \app\queue\MyJob([
    'time' => microtime(true)
]));
```

### 处理队列

* 使用crontab一次执行
    ```bash
    yii queue/run
    ```
* 启动一个守护进程来无限查询队列
    ```bash
    yii queue/listen
    ```

## 使用Systemd来管理队列服务

/etc/systemd/system/yii-queue@.service：
```ini
[Unit]
Description=Yii Queue Worker %I
After=network.target
After=redis.service
Requires=redis.service

[Service]
User=apache
Group=apache
ExecStart=/usr/bin/php /var/www/html/yii2-queue/yii queue/listen --verbose
ExecStop=
Restart=on-failure

[Install]
WantedBy=multi-user.target
```

```bash
systemctl daemon-reload
```

```bash
# To start two workers
systemctl start yii-queue@1 yii-queue@2

# To get status of running workers
systemctl status "yii-queue@*"

# To stop the worker
systemctl stop yii-queue@2

# To stop all running workers
systemctl stop "yii-queue@*"

# To start two workers at system boot
systemctl enable yii-queue@1 yii-queue@2
```

有什么问题请及时检查`/var/log/messages`以排查问题


## 使用案例

* <https://github.com/yiisoft-contrib/yiiframework.com/tree/master/jobs>
* <https://github.com/samdark/yiifeed/tree/master/components/queue>

## 文档

* [中文](https://github.com/yiisoft/yii2-queue/tree/master/docs/guide-zh-CN)