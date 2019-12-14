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
        if ($x == $l) {
            $x = 0;
        }
        $char .= $key{$x};
        $x++;
    }
    for ($i = 0; $i < $len; $i++) {
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
    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) {
            $x = 0;
        }
        $char .= substr($key, $x, 1);
        $x++;
    }
    for ($i = 0; $i < $len; $i++) {
        if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        } else {
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return $str;
}

/**
 * 加密
 * @param  string $text 待加密的字符串
 * @param  string $key  密码
 * @return string       返回加密后的字符串
 */
function encrypt2($text, $key = 'A8z;5YJv>'){
    $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
    $encryptText = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $text, MCRYPT_MODE_ECB, $iv);
    return trim(strtr(base64_encode($encryptText), array('/'=>'O0O0O', '=' => 'o000o', '+'=>'oo00o')));
}

/**
 * 解密
 * @param  string $text 待解密的字符串
 * @param  string $key  密码
 * @return string       返回解密后的字符串
 */
function decrypt2($text, $key = 'A8z;5YJv>')
{
    $cryptText = base64_decode(strtr($text, array('O0O0O'=>'/', 'o000o' => '=', 'oo00o' => '+')));
    $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
    $decryptText = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), $cryptText, MCRYPT_MODE_ECB, $iv);
    return trim($decryptText);
}

/**
 * 对称编码
 * 不是用于安全传输, 而是用于验证数据的合法来源
 * @param  mixed $data
 * @param  string $key
 * @return string
 */
function symmetry_encode($data, $key = 'XqNI@8sCmZ[=u@CJc#]L')
{
    $data = base64_encode(serialize($data));
    return md5($data . $key) . $data;
}

/**
 * 对称解码
 * @param  mixed $data
 * @param  string $key
 * @return string
 */
function symmetry_decode($data, $key = 'XqNI@8sCmZ[=u@CJc#]L')
{
    if (md5(substr($data, 32) . $key) === substr($data, 0, 32)) {
        return unserialize(base64_decode(substr($data, 32)));
    }
    return null;
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
    readfile($file);
}

/**
 * 读取文件最后一次修改时间，然后将获取的时间作为版本号
 * @param  {string} $file 文件
 * @return {string}       加上版本的文件
 */
function auto_version($file)
{
    $ver = 1;
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $file)) {
        $ver = date('YmdHis', filemtime($_SERVER['DOCUMENT_ROOT'] . $file));
    }
    return $file . '?v=' . $ver;
}

/**
 * 二维数组排序
 * array_order_by2($arr, 'age desc,name asc');
 * @param  array  &$arr  数组
 * @param  string $order 排序规则, 类似SQL的ORDER BY
 * @return array
 */
function array_order_by2(array &$arr, $order = null)
{
    if (is_null($order)) {
        return $arr;
    }
    $orders = explode(',', $order);
    usort($arr, function ($a, $b) use ($orders) {
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
            if (is_numeric($a[$field]) && is_numeric($b[$field])) {
                $result[] = $a[$field] - $b[$field];
            } else {
                $result[] = strcmp($a[$field], $b[$field]);
            }
        }
        return implode('', $result);
    });
    return $arr;
}

/**
 * 二维数组排序（支持array_multisort的全部参数）
 * array_order_by($arr, array(
 *     'age' => SORT_DESC,
 *     'name' => SORT_ASC,
 * );
 * @param  array  &$arr  数组
 * @param  array $order 排序规则, 键值对，键 => 排序
 * @return bool
 */
function array_order_by(array &$array, array $order)
{
    $args = array();
    foreach ($order as $field => $v) {
        if (is_string($field)) {
            $args[] = array_column($array, $field);
            if (is_array($v)) {
                list($sort, $flags) = $v;
                $args[] = $sort;
                $args[] = $flags;
            } else {
                $args[] = $v;
            }
        }
    }
    $args[] = &$array;
    return call_user_func_array('array_multisort', $args);
}

/**
 * 数字转字母
 * @param  int $index 数字: 0开始
 * @return string A B C ... AA AB ...
 */
