Vim惯例配置和常用技巧
====================

## 技巧

```vim
:x =:wq
:tabnew
:tabnew .
h j k l 移动光标
w b W B 向前/后跳(wb:单词 WB:空格)
e 单词末尾
r R 单字替换 多字替换
J 合并两行
a A i I o O 切换插入模式
x X 删除单个字符
~ 大小写转换
$ ^ 0 行首 行末
. 重复上一次命令
<C-W-W>切换窗口　<C-W>+HJKL也可以
D 删除光标到行尾(同d$)
Y 复制当前行（同yy）
P p 前/后粘贴
nG 移动到n行
fc Fc 定位到当前行 前/后c 的位置
u <C-R> 撤销/重做
g; g, 跳到上/下一次编辑的地方
= 格式化　gg=G 格式化全部内容
q: 历史命令
zz 将屏幕卷置中间
* # 向前/后查找光标处token
% 括号对跳(){}[]<>
{ } 上一段/下一段(按照空行来区分)
v <SHIFT+V> 可视模式
< > 缩进 单行缩进需要<< >>
<C-V> 列编辑模式 选中区块 d x 删除  I A 前面/后面插入
<C-F> <C-B> <C-D> <C-U> 翻页
/search  搜索字符串search n N (下一个/上一个)
:%s/x/y/g 替换字符串x为y
gf 打开光标处的文件
:#,#s/old/new/g替换 #代表行号
:%s/old/new/gc替换,全局替换,并询问用户是否替换
:!<命令> 执行外部命令
:nohl 搜索之后取消高亮
:set paste 粘贴模式
```

## 配置

```vim
"不使用兼容模式(vi)
set nocompatible

"语法高亮
syntax on

"显示行号
set number

"高亮当前行
set cursorline

"光标移动到buffer的顶部和底部时保持5行距离
set scrolloff=5

"编码设置
set encoding=utf-8
set termencoding=utf-8
set fileencoding=utf-8
set fileencodings=utf-8,ucs-bom,gb18030,gbk,gb2312,cp936

"避免菜单乱码
if has('win32')
    source $VIMRUNTIME/delmenu.vim
    source $VIMRUNTIME/menu.vim
    source $VIMRUNTIME/mswin.vim
    language messages zh_CN.utf-8  
endif

"语言设置
set langmenu=zh_CN.UTF-8
set helplang=cn

"高亮搜索的文本
set hlsearch

"马上跳到搜索结果的地方
set incsearch

"搜索忽略大小写
set ignorecase

"禁止生成临时文件
set nobackup

"总是显示状态栏
set laststatus=2

filetype plugin indent on

"不显示菜单栏和工具栏
set guioptions-=T
"set guioptions-=m

"在处理未保存或只读文件的时候，弹出确认
set confirm

"自动缩进
set autoindent
set smartindent

"tab的宽度
set tabstop=4

"缩进为4个空格
set softtabstop=4
set shiftwidth=4

"将tab换成空格
set expandtab

"显示命令
set showcmd

"搜索忽略大小写
set ignorecase

"使回格键（backspace）正常处理indent,eol,start
set backspace=indent,eol,start

"允许使用鼠标
set mouse=a

"禁用折叠
set nofoldenable

"配色
"colorscheme slate
"set fillchars=vert:\ ,stl:\ ,stlnc:\

"设置字体
set guifont=Consolas:h12

"设置不换行
set nowrap

"空格显示出来
set list
set listchars=tab:>-,trail:-

let mapleader = ","

map <Leader>q :q<CR>
map <Leader>w :w<CR>
map <Leader>x :x<CR>
```


## 图解VIM

![VIM图解1](../../images/vim-cmd.png)
![VIM图解2](../../images/vim-cmd2.png)


## 更多配置和插件

<https://github.com/zhanguangcheng/vim-config>
