<?php
$ips = require './data/ips.txt';
require './Ip2Region.class.php';

$obj = new Ip2Region('./data/ip2region.db');

$s_time = getTime();
$s = '';
for ($i=0; $i < count($ips); $i++) { 
    $res = $obj->btreeSearch($ips[$i]);
    $id = str_pad($res['city_id'], 10);
    $ip = str_pad($ips[$i], 16);
    $s .= "{$id}{$ip}{$res['region']}\n";
}
$c_time = getTime() - $s_time;

printf("%.5f millseconds\n", $c_time);
file_put_contents('data/ips_ok.txt', $s);

function getTime() {
    return (microtime(true) * 1000);
}
