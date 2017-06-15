define(['jquery'], function() {
    console.log('run module1.js');
    var func1 = function() {
        console.log('module1.func1()', $);
    }

    // 导出
    return {
        func1: func1,
        data: {
            "name": "Grass",
            "age": 18
        }
    };
});
