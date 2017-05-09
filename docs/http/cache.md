
网页的缓存是由http消息头中的“Cache-control”来控制的，常见的取值有private、no-cache、max-age、must-revalidate等，默认为private。

根据不同的重新浏览方式分为以下几种情况： 

（1） 打开新窗口 
值为private、no-cache、must-revalidate，那么打开新窗口访问时都会重新访问服务器。 

而如果指定了max-age值，那么在此值内的时间里就不会重新访问服务器，例如： 

Cache-control: max-age=5(表示当访问此网页后的5秒 内再次访问不会去服务器) 

（2） 在地址栏回车 

值为private或must-revalidate则只有第一次访问时会访问服务器，以后就不再访问。 

值为no-cache，那么每次都会访问。 

值为max-age，则在过期之前不会重复访问。 

（3） 按后退按扭 

值为private、must-revalidate、max-age，则不会重访问， 

值为no-cache，则每次都重复访问 

（4） 按刷新按扭 


无论为何值，都会重复访问 

Cache-control值为“no-cache”时，访问此页面不会在Internet临时文章夹留下页面备份

另外，通过指定“Expires”值也会影响到缓存

比如：禁止页面在IE中缓存 

http响应消息头部设置： 

CacheControl = no-cache 
Pragma=no-cache 
Expires = -1 

Expires是个好东东，如果服务器上的网页经常变化，就把它设置为-1，表示立即过期

为了向后兼容 HTTP 1.0 服务器，IE使用Pragma:no-cache 标题对 HTTP 提供特殊支持。 
