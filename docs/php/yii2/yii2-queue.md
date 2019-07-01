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

## 使用案例

* <https://github.com/yiisoft-contrib/yiiframework.com/tree/master/jobs>
* <https://github.com/samdark/yiifeed/tree/master/components/queue>

## 文档

* [中文](https://github.com/yiisoft/yii2-queue/tree/master/docs/guide-zh-CN)