<?php
/*
单例模式
类只能产生一个对象
 */

require '../autoload.php';
use singleton\Singleton;
use singleton\Db;

/*
// Fatal error:
    new Singleton;
    clone Singleton;
 */

$instance = Singleton::getInstance();
$instance2 = Singleton::getInstance();
compare($instance === $instance2, 'singleton');

$db = Db::getInstance();
$db2 = Db::getInstance();
compare($db === $db2, 'singleton');

compare($db !== $instance, 'singleton');