function number_to_letter($index)
{
    $str = '';
    if (floor($index / 26) > 0) {
        $str .= number_to_letter(floor($index / 26) - 1);
    }
    return $str . chr($index % 26 + 65);
}

/**
 * 兼容参数:JSON_UNESCAPED_UNICODE 的json编码函数
 * @param  mixed $data
 * @return string
 */
function json_encode_unicode($data)
{
    if (defined('JSON_UNESCAPED_UNICODE')) {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    array_walk_recursive($data, function (&$item) {
        if (is_string($item)) {
            $item = mb_encode_numericentity($item, array(0x80, 0xffff, 0, 0xffff), 'UTF-8');
        }
    });
    return mb_decode_numericentity(json_encode($data), array(0x80, 0xffff, 0, 0xffff), 'UTF-8');
}

/**
 * 用二维数组创建树结构，树的键名和字段名称可自行修改
 * @param  array $list 待处理的二维数组
 * @return array       处理好的树结构数据
 */
function array_create_tree($list)
{
    $result = array();
    $list = array_column($list, null, 'id');
    foreach ($list as $item) {
        if (isset($list[$item['pid']]) && ! empty($list[$item['pid']])) {
            $list[$item['pid']]['children'][] = &$list[$item['id']];
        } else {
            $result[] = &$list[$item['id']];
        }
    }
    return $result;
}

/**
 * 是否是第一次执行
 *
 * @param string|int|null $token 标识
 * @return boolean
 */
function is_first($token = null)
{
    static $container = array();
    if (isset($container[$token])) {
        return false;
    }

    return $container[$token] = true;
}

/**
 * 字符串转数组
 * 主要是使用(,)作为默认分隔符和防止错误的数据类型和空字符串，比如null
 *
 * @param string $string
 * @param string $delimiter
 * @return array
 */
function string_to_array($string, $delimiter = ',')
{
    return is_string($string) && $string !== '' ? explode($delimiter, $string) : [];
}

/**
 * 数组转字符串
 * 主要是使用(,)作为默认分隔符和防止错误的数据类型
 *
 * @param array $array
 * @param string $delimiter
 * @return string
 */
function array_to_string($array, $delimiter = ',')
{
    return is_array($array) ? implode($delimiter, $array) : '';
}

/**
 * 生成随机数
 * @param  integer $length 字节长度
 * @return string
 */
function generate_random_token($length = 16)
{
    if (function_exists('random_bytes')) {
        return bin2hex(random_bytes($length));
    }
    if (function_exists('openssl_random_pseudo_bytes')) {
        return bin2hex(openssl_random_pseudo_bytes($length));
    }
    if (function_exists('mcrypt_create_iv')) {
        return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
    }
    if (@file_exists('/dev/urandom')) { // Get 100 bytes of random data
        return bin2hex(file_get_contents('/dev/urandom', false, null, 0, $length));
    }
    // Last resort which you probably should just get rid of:
    $randomData = mt_rand() . mt_rand() . mt_rand() . mt_rand() . microtime(true) . uniqid(mt_rand(), true);

    return substr(hash('sha512', $randomData), 0, $length * 2);
}

/**
 * 数据保护，支持账号、QQ号、手机号、身份证号、邮箱等信息
 * @param  string $string 字符串
 * @param  integer [$start] 开始保护的位置，默认为总长度的1/4
 * @param  integer [$end] 结束保护的位置，默认为总长度的1/4
 */
function get_mask_info($string, $start = null, $end = null)
{
    if (!is_string($string) || empty($string)) {
        return '';
    }
    $len = mb_strlen($string);
    $index = strpos($string, '@');
    $n = ceil(($index ? : $len) / 4);
    $start = is_null($start) ? $n : $start;
    $end = is_null($end) ? ($index ? $n + $len - $index : $n) : $end;
    if ($len <= $start + $end) {
        return $string;
    }
    return substr($string, 0, $start) . str_repeat('*', $len - $start - $end) . substr($string, -$end);
}
