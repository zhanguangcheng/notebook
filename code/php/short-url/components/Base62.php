<?php

namespace app\components;
/**
 * 62进制和10进制转换
 */
class Base62
{
    /**
     * 基础序列
     * @var string
     */
    private static $base = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    
    public static function setList($list)
    {
        self::$base = $list;
    }

    public static function encode($integer, $base = null)
    {
        $result = '';
        $base = $base ?: self::$base;
        while ($integer > 0) {
            $result = $base[bcmod($integer, 62)] . $result;
            $integer = bcdiv($integer, 62, 0);
        }
        return $result;
    }

    public static function decode($string, $base = null)
    {
        $result = 0;
        $len = strlen($string);
        $base = $base ?: self::$base;
        for ($i = 0; $i < $len; $i++) {
            $result = bcadd($result, bcmul(bcpow(62, $len - $i - 1), strpos($base, $string[$i])));
        }
        return $result;
    }
}
