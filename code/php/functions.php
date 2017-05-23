<?php
/**
 * 常用函数集合
 */


if (!function_exists('array_column')) {
    /**
     * Returns an array of values representing a single column from the input
     * array.
     * @param array $array A multi-dimensional array from which to pull a
     *     column of values.
     * @param mixed $columnKey The column of values to return. This value may
     *     be the integer key of the column you wish to retrieve, or it may be
     *     the string key name for an associative array. It may also be NULL to
     *     return complete arrays (useful together with index_key to reindex
     *     the array).
     * @param mixed $indexKey The column to use as the index/keys for the
     *     returned array. This value may be the integer key of the column, or
     *     it may be the string key name.
     * @return array
     */
    function array_column(array $array, $columnKey, $indexKey = null)
    {
        $result = array();
        foreach ($array as $subArray) {
            if (!is_array($subArray)) {
                continue;
            } elseif (is_null($indexKey) && array_key_exists($columnKey, $subArray)) {
                $result[] = $subArray[$columnKey];
            } elseif (array_key_exists($indexKey, $subArray)) {
                if (is_null($columnKey)) {
                    $result[$subArray[$indexKey]] = $subArray;
                } elseif (array_key_exists($columnKey, $subArray)) {
                    $result[$subArray[$indexKey]] = $subArray[$columnKey];
                }
            }
        }
        return $result;
    }
}

/**
 * 美化的var_dump()
 * > 更多丰富打印: https://github.com/zhanguangcheng/php-output
 */
function vd()
{
    ob_start();
    call_user_func_array('var_dump', func_get_args());
    echo preg_replace('/=>\n\s+/', '=> ', ob_get_clean());
}

/**
 * 格式化字节(略快)
 * @param  integer $size      字节
 * @param  string $delimiter 分隔符
 * @return string
 */
function format_bytes($size, $delimiter = '')
{
    static $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB', 'NB', 'DB');
    for ($i = 0; $size >= 1024 && $i < 10; $i++) {
        $size /= 1024;
    }
    return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 字节格式化(略慢)
 * @param  integer $size      字节
 * @param  string $delimiter 分隔符
 * @return string
 */
function bytes_format($size, $delimiter = '')
{
    if ($size <= 0) {
        return 0 . $delimiter . 'B';
    }
    static $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB', 'NB', 'DB');
    return round($size / pow(1024, $i = floor(log($size, 1024))), 2) . $delimiter . $units[$i];
}

/**
 * 使用反斜线引用字符串或者数组
 * @param  string | array $arr 待处理数据
 * @return string | array
 */
function addslashes_array($arr)
{
    if (is_array($arr)) {
       $data = array();
        foreach ($arr as $key => $value) {
            $data[addslashes($key)] = addslashes_array($value);
        }
        return $data;
    } else {
        return addslashes($arr);
    }
}

/**
 * 加密
 * @param  string $data 待加密的字符串
 * @param  string $key  密码
 * @return string       返回加密后的字符串
 */
function encrypt($data, $key)
{
    $key = md5($key);
    $x = 0;
    $len = strlen($data);
    $l = strlen($key);
    $char = $str = '';
    for ($i = 0; $i < $len; $i++) {
        if ($x == $l){
            $x = 0;
        }
        $char .= $key{$x};
        $x++;
    }
    for ($i = 0; $i < $len; $i++){
        $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
    }
    return base64_encode($str);
}

/**
 * 解密
 * @param  string $data 待解密的字符串
 * @param  string $key  密码
 * @return string       返回解密后的字符串
 */
function decrypt($data, $key)
{
    $key = md5($key);
    $x = 0;
    $data = base64_decode($data);
    $len = strlen($data);
    $l = strlen($key);
    $char = $str = '';
    for ($i = 0; $i < $len; $i++){
        if ($x == $l){
            $x = 0;
        }
        $char .= substr($key, $x, 1);
        $x++;
    }
    for ($i = 0; $i < $len; $i++) {
        if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))){
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        }else {
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return $str;
}

/**
 * 获取字符串中间的文本
 * @param  string $str   全文本
 * @param  string $start 起始文本
 * @param  string $end   结束文本
 * @return string
 */
function get_middle_text($str, $start, $end)
{
    $a = strpos($str, $start, 0) + strlen($start);
    $b = strpos($str, $end, $a);
    return substr($str, $a, $b - $a);
}

/**
 * 下载文件
 * @param  string $file     文件
 * @param  string $filename 文件名称(下载提示)
 */
function download($file, $filename = null)
{
    if (!is_file($file)) {
        return false;
    }
    $filename || $filename = basename($file);
    header('Content-Description: File Transfer');
    header('Content-type:application/octet-stream');
    header("Content-Disposition:filename=$filename");
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($file));
    ob_get_level() && ob_clean();
    readfile($file);
}

/**
 * 读取文件最后一次修改修改时间，然后将获取的时间作为版本号
 * @param  {string} $file 文件
 * @return {string}       加上版本的文件
 */
function auto_version($file)
{
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $file)) {
        $ver = date('YmdHis', filemtime($_SERVER['DOCUMENT_ROOT'] . $file));
    } else {
        $ver = 1;
    }
    return $file . '?v=' . $ver;
}

/**
 * 二维数组排序
 * array_order_by($arr, 'age desc,name asc');
 * @param  array  &$arr  数组
 * @param  string $order 排序规则, 类似SQL的ORDER BY
 * @return array
 */
function array_order_by(array &$arr, $order = null)
{
    if (is_null($order)) {
        return $arr;
    }
    $orders = explode(',', $order);
    usort($arr, function($a, $b) use($orders) {
        $result = array();
        foreach ($orders as &$value) {
            list($field, $sort) = array_map('trim', explode(' ', trim($value)));
            if (!(isset($a[$field]) && isset($b[$field]))) {
                continue;
            }
            if (strcasecmp($sort, 'desc') === 0) {
                $tmp = $a;
                $a = $b;
                $b = $tmp;
            }
            if (is_numeric($a[$field]) && is_numeric($b[$field]) ) {
                $result[] = $a[$field] - $b[$field];
            } else {
                $result[] = strcmp($a[$field], $b[$field]);
            }
        }
        return implode('', $result);
    });
    return $arr;
}
