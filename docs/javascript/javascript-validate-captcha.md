JavaScript校验验证码思路
=======================

通常情况是提交表单时校验验证码或使用Ajax技术异步校验，但这样都需要服务端进行校验，接下来我们来看看如何在客户端校验。


生成验证码
--------

页面加载时，加载验证码图片和对应的验证码hash，刷新验证码时，重新生成验证码hash和验证码图片。


校验验证码
---------

将用户输入的验证码进行hash，和服务端生成的验证码hash对比，一致则输入正确，否则输入错误。


hash算法
----------

hash算法一般使用的MD5、SHA1或CRC32，这里我们使用更简单的算法：

将生成的验证码逐个遍历，将每个字符转换为ASCII码，然后相加得到的总和就时验证码hash结果，算法简单高效，无法逆向。

没错，这正是Yii2框架中验证码的校验思路，关键代码：

服务端生成验证码hash

`vendor\yiisoft\yii2\captcha\CaptchaAction.php`：
```php
class CaptchaAction extends Action
{
    /**
     * Generates a hash code that can be used for client-side validation.
     * @param string $code the CAPTCHA code
     * @return string a hash code generated from the CAPTCHA code
     */
    public function generateValidationHash($code)
    {
        for ($h = 0, $i = strlen($code) - 1; $i >= 0; --$i) {
            $h += ord($code[$i]);
        }

        return $h;
    }
}

```

客户端刷新验证码

`vendor\yiisoft\yii2\assets\yii.captcha.js`：
```javascript
(function ($) {
    var methods = {
        refresh: function () {
            var $e = this,
                settings = this.data('yiiCaptcha').settings;
            $.ajax({
                url: $e.data('yiiCaptcha').settings.refreshUrl,
                dataType: 'json',
                cache: false,
                success: function (data) {
                    $e.attr('src', data.url);
                    $('body').data(settings.hashKey, [data.hash1, data.hash2]);
                }
            });
        },
    };
})(window.jQuery);
```

客户端校验验证码

`vendor\yiisoft\yii2\assets\yii.validation.js`：
```javascript
yii.validation = (function ($) {
    var pub = {
        captcha: function (value, messages, options) {
            if (options.skipOnEmpty && pub.isEmpty(value)) {
                return;
            }

            // CAPTCHA may be updated via AJAX and the updated hash is stored in body data
            var hash = $('body').data(options.hashKey);
            hash = hash == null ? options.hash : hash[options.caseSensitive ? 0 : 1];
            var v = options.caseSensitive ? value : value.toLowerCase();
            for (var i = v.length - 1, h = 0; i >= 0; --i) {
                h += v.charCodeAt(i);
            }
            if (h != hash) {
                pub.addMessage(messages, options.message, value);
            }
        },
    };
    return pub;
})(jQuery);

```


总结
------

在客户端校验验证码是优化用户体验，不是替换服务端校验验证码。

当真正提交表单时服务端的校验也是必须的，原因是可以使用工具模拟HTTP请求，绕过JavaScript校验，这样的话客户端的任何校验都是形同虚设。

如此一来既提高了用户体检，也确保了安全性，鱼和熊掌亦可兼得😃。