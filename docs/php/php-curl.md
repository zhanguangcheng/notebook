PHP cURL
=============

常用函数
----------

    resource curl_init    ([ string $url = NULL ] )
    void     curl_close   ( resource $ch )
    bool     curl_setopt  ( resource $ch , int $option , mixed $value )
    mixed    curl_exec    ( resource $ch )
    void     curl_close   ( resource $ch )
    int      curl_errno   ( resource $ch )
    string   curl_error   ( resource $ch )
    mixed    curl_getinfo ( resource $ch [, int $opt = 0 ] )
             curl_multi_*

常用选项
----------

    CURLOPT_URL             URL地址
    CURLOPT_HTTPHEADER      设置HTTP请求头的数组。格式： ["key:value"]
    CURLOPT_USERAGENT       设置HTTP请求头"User-Agent"
    CURLOPT_REFERER         设置HTTP请求头"Referer"
    CURLOPT_COOKIE          设置HTTP请求头"Cookie"
    CURLOPT_COOKIESESSION   是否开启新的session会话，默认false，沿用以前的session会话
    CURLOPT_COOKIEFILE      读取cookie的文件，从该文件中读取cookie信息发送请求头
    CURLOPT_COOKIEJAR       写入cookie的文件，curl_close时写入cookie时保存的文件
    CURLOPT_AUTOREFERER     重定向时，自动设置请求头中的Referer:信息，默认false，不设置
    CURLOPT_FOLLOWLOCATION  自动请求重定向的URL，配合CURLOPT_MAXREDIRS使用，默认false，不自动请求
    CURLOPT_MAXREDIRS       限制重定向的次数，配合CURLOPT_FOLLOWLOCATION使用
    CURLOPT_TIMEOUT         设置请求超时时间（秒）
    CURLOPT_SSL_VERIFYHOST  检查服务器SSL证书的方式，0：不检查，1：（已废弃）2：域名是否存在且与主机名匹配，默认为2
    CURLOPT_SSL_VERIFYPEER  是否验证对等证书，默认为true
    CURLOPT_POST            是否使用POST请求，默认false，使用POST时会自动添加请求头："Content-Type: application/x-www-form-urlencoded"
    CURLOPT_POSTFIELDS      使用POST请求时的请求数据，可使用字符串和数组两种参数，字符串(推荐)：格式类似类似'para1=val1&para2=val2&...' 数组：['para1'=>'val1',...]，区别是为数组时Content-Type头将会被设置成multipart/form-data
    CURLOPT_HTTPGET         是否使用GET请求，默认true，所以只有请求方式被修改时才需要这个选项
    CURLOPT_HEADER          是否包含响应头，默认false，不返回
    CURLOPT_RETURNTRANSFER  返回还是输出响应内容，true：返回，false：输出，默认false，直接输出
    CURLOPT_CUSTOMREQUEST   自定义请求类型，如HEAD，PUT，DELETE等等，请求RESTful接口时非常有用
    CURLINFO_HEADER_OUT     curl_getinfo返回值中是否包含请求头，默认false，不返回
    CURLOPT_HEADERFUNCTION  设置响应头的回调函数
