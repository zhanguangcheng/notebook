CSS笔记
==================

## 概述


CSS 指层叠样式表 (Cascading Style Sheets)，用于现代网页布局的计算机语言。

### 如何创建 CSS

* 外部样式表（通过`<link>`标签导入）
* 内部样式表（位于`<head>`标签内部）
* 内联样式（在HTML元素内部）

### 层叠优先级

内联样式 > (内部样式/外部样式) > 浏览器缺省值


## 基础语法

```
选择器 {申明1;申明2;...}
```

申明由属性和值组成，中间用冒号（:）隔开。

**例如**

```css
h1 {color:red; font-size:14px;}
```

**说明**

![](../images/ct_css_selector.gif)

## 选择器类型

```css
/* 元素类 */
* {} 通用选择器
body {} 标签选择器
#header {} id选择器
.container {} 类选择器

/* 属性选择器 ie7+ */ 
[attribute] 用于选取带有指定属性的元素
[attribute=value]   用于选取带有指定属性和值的元素 [attribute~=value]  用于选取属性值中包含指定词汇的元素
[attribute|=value]  用于选取带有以指定值开头的属性值的元素，该值必须是整个单词
[attribute^=value]  匹配属性值以指定值开头的每个元素
[attribute$=value]  匹配属性值以指定值结尾的每个元素
[attribute*=value]  匹配属性值中包含指定值的每个元素

/* 关系选择器 ie7+ */
parent child {} 包含
parent > child {} 子元素
E1 + E2 {} 相邻
E1 ~ E2 {} 兄弟

/* 伪类选择器 */
a:link {}
a:visited {}
a:hover {}
a:active {}
E:first-child {}
E:last-child {} ie9+
E:nth-child(n) {} ie9+

/* 伪元素/对象选择器 ::为css3写法 */
E:before/E::before {} ie8+
E:after/E::after {} ie8+
E::selection {} ie9+ 设置对象被选择时的样式。支持background-color，color
CSS3将伪对象选择符前面的单个冒号(:)修改为双冒号(::)用以区别伪类选择符，但以前的写法仍然有效。 即E:after可转化为E::after
本质上并不支持伪元素的双冒号(::)写法，而是忽略掉了其中的一个冒号，仍以单冒号来解析，所以等同变相支持了E::after。

/* 分组选择器 */
html, body {}
```

### 选择器优先级(权重)

## 常用属性

### CSS基本样式

```css
div {
    width: 100px;
    height: 100px;
    min-width: 100px;
    max-height: 100px;
    line-height: 20px;
    opacity: 0.5; filter:alpha(opacity=50);
    text-align: left | center | right | justify/*需要在单词之间添加空白*/;
    text-indent: 20px;
    text-decoration: none | 1px solid #ff0;
    vertical-align: baseline | top | middle | bottom;
    background: #fff url(../images/logo.png) center 20px;
    background-color: #ff0;
    background-image: url(...);
    outline: none | 1px solid #ff0;
    border-radius: 50%;/*ie9+*/
    box-shadow: none | 1px 1px 5px 2px #ff0;/*ie9+ 水平、垂直偏移值、模糊值、外延值、颜色*/
    text-shadow: none | 1px 1px 2px #ff0;/*ie10+ 水平、垂直偏移值、模糊值、颜色*/

    float: none | left | right;
    clear: none | left | right | both;
    visibility: visible | hidden;
    overflow: visible | hidden | scroll | auto;
    overflow-x | y : auto;
    display: none | inline | block | inline-block;
    zoom: 1;

    position: static | relative | absolute | fixed;
    top: 20px
    right: 20px;
    bottom: 20px;
    left: 20px;
    z-index: 1;
    
}

a {
    color: #f00;
    word-spacing: 2px;
    letter-spacing: 2px;
    white-space: normal | nowrap | pre-wrap;
    word-wrap: normal | break-word;
    font-size: 12px;
    font-family: arial, georgia, verdana, simsun, helvetica, sans-serif;
    font-weight: normal(400) | bold(700) | 100-900;
    font-style: normal | italic;
    cursor: auto | default | pointer | move | not-allowed | wait | progress | help;
    user-select: none | text;/*ie10+*/
}

ul {
    list-style: none;
}

table {
    border-collapse: separate/*默认值*/ | collapse;
    border-spacing: 10px 50px;
}

textarea {
    resize: none | both | horizontal | vertical;
}
```

### CSS盒子模型

> CSS 盒模型 (Box Model) 规定了元素框处理元素内容、内边距、边框 和 外边距 的方式。

```css
div {
    padding: 20px;
    padding-top | right | bottom | left: 20px;
    border: none | 1px solid #ff0;
    border-top | right | bottom | left: 1px dotted #ff0;
    margin: 20px;
    margin-top | right | bottom | left: 20px;
}
```

## 常见布局

**结构**

如无特殊说明，例子都按照下面的结构

```html
<div class="box">
    文本
</div>

<div class="parent">
    <div class="child">child</div>
</div>

<div class="parent">
    <div class="left">left</div>
    <div class="right">right</div>
</div>

<div class="parent">
    <div class="left">left</div>
    <div class="center">center</div>
    <div class="right">right</div>
</div>

```

#### 水平居中

* width margin实现

```css
/* 需要设置宽度，兼容性好 */
.child {width: 200px; margin: 0 auto;}
```

* inline-block text-align实现

```css
/* 需要设置两个元素，兼容性好 */
.parent {text-align: center;}
.child {display: inline-block;}
```

* flex实现

```css
.parent {display: flex; justify-content: center;}
```

#### 垂直居中

```css
/* 单行文本 */
.box {height: 20px; line-height: 20px;}
```

#### 左列定宽，右列自适应

```css
.left {float: left; width: 100px;}
.right {margin-left: 100px;}
```

#### 右列定宽，左列自适应

```css
/* left 和 right元素需交换位置 */
.left {margin-right: 100px;}
.right {float: right;width: 100px;}
```

#### 两列定宽，一列自适应

```css
.left,.center {float:left;width:100px;}
.right {margin-left:200px;}
```

#### 两侧定宽，中间自适应
#### 一列不定宽，一列自适应

```css
.left {float: left; max-width: 100px;}
.right {overflow: hidden;}
```

#### 多列等分
#### 九宫格布局
#### 媒体查询


## 技巧和经验

* 清除浮动class

```css
.clearfix{*zoom:1;}
.clearfix:before,.clearfix:after{display:table;content:"";line-height:0;}
.clearfix:after{clear:both;}
```

#### 清除图片下方出现几像素的空白间隙

```css
image {display:block;}
```

#### 让文本输入框旁边的文字垂直对齐

```css
input{vertical-align:middle;}
```

#### 单行文本在容器内垂直居中

```css
/* 只需设置文本的行高等于容器的高度即可 */
.box {height: 30px;line-height: 30px}
```

#### 使文本溢出边界不换行强制在一行内显示

```css
.box {width: 150px;white-space: nowrap;}
```

#### 使文本溢出边界显示为省略号

```css
/* 首先需设置将文本强制在一行内显示，然后将溢出的文本通过overflow:hidden截断，并以text-overflow:ellipsis方式将截断的文本显示为省略号。 */
.box {
    width: 150px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
```

#### 使连续的长字符串自动换行

```css
.box {width:150px;word-wrap:break-word;}
```

#### 让某个元素充满整个页面

```css
html,body {height: 100%;margin:0}
.box {height: 100%}
```
