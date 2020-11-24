/**
 * ```js
 *  var event = new EventHandler();
 *
 *  // 添加事件
 *  event.on('one', func1);
 *  event.on('two', func2, event);
 *
 *  // 触发事件
 *  event.emit('one');
 *  event.emit('one', 'arg');
 *
 *  // 移除事件
 *  event.off();
 *  event.off('one');
 *  event.off('one', func1);
 *
 *  function func1() {
 *      console.log('func1', this);
 *      event.emit('two', 1, 2, 3);
 *  }
 *  function func2(a, b, c) {
 *      console.log('func2', this, a, b, c);
 *  }
 * ```
 */

var EventHandler = function () {
    var _stores = {}, on, emit, off;
    on = function (event, fn, ctx) {
        if (typeof fn !== 'function') {
            console.error('listener must be a function');
            return;
        }
        (_stores[event] = _stores[event] || []).push({ cb: fn, ctx: ctx });
    };
    emit = function (event) {
        var store = _stores[event];
        if (!store) return;
        var args = Array.prototype.slice.call(arguments, 1);
        for (var i = 0, len = store.length; i < len; i++) {
            store[i].cb.apply(store[i].ctx, args);
        }
        return true;
    };
    off = function (event, fn) {
        if (!arguments.length) {
            _stores = {};
            return;
        }
        var store = _stores[event];
        if (!store) return false;
        if (!fn) {
            _stores[event] = [];
            return;
        }
        for (var i = store.length - 1; i >= 0; i--) {
            if (store[i].cb === fn) {
                store.splice(i, 1);
            }
        }
    };
    return {
        on: on,
        emit: emit,
        off: off
    };
};
