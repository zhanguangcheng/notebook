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
 * 获取人性化的时间
 * @param int $timestamp 时间搓
 * @return string
 */
function timeago($timestamp)
{
    $now = time();
    $time = $now - $timestamp;
    if ($timestamp > $now) {
        return date('Y.m.d', $timestamp);
    } elseif ($time < 60) {
        return '刚刚';
    } elseif ($time < 3600) {
        return floor($time / 60) . '分钟前';
    } elseif ($time < 86400) {
        return floor($time / 3600) . '小时前';
    } elseif ($time < 604800) {
        return '本周';
    } elseif ($time < 2592000) {
        return floor($time / 86400) . '天前';
    } elseif ($time < 31536000) {
        return floor($time / 2592000) . '个月前';
    } elseif ($time < 94608000) {
        return floor($time / 31536000) . '年前';
    } else {
        return date('Y.m.d', $timestamp);
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
 * 格式化字节
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
 * 格式化时间戳
 * 格式化秒为时分秒的格式
 * @param  int $time      时间搓
 * @return string
 */
function format_timestamp($time)
{
    if ($time < 1) {
        return '';
    } elseif ($time < 60) {
        return $time . '秒';
    } elseif ($time < 3600) {
        return floor($time / 60) . '分' . format_timestamp($time % 60);
    } elseif ($time < 86400) {
        return floor($time / 3600) . '时' . format_timestamp($time % 3600);
    } else {
        return floor($time / 86400) . '天' . format_timestamp($time % 86400);
    }
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

/**
 * 检测指定服务器是否通畅
 * @param string $host
 * @param int $port
 * @param int $timeout
 * @return bool
 */
function ping($host, $port, $timeout = 1)
{
    $fp = @fsockopen($host, $port, $errno, $errstr, $timeout);
    if ($fp) {
        fclose($fp);
        return true;
    }
    return false;
}

/**
 * 保证返回数组
 * @param mixed $array
 * @return array
 */
function be_array($array)
{
    return is_array($array) ? $array : array();
}

/**
 * 获取农历年
 * @param string $year 2020
 * @param string $return_type 返回数据类型
 */
function get_lunar_year_name($year, $return_type = 'zh') {
    if ($return_type === 'zh') {
        $sky   = array('庚', '辛', '壬', '癸', '甲', '乙', '丙', '丁', '戊', '己');
        $earth = array('申', '酉', '戌', '亥', '子', '丑', '寅', '卯', '辰', '巳', '午', '未');
    } else {
        $sky   = array('G', 'X', 'R', 'G', 'J', 'Y', 'B', 'D', 'W', 'J');
        $earth = array('S', 'Y', 'X', 'H', 'Z', 'C', 'Y', 'M', 'C', 'S', 'W', 'W');
    }
    return $sky[substr($year, 3, 1)] . $earth[$year % 12];
}

/**
 * 获取百分比
 */
function get_percent($m, $n, $suffix = '%')
{
    if ($n <= 0) {
        return '0' . $suffix;
    }
    return round($m / $n * 100, 2) . $suffix;
}

/**
 * 获取毫秒时间戳
 */
function millitime()
{
    return floor(microtime(true) * 1000);
}

/**
 * Parses a user agent string into its important parts
 *
 * @author Jesse G. Donat <donatj@gmail.com>
 * @link https://github.com/donatj/PhpUserAgent
 * @link http://donatstudios.com/PHP-Parser-HTTP_USER_AGENT
 * @param string|null $u_agent User agent string to parse or null. Uses $_SERVER['HTTP_USER_AGENT'] on NULL
 * @throws \InvalidArgumentException on not having a proper user agent to parse.
 * @return string[] an array with browser, version and platform keys
 */
function parse_user_agent($u_agent = null)
{
    if (is_null($u_agent)) {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $u_agent = $_SERVER['HTTP_USER_AGENT'];
        } else {
            throw new InvalidArgumentException('parse_user_agent requires a user agent');
        }
    }
    $platform = null;
    $browser  = null;
    $version  = null;
    $empty = array( 'platform' => $platform, 'browser' => $browser, 'version' => $version );
    if (!$u_agent) {
        return $empty;
    }
    if (preg_match('/\((.*?)\)/im', $u_agent, $parent_matches)) {
        preg_match_all('/(?P<platform>BB\d+;|Android|CrOS|Tizen|iPhone|iPad|iPod|Linux|Macintosh|Windows(\ Phone)?|Silk|linux-gnu|BlackBerry|PlayBook|X11|(New\ )?Nintendo\ (WiiU?|3?DS)|Xbox(\ One)?)
                (?:\ [^;]*)?
                (?:;|$)/imx', $parent_matches[1], $result, PREG_PATTERN_ORDER);
        $priority = array( 'Xbox One', 'Xbox', 'Windows Phone', 'Tizen', 'Android', 'CrOS', 'X11' );
        $result['platform'] = array_unique($result['platform']);
        if (count($result['platform']) > 1) {
            if ($keys = array_intersect($priority, $result['platform'])) {
                $platform = reset($keys);
            } else {
                $platform = $result['platform'][0];
            }
        } elseif (isset($result['platform'][0])) {
            $platform = $result['platform'][0];
        }
    }
    if ($platform == 'linux-gnu' || $platform == 'X11') {
        $platform = 'Linux';
    } elseif ($platform == 'CrOS') {
        $platform = 'Chrome OS';
    }
    preg_match_all(
        '%(?P<browser>Camino|Kindle(\ Fire)?|Firefox|Iceweasel|IceCat|Safari|MSIE|Trident|AppleWebKit|
                TizenBrowser|Chrome|Vivaldi|IEMobile|Opera|OPR|Silk|Midori|Edge|CriOS|UCBrowser|Puffin|SamsungBrowser|
                Baiduspider|Googlebot|YandexBot|bingbot|Lynx|Version|Wget|curl|
                Valve\ Steam\ Tenfoot|
                NintendoBrowser|PLAYSTATION\ (\d|Vita)+)
                (?:\)?;?)
                (?:(?:[:/ ])(?P<version>[0-9A-Z.]+)|/(?:[A-Z]*))%ix',
        $u_agent,
        $result,
        PREG_PATTERN_ORDER
    );
    // If nothing matched, return null (to avoid undefined index errors)
    if (!isset($result['browser'][0]) || !isset($result['version'][0])) {
        if (preg_match('%^(?!Mozilla)(?P<browser>[A-Z0-9\-]+)(/(?P<version>[0-9A-Z.]+))?%ix', $u_agent, $result)) {
            return array( 'platform' => $platform ?: null, 'browser' => $result['browser'], 'version' => isset($result['version']) ? $result['version'] ?: null : null );
        }
        return $empty;
    }
    if (preg_match('/rv:(?P<version>[0-9A-Z.]+)/si', $u_agent, $rv_result)) {
        $rv_result = $rv_result['version'];
    }
    $browser = $result['browser'][0];
    $version = $result['version'][0];
    $lowerBrowser = array_map('strtolower', $result['browser']);
    $find = function ($search, &$key, &$value = null) use ($lowerBrowser) {
        $search = (array)$search;
        foreach ($search as $val) {
            $xkey = array_search(strtolower($val), $lowerBrowser);
            if ($xkey !== false) {
                $value = $val;
                $key   = $xkey;
                return true;
            }
        }
        return false;
    };
    $key = 0;
    $val = '';
    if ($browser == 'Iceweasel' || strtolower($browser) == 'icecat') {
        $browser = 'Firefox';
    } elseif ($find('Playstation Vita', $key)) {
        $platform = 'PlayStation Vita';
        $browser  = 'Browser';
    } elseif ($find(array( 'Kindle Fire', 'Silk' ), $key, $val)) {
        $browser  = $val == 'Silk' ? 'Silk' : 'Kindle';
        $platform = 'Kindle Fire';
        if (!($version = $result['version'][$key]) || !is_numeric($version[0])) {
            $version = $result['version'][array_search('Version', $result['browser'])];
        }
    } elseif ($find('NintendoBrowser', $key) || $platform == 'Nintendo 3DS') {
        $browser = 'NintendoBrowser';
        $version = $result['version'][$key];
    } elseif ($find('Kindle', $key, $platform)) {
        $browser = $result['browser'][$key];
        $version = $result['version'][$key];
    } elseif ($find('OPR', $key)) {
        $browser = 'Opera Next';
        $version = $result['version'][$key];
    } elseif ($find('Opera', $key, $browser)) {
        $find('Version', $key);
        $version = $result['version'][$key];
    } elseif ($find('Puffin', $key, $browser)) {
        $version = $result['version'][$key];
        if (strlen($version) > 3) {
            $part = substr($version, -2);
            if (ctype_upper($part)) {
                $version = substr($version, 0, -2);
                $flags = array( 'IP' => 'iPhone', 'IT' => 'iPad', 'AP' => 'Android', 'AT' => 'Android', 'WP' => 'Windows Phone', 'WT' => 'Windows' );
                if (isset($flags[$part])) {
                    $platform = $flags[$part];
                }
            }
        }
    } elseif ($find(array( 'IEMobile', 'Edge', 'Midori', 'Vivaldi', 'SamsungBrowser', 'Valve Steam Tenfoot', 'Chrome' ), $key, $browser)) {
        $version = $result['version'][$key];
    } elseif ($rv_result && $find('Trident', $key)) {
        $browser = 'MSIE';
        $version = $rv_result;
    } elseif ($find('UCBrowser', $key)) {
        $browser = 'UC Browser';
        $version = $result['version'][$key];
    } elseif ($find('CriOS', $key)) {
        $browser = 'Chrome';
        $version = $result['version'][$key];
    } elseif ($browser == 'AppleWebKit') {
        if ($platform == 'Android' && !($key = 0)) {
            $browser = 'Android Browser';
        } elseif (strpos($platform, 'BB') === 0) {
            $browser  = 'BlackBerry Browser';
            $platform = 'BlackBerry';
        } elseif ($platform == 'BlackBerry' || $platform == 'PlayBook') {
            $browser = 'BlackBerry Browser';
        } else {
            $find('Safari', $key, $browser) || $find('TizenBrowser', $key, $browser);
        }
        $find('Version', $key);
        $version = $result['version'][$key];
    } elseif ($pKey = preg_grep('/playstation \d/i', array_map('strtolower', $result['browser']))) {
        $pKey = reset($pKey);
        $platform = 'PlayStation ' . preg_replace('/[^\d]/i', '', $pKey);
        $browser  = 'NetFront';
    }
    return array( 'platform' => $platform ?: null, 'browser' => $browser ?: null, 'version' => $version ?: null );
}
