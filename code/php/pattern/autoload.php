<?php

spl_autoload_register(function($className) {
    $file = str_replace('\\', '/', __DIR__ . '/' . $className . '.php');
    require $file;
});

function compare($result, $flag = 'test')
{
    if (true === $result) {
        echo "$flag ok\n";
    } else {
        echo "$flag error\n";
    }
}
