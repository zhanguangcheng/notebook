<?php

/**
 * UUID 生成类
 * @author  GuangCheng Zhan <14712905@qq.com>
 * @date 2016-11-05
 * @version  1.0
 * UUID::create();
 */
class UUID
{
    public static function create($prefix = '')
    {
        if (function_exists('com_create_guid')) {
            return $prefix . trim(com_create_guid(), '{}');
        }

        $char = strtoupper(md5(uniqid(mt_rand(), true)));
        return $prefix
            . substr($char, 0, 8) . '-'
            . substr($char, 8, 4) . '-'
            . substr($char,12, 4) . '-'
            . substr($char,16, 4) . '-'
            . substr($char,20,12);
    }
}
