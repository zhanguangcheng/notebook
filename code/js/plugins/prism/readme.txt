语法高亮插件

官网
http://prismjs.com/

案例
https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/parseInt


使用方法:
下载地址: http://prismjs.com/download.html

共分为4个部分
1. Core 核心
2. Themes 主题
3. Languages 语言
4. Plugins 插件

Core为必须, 其他根据自己的需求打包下载

选择好之后 点击最下面的 DOWNLOAD JS 和 DOWNLOAD CSS
比如我选择了
core核心
default主题
javascript 语言
line-numbers,Copy to Clipboard Button 插件

引入
<link rel="stylesheet" href="prism.css">
<script src="prism.js"></ >

html:
<pre class="language-javascript line-numbers">
    <code>
        // CODE
    </code>
</pre>

