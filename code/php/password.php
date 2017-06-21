<?php
/*
MD5加密密码的替代方案

PHP版本为 5.3.7 ~ 5.5.0 之间的可以使用兼容库
https://github.com/ircmaxell/password_compat/

(PHP 5 >= 5.5.0, PHP 7)
创建密码的哈希（hash）
string password_hash ( string $password , integer $algo [, array $options ] )

验证密码是否和哈希匹配
boolean password_verify ( string $password , string $hash )

检测哈希是否需要刷新
boolean password_needs_rehash ( string $hash , integer $algo [, array $options ] )

返回指定哈希（hash）的相关信息
array password_get_info ( string $hash )
*/

/* 创建hash */
$password = 'admin';
$hash =  password_hash($password, PASSWORD_DEFAULT);
var_dump('hash:', $hash);
echo PHP_EOL;

/* 判断hash是否需要刷新 */
$need = password_needs_rehash($hash, PASSWORD_DEFAULT);
var_dump('need:', $need);
echo PHP_EOL;

/* 验证hash */
$verify = password_verify($password, $hash);
var_dump('verify:', $verify);
echo PHP_EOL;

/* 获取hash信息 */
$info = password_get_info($hash);
var_dump('info:', $info);


/* 
业务

// 注册
password_hash() -> 入库

// 登录
password_verify() -> 验证密码 -> 成功 -> password_needs_rehash() -> true -> password_hash() -> 入库

*/
