
// 抛出错误, 并停止运行, ie6+
{
    throw new Error("error info");
}

// ie7 的json格式数据最后一个元素后面不能写逗号(,)  否则会抛出"缺少标识符、字符串或数字" 的错误信息, 例如下面这样
{
    var json = {
    name: 'grass',
    age: 18,
    }
}

// 解析&反解析JSON使用JSON对象, 如需兼容ie7以下使用兼容库https://github.com/douglascrockford/JSON-js
{
    JSON.parse('JSON字符串');
    JSON.stringify('JSON对象');
}

// ie6 不支持console兼容方法(防止报错, 终止程序)
{
    var console = console || {log: function () {}};
}

// Avoid `console` errors in browsers that lack a console.
{
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
}

// 数组合并
{
    arr = [1, 2];
    arr.concat(3, 4)// [1, 2, 3, 4]
    arr.concat([3, 4])// [1, 2, 3, 4]
    arr.concat([3, [4, 5]])// [1, 2, 3, [4, 5]]
}

// jQuery事件委派
{
    // $('范围').delegate('事件元素', '事件', '回调');
    $('#goods-list').delegate('.delete', 'click', function(event) {
        // do some thing
    });
}

// a链接javascript:fun1(this);这里的this代表window, 不是元素本身
{
    
}
