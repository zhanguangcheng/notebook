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

```
/* 元素类 */
* {} 通用选择器
body {} 标签选择器
#header {} id选择器
.container {} 类选择器

/* 属性选择器 ie7+ */ 
[attribute] 用于选取带有指定属性的元素 
[attribute=value]   用于选取带有指定属性和值的元素 
[attribute^=value]  匹配属性值以指定值开头的每个元素 
[attribute$=value]  匹配属性值以指定值结尾的每个元素 
[attribute*=value]  匹配属性值中包含指定值的每个元素 
[attribute~=value]  用于选取属性值中包含指定单词的元素 
[attribute|=value]  用于选取带有以指定值开头的属性值的元素，该值必须是整个单词 

/* 关系选择器 */
parent child {} 包含
/* ie7+ */
parent > child {} 子元素
E1 + E2 {} 相邻(紧跟后边的指定的元素)
E1 ~ E2 {} 兄弟(紧跟后边的指定的所有元素)

/* 伪类选择器 */
a:link {}
a:visited {}
a:hover {}
a:active {}
E:first-child {}
E:last-child {} ie9+
E:nth-child(n) {} ie9+ (odd even奇偶数)

/* 伪元素/对象选择器 ::为css3写法 */
E:before/E::before {} ie8+
E:after/E::after {} ie8+
E::selection {} ie9+ 设置对象被选择时的样式。支持background-color，color

CSS3将伪对象选择符前面的单个冒号(:)修改为双冒号(::)用以区别伪类选择符，但以前的写法仍然有效。 即E:after可转化为E::after
CSS2本质上并不支持伪元素的双冒号(::)写法，而是忽略掉了其中的一个冒号，仍以单冒号来解析，所以等同变相支持了E::after。

/* 组合选择器 */
html,body {}
p.red {}
input[type=text] {}
```

### 选择器优先级(权重)

important > 内联 > ID > 类 | 属性 > 标签 | 伪元素 > 继承 > 通配符

* 一条样式规则的整体权重值包含四个独立的部分：[A, B, C, D];

    - A表示内联样式，只有1或者0两个值；
    - B表示规则中ID的数量；
    - C表示规则中类、属性的数量；
    - D表示规则中标签和伪元素的数量；

* 比较时从高位到低位（从A到D）分别比较，高位相同才需要比较低位；
* 有 !important 标记的属性无视权重值，多次指定 !important 时，相互抵销。


## 常用属性

### CSS基本样式

```css
div {
    width: 100px;
    height: 100px;
    min/max-width/height: 100px;/*ie7+*/
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
    box-sizing: content-box | border-box;/* ie8+ */
    padding: 20px;
    padding-top | right | bottom | left: 20px;
    border: none | 1px solid #ff0;
    border-top | right | bottom | left: 1px dotted #ff0;
    margin: 20px;
    margin-top | right | bottom | left: 20px;
}
```


## 弹性布局（Flexible Box，简称Flex）

采用Flex布局的元素称为Flex容器（flex-container），他的子元素称为Flex项目（flex-item）。  
容器有两根轴，水平方向的为主轴，垂直方向的为交叉轴，项目在同一条线上称为轴线。

### 启用Flex布局
```css
.box {
    display: flex;
}
```

### Flex属性

#### flex-container:
* `flex-direction` 定义主轴的方向
    - `row` 水平方向（默认值）
    - `row-reverse` 水平方向反向
    - `column` 垂直方向
    - `column-reverse` 垂直方向反向
* `flex-wrap` 定义同一轴线放不下后如何换行
    - `no-wrap` 不换行（默认值）
    - `warp` 换行
    - `wrap-reverse` 换行，行反向排列
* `flex-flow` 是`flex-direction`和`flex-wrap`的简写形式
    - `<flex-direction> <flex-wrap>`
* `justify-content` 定义项目在主轴上的对其方式
    - `flex-start` 左对齐（默认值）
    - `center` 居中
    - `flex-end` 右对齐
    - `space-between` 两端对齐，每个项目之间距离相等
    - `space-around` 每个项目两侧的间距相等
* `align-items` 定义项目在交叉轴上的对齐方式
    - `strtch` 占满整个容器的高度，如为设置固定高度（默认值）
    - `flex-start` 左对齐
    - `center` 居中
    - `flex-end` 右对齐
    - `baseline` 项目的第一行文本的基线对齐
* `align-content` 定义多根轴线的对齐方式
    - `strtch` 轴线占满整个交叉轴（默认值）
    - `flex-start` 左对齐（默认值）
    - `center` 居中
    - `flex-end` 右对齐
    - `space-between` 两端对齐，每根轴线之间距离相等
    - `space-around` 每根轴线两侧的间距相等
#### flex-item
* `order` 定义项目的排序，从小到大，默认为`0`
* `flex-grow` 定义项目放大比例，默认为`0`，有剩余空间也不放大
* `flex-shrink` 定义项目的缩小比例，默认为`1`，空间不足也不会缩小
* `flex-basis` 定义了在分配多余空间之前，项目占主轴的空间，默认`auto`，即原本大小
* `flex` 是`flex-grow`、`flex-shrink`和`flex-basis`的简写形式
    - `<flex-grow> <flex-shrink> <flex-basis>`
* `align-self` 定义项目本身在轴线上的对齐方式，默认为`auto`，继承容器的`align-items`属性


## 语法与规则

**!important**

提升指定样式规则的应用优先权。

```css
Selector { sRule!important; }
```

**@import**

导入外部样式表

```css
@import <url> <media_query_list>

@import url("global.css");
@import url(global.css);
@import "global.css";

/* ie9+ */
@import url(example.css) screen and (min-width:800px);
```

**@charset**

用于外部样式表，指定该样式表使用的字符编码。

```css
@charset "utf-8";
```

**@media**

指定样式表规则用于指定的媒体类型和查询条件。

```css
/* ie9+ */
@media <media_query, media_query...>
media_query: [only | not] 媒体类型 [and (媒体功能:值)] ...

@media (min-width:500px) {}
@media screen and (min-width:500px) {}
@media only screen and (min-width:500px) {}
@media only screen and (min-width:500px) and (max-width:600px) {}
```

**@font-face**

设置嵌入HTML文档的字体。


**@keyframes**

指定动画名称和动画效果。


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

```css
@media [设备类型] 
```

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


## Reference

* <http://www.css88.com/book/css/>
* <http://m.mamicode.com/info-detail-1248108.html>
* <http://www.ruanyifeng.com/blog/2015/07/flex-grammar.html>
