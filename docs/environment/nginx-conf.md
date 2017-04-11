nginx.conf中文说明
=================

```nginx
#定义Nginx运行的用户和用户组
user www www;

#nginx工作进程数，建议设置为等于CPU总核心数。还可以设置为auto
worker_processes auto;

#全局错误日志定义类型，[ debug | info | notice | warn | error | crit ]
error_log logs/error.log;

#保存进程id的文件
pid logs/nginx.pid;

#一个nginx进程打开的最多文件描述符数目，理论值应该是最多打开文件数（系统的值ulimit -n）与nginx进程数相除，但是nginx分配请求并不均匀，所以建议与ulimit -n的值保持一致。
worker_rlimit_nofile 51200;

#工作模式与连接数上限
events{
    #参考事件模型，use [ kqueue | rtsig | epoll | /dev/poll | select | poll ];
    #epoll模型是Linux 2.6以上版本内核中的高性能网络I/O模型，
    #如果跑在FreeBSD上面，就用kqueue模型。
    use epoll;

    #单个进程最大连接数（最大连接数=连接数*进程数）
    worker_connections 51200;

    #告诉nginx收到一个新连接通知后接受尽可能多的连接。on | off
    multi_accept on;
}

#设定http服务器
http{
    #文件扩展名与文件类型映射表
    include mime.types;

    #默认文件类型
    default_type application/octet-stream;

    #设置默认字符集utf-8 gbk gb2312 ...（服务器上有多种编码的项目，请不要使用）
    charset utf-8;

    #服务器名字的hash表大小
    server_names_hash_bucket_size 128;

    #设定请求缓存
    client_header_buffer_size 32k;

    #设定请求缓存
    large_client_header_buffers 4 64k;

    #设置客户端的上传文件大小限制
    client_max_body_size 8m;

    #开启高效文件传输模式，sendfile指令指定nginx是否调用sendfile函数来输出文件，对于普通应用设为 on，
    #如果用来进行下载等应用磁盘IO重负载应用，可设置为off，以平衡磁盘与网络I/O处理速度，降低系统的负载。
    #注意：如果图片显示不正常把这个改成off。
    sendfile on;

    #开启/关闭(on|off)目录列表访问，合适下载服务器，默认关闭。
    autoindex off;

    #防止网络阻塞，数据包不会马上传送出去，等到数据包最大时，一次性的传输出去，这样有助于解决网络堵塞
    tcp_nopush on;
    tcp_nodelay on;

    #长连接超时时间，单位是秒
    keepalive_timeout 120;

    #FastCGI相关参数是为了改善网站的性能：减少资源占用，提高访问速度。下面参数看字面意思都能理解。
    fastcgi_connect_timeout 300;
    fastcgi_send_timeout 300;
    fastcgi_read_timeout 300;
    fastcgi_buffer_size 64k;
    fastcgi_buffers 4 64k;
    fastcgi_busy_buffers_size 128k;
    fastcgi_temp_file_write_size 128k;

    #gzip模块设置
    gzip on; #开启gzip压缩输出
    gzip_min_length 1k; #最小压缩文件大小
    gzip_buffers 4 16k; #压缩缓冲区
    gzip_http_version 1.0; #压缩版本（默认1.1，前端如果是squid2.5请使用1.0）
    gzip_comp_level 2; #压缩等级
    gzip_types text/plain application/x-javascript text/css application/xml;

    #压缩类型，默认就已经包含text/html，所以下面就不用再写了，写上去也不会有问题，但是会有一个warn。
    gzip_vary on;

    #ie6禁用gzip压缩，否则会出现bug
    gzip_disable "MSIE [1-6]\.(?!.*SV1)";


    open_file_cache max=1000 inactive=20s;
    open_file_cache_valid 30s;
    open_file_cache_min_uses 2;
    open_file_cache_errors on;

    #虚拟主机的配置
    server{
        #监听的端口
        listen 80;

        #域名可以有多个，用空格隔开  _
        server_name www.xcx1.com xcx1.com;

        #自动索引文件
        index index.html index.htm index.php;

        #网站目录
        root /www;

        #是否开启目录浏览功能autoindex_exact_size:用KB,MB,GB..等单位显示， autoindex_localtime:用本地时间显示
        autoindex on;
        autoindex_exact_size off;
        autoindex_localtime on;

        #请求记录  access_log off 关闭            access
        access_log logs/access.log;

        #隐藏nginx的版本号 默认为on
        server_tokens off;

	#自定义错误页面
	error_page 404 /404.html;

        #隐藏index.php的通常做法（请求一个不存在的资源时，）
        location / {
            #if (!-e $request_filename) {
            #    rewrite ^/(.*)$ /index.php/$1 last;
            #}

	    #下行与上三行同样功能
            try_files $uri /index.php$uri?$query_string;
        }


        #将php的请求交给fastcgi处理，并让其支持PATHINFO
        location ~ [^/]\.php(/|$){
            fastcgi_index index.php;
            fastcgi_pass  127.0.0.1:9000;
            fastcgi_split_path_info ^(.+\.php)(.*)$;
            fastcgi_param PATH_INFO $fastcgi_path_info;
            include fastcgi.conf;
        }

        #设置图片等缓存时间
        #设置成功并在过期时间内会返回200 from cache
        #超过过期时间时，文件没有被修改会返回304 Not Modified，已经被修改会返回200 OK(拉取最新资源)
        location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$ {
            expires 7d;
        }

        #设置css,js缓存时间
        location ~ .*\.(js|css)?$ {
            expires 1d;
        }

        location = / {
           #规则A
        }

        # 语法规则： location [=|~|~*|^~] /uri/ { … }
        # = 开头表示精确匹配
        # ^~ 开头表示uri以某个常规字符串开头，理解为匹配 url路径即可。nginx不对url做编码，因此请求为/static/20%/aa，可以被规则^~ /static/ /aa匹配到（注意是空格）。
        # ~ 开头表示区分大小写的正则匹配
        # ~*  开头表示不区分大小写的正则匹配
        # !~和!~*分别为区分大小写不匹配及不区分大小写不匹配 的正则
        # / 通用匹配，任何请求都会匹配到。
        # 多个location配置的情况下匹配顺序为（参考资料而来，还未实际验证，试试就知道了，不必拘泥，仅供参考）:
        # 首先匹配 =，其次匹配^~, 其次是按文件中顺序的正则匹配，最后是交给 / 通用匹配。当有匹配成功时候，停止匹配，按当前匹配规则处理请求。
    }
}
```



