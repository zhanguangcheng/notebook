
## 抛出错误, 并停止运行, ie6+
```js
throw new Error("error info");
```

## ie7- 的json格式数据最后一个元素后面不能写逗号(,)  否则会抛出"缺少标识符、字符串或数字" 的错误信息, 例如下面这样
```js
// 非标准json
var json = {
name: 'grass',
age: 18,
}
```

## 解析&反解析JSON使用JSON对象, 如需兼容ie7以下使用兼容库https://github.com/douglascrockford/JSON-js
```js
JSON.parse('JSON字符串');
JSON.stringify('JSON对象');
```

## 不支持console兼容方法(防止报错, 终止程序), 兼容性: ie6,7不支持, ie8,9需要打开控制台才支持
```js
var console = console || {log: function () {}};
```

## Avoid `console` errors in browsers that lack a console.
```js
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeline', 'timelineEnd', 'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());
```

## 数组合并
```js
arr = [1, 2];
arr.concat(3, 4)// [1, 2, 3, 4]
arr.concat([3, 4])// [1, 2, 3, 4]
arr.concat([3, [4, 5]])// [1, 2, 3, [4, 5]]
```

## jQuery事件委派
```js
// $('范围').delegate('事件元素', '事件', '回调');
$('#goods-list').delegate('.delete', 'click', function(event) {
    // do some thing
});
```

## jQuery事件推荐方式
```js
// 使用事件冒泡机制绑定到#range, .fn-delete为过滤器
$('#range').on('click', '.fn-delete', function(event) {
    // do some thing
});
```

## a链接javascript:fun1(this);这里的this代表window, 不是元素本身
```html
<a href="javascript:fun1(this);">link</a>
```

## script标签默认都是同步加载js脚本, 会阻塞页面加载, 因此一般将js脚本放到最后</body>之前, 也可以通过设置属性async="true"来进行异步加载(如果你是使用的AMD规范的话)
```html
<script src="//cdn.bootcss.com/jquery/1.8.3/jquery.min.js"></script>
<script>
    console.log($);// function (e,t){return new v.fn.init(e,t,n)}
</script>
```
```html
<script defer async="true" src="//cdn.bootcss.com/jquery/1.8.3/jquery.min.js"></script>
<script>
    console.log($);// $ is not defined
</script>
```
