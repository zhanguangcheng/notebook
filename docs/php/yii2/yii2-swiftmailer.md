yii2-swiftmailer的使用
======================

[yii2-swiftmailer](https://github.com/yiisoft/yii2-swiftmailer)使用[SwiftMailer](https://github.com/swiftmailer/swiftmailer)为Yii2框架提供了邮件解决方案。

## 安装

```bash
# php7.0+
composer -vvv require --prefer-dist yiisoft/yii2-swiftmailer:~2.1.0

# php 5.4+
composer -vvv require --prefer-dist yiisoft/yii2-swiftmailer:~2.0.5
```


## 配置

```php
return [
    //....
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // 真实发送，为true时使用文件保存发送的邮件，可用于自动化测试。
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'localhost',
                'username' => 'username',
                'password' => 'password',
                'port' => '465',
                'encryption' => 'ssl',
                'StreamOptions'=>[
                    // fwrite(): SSL: Broken pipe
                    'ssl' => [
                        'allow_self_signed' => true,
                        'verify_peer' => false
                    ]
                ],
            ],
        ],
    ],
];
```

## hello world

```php
try {
    // 不使用视图
    Yii::$app->mailer->compose()
        ->setFrom('from@domain.com')
        ->setTo('to@domain.com')
        ->setSubject('hello')
        ->setHtmlBody('<h1>hello world</h1>')
        ->send();
} catch (\Exception $e) {
    // send error
}
 ```

 ## 使用视图发送邮件

视图文件@app/mail/user/verify.php：
 ```html
 <p>verify code:<code><?php echo $code ?></code></p>
 ```

发送代码示例：
 ```php
try {
    // 创建[[yii\swiftmailer\Message]]对象
    $message = Yii::$app->mailer->compose('@app/mail/user/verify', ['code' => 1234]);

    $message->setFrom('from@domain.com')
        ->setTo('to@domain.com')
        ->setSubject('your verify code');
    $message->send();// or Yii::$app->mailer->send($message);
    // send successful
} catch (\Exception $e) {
    // send error
}
 ```

> 提示：当compose设置了视图并且message实例调用了`setTextBody()`或`setHtmlBody()`，则后者优先。

## API

### yii\swiftmailer\Mailer

属性

 * `public $transport = []`
    - @var \Swift_Transport | array Swift_Transport实例或其数组配置。
 * `public $messageConfig = []`
    - @var array message实例的配置，应该应用于任何新创建的配置
    - [[createMessage()]]或[[compose()]]的电子邮件实例。任何有效的属性定义
    - 可以配置[[MessageInterface]]，例如`from`，`to`，`subject`，`textBody`，`htmlBody`等。
 * `public $useFileTransport = false`
    - @var bool 是否将电子邮件保存为[[fileTransportPath]]下的文件而不是发送它们
    - 对于实际的收件人。这通常在开发期间用于调试目的。
 * `public $fileTransportPath = '@runtime/mail'`
    - @var string [[useFileTransport]]为true时保存电子邮件的目录。
 * `public $htmlLayout = 'layouts/html'`
    - @var string | bool HTML布局视图名称。这是用于呈现HTML邮件正文的布局。
    - 该属性可以采用以下值：
        - 相对视图名称：相对于[[viewPath]]的视图文件，例如'layouts/html'。
        -  [路径别名]（指南：概念别名）：指定为路径别名的绝对视图文件路径，例如'@app/mail/html'。
        - 布尔值false：布局被禁用。
 * `public $textLayout = 'layouts/text'`
    - @var string | bool文本布局视图名称。这是用于呈现TEXT邮件正文的布局。
    - 请参阅[[htmlLayout]]了解此属性可以采用的值。

方法

* `public function compose($view = null, array $params = [])
    - 创建一个新的`message`实例，并可选择通过视图呈现来组合其正文内容。
    - @param string | array | null $view 用于呈现邮件正文的视图。这可以是：
        - 一个字符串，表示视图名称或[路径别名]（指南：概念别名），用于呈现电子邮件的HTML正文。
            在这种情况下，将通过将`strip_tags()`应用于HTML正文来生成文本正文。
        - 带有'html' and/or 'text'元素的数组。 'html'元素引用视图名称或路径别名
            用于呈现HTML正文，而'text'元素用于呈现文本正文。例如，
            `['html'=>'contact-html'，'text'=>'contact-text']`。
        - null，表示将返回没有正文内容的消息实例。
    - 可以使用以下格式之一指定要呈现的视图：
        - 路径别名（例如“@app/mail/contact”）;
        - 位于[[viewPath]]下的相对视图名称（例如“contact”）。
    - @param array $params 将提取并在视图文件中可用的参数（name => value）。
    - @return MessageInterface 消息实例。
* `public function send($message)`
    - 发送给定的电子邮件。
    - 此方法将记录有关正在发送的电子邮件的消息。
    - 如果[[useFileTransport]]为true，则会将电子邮件另存为[[fileTransportPath]]下的文件。
    - 否则，它将调用[[sendMessage()]]将电子邮件发送给其收件人。
    - 子类应该使用实际的电子邮件发送逻辑实现[[sendMessage()]]。
    - @param MessageInterface $message 电子邮件message实例
    - @return bool 消息是否已成功发送
### yii\swiftmailer\Message
 
属性

* `public $mailer`
    - @var MailerInterface 创建此消息的邮件程序实例。

方法

* `public function setFrom($from)`
    - 设置邮件发件人。
    - @param string | array $from 发件人电子邮件地址。
    - 如果此消息来自多个人，您可以传递一组地址。
    - 您还可以使用以下格式指定电子邮件地址以外的发件人姓名：`[email => name]`
    - @return $this
* `public function setTo($to)`
    - 设置邮件收件人。
    - @param string | array $to 收件人的电子邮件地址。
    - 如果多个收件人应收到此邮件，您可以传递一组地址。
    - 您还可以使用以下格式指定电子邮件地址以外的收件人姓名： `[email => name]`
    - @return $this
* `public function setCc($cc)`
    - 设置此消息的抄送地址。
    - @param string | array $cc copy receiver email address。
    - 如果多个收件人应收到此邮件，您可以传递一组地址。
    - 您还可以使用以下格式指定电子邮件地址以外的收件人姓名：`[email => name]`
    - @return $this
* `public function setBcc($bcc)`
    - 设置此消息的密件抄送（隐藏拷贝接收方）地址。与抄送功能一致，区别是不会在邮件中显示抄送接收人
    - @param string | array $bcc hidden copy receiver email address.
    - 如果多个收件人应收到此邮件，您可以传递一组地址。
    - 您还可以使用以下格式指定电子邮件地址以外的收件人姓名：`[email => name]`
    - @return $this
* ` public function setSubject($subject)`
    - 设置邮件主题。
    - @param string $subject 邮件主题
    - @return $this
* `public function setTextBody($text)`
    - 设置消息纯文本内容
    - @param string $text message纯文本内容。
    - @return $this
* `public function setHtmlBody($html)`
    - 设置消息HTML内容
    - @param string $html 消息HTML内容
    - @return $this
* `public function attach($fileName, array $options = [])`
    - 将现有文件附加到电子邮件中。
    - @param string $fileName 完整文件名
    - @param array $options 选项用于嵌入文件。有效选项包括：
        - fileName：指定文件名称，如乱码请尝试在文中时在文件名前加上`?`
        - contentType：附件MIME类型。
    - @return $this
* `public function attachContent($content, array $options = [])`
    - 将指定的内容附加为电子邮件的文件。
    - @param string $content 附件文件内容。
    - @param array $options 选项用于嵌入文件。有效选项包括：
        - fileName：指定文件名称。
        - contentType：附件MIME类型。
* `public function embed($fileName, array $options = [])`
    - 附加文件并返回它的CID源。示例：`<img src="<?php echo $message->embed('/path/to/file.png') ?>">`
    - 在邮件中嵌入图像或其他数据时，应使用此方法。
    - @param string $fileName 文件名。
    - @param array $options 选项用于嵌入文件。有效选项包括：
        - fileName：指定文件名称。
        - contentType：附件MIME类型。
* `public function send(MailerInterface $mailer = null)`
    - 发送此电子邮件。实际会调用“mailer”应用程序组件的`send()`方法
    - @param MailerInterface $mailer 应该用于发送此消息的邮件程序。
    - 如果为null，则将使用“mailer”应用程序组件。
    - @return bool 此消息是否成功发送。
* `public function toString()`
    - 返回此消息的字符串表示形式。
    - @return string 此消息的字符串表示形式。

## 使用案例

* <https://github.com/yiisoft-contrib/yiiframework.com/blob/master/notifications/BaseNotification.php#L42:L63>
* <https://github.com/yiisoft-contrib/yiiframework.com/blob/master/jobs/EmailNotificationJob.php#L32:L42>

## 文档

* <https://www.yiiframework.com/doc/guide/2.0/zh-cn/tutorial-mailing>