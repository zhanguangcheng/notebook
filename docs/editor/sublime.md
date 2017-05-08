Sublime Text 3
===============================

## 常用插件

* `Package Control` 插件之源

```python
import urllib.request,os; pf = 'Package Control.sublime-package'; ipp = sublime.installed_packages_path(); urllib.request.install_opener( urllib.request.build_opener( urllib.request.ProxyHandler()) ); open(os.path.join(ipp, pf), 'wb').write(urllib.request.urlopen( 'http://sublime.wbond.net/' + pf.replace(' ','%20')).read())
```

* `Emmet`  前端神器(`Tab`)
* `Alignment`  等号对齐(`Ctrl+Alt+A`)
* `Docblockr`  生成注释格式(`/**`)
* `ConvertToUTF8`  更多编码支持
* `IMESupport`  修复输入法不跟踪问题
* `GotoDocumentation`   快速定位帮助文档
* `PhpNinJaManual` PHP函数提示
* `AutoFileName`   自动提示本地文件名
* `BracketHighlighter`    括号高亮
* `All Completion` 全能代码提示
* `modific`    更好的显示git&svn差异
* `themr`   多种主题切换(`Ctrl+F5`)
* `colorsublime`   多种配色切换(`colorsublime`)
* `jquery`   jquery方法提示
* `AdvancedNewFile`   高级新建文件(`Ctrl+Alt+N`)
* `sublimeLinter`    语法检测基础包
* `sublimeLinter-php`    php语法检测
* `Markdown Preview`  Markdown预览
* `ini` ini文件语法高亮
* `CFG Configuration Syntax Highlighting` 配置文件语法高亮
* `BufferScroll`  保存折叠状态
* `ftpsync` FTP同步
* `HTML5` HTML5标签拓展
* `SideBarEnhancements`  右键菜单增强
* `ChineseLocalization`  完全汉化插件
* `ctags` 智能跳转(需要ctags环境, 使用: 在项目目录上单击右键->`Ctags:Rebuild Gags`)

## 常用快捷键

* `Ctrl+P` 文件跳转
* `Ctrl+W` 关闭当前tab
* `Ctrl+R` 函数列表
* `Ctrl+G` 行跳转
* `Ctrl+Z` 撤销i
* `Ctrl+Shift+Z` 恢复撤销
* `Ctrl+L` 选择整行（按住-继续选择下行）
* `Ctrl+Shift+D` 复制光标所在整行，插入在该行之后
* `Ctrl+Shift+P` 命令面板
* `Ctrl+Shift+N` 新建窗口
* `Ctrl+Shift+M` 选择括号内的内容（{[()]}按住-继续选择父括号）
* `Ctrl+Shift+Backspace` 从光标处删除至行首(`Ctrl+K Backspace`)
* `Ctrl+J` 合并行（已选择需要合并的多行时）
* `Ctrl+KK` 从光标处删除至行尾
* `Ctrl+D` 选词 （按住-继续选择下个相同的字符串）
* `Alt+F3` 选词(全部)
* `Alt+-` 上一个修改的位置
* `Alt+Shift+-` 下一个修改的位置
* `Ctrl+M` 光标移动至括号内开始或结束的位置
* `Ctrl+'` 选中引号中的内容
* `Ctrl+F2` 设置/取消书签
* `F2` 下一个书签
* `Shift+F2` 上一个书签
* `Ctrl+Enter` 光标后插入行
* `Ctrl+Shift+Enter` 光标前插入行
* `Ctrl+Shift+↑` 与上行互换
* `Ctrl+Shift+↓` 与下行互换
* `Ctrl+KU` 改为大写
* `Ctrl+KL` 改为小写
* `Shift+鼠标右键拖动` 列编辑(或者按住鼠标中键拖动)
* `Ctrl+Shift+[` 折叠代码
* `Ctrl+Shift+]` 展开代码
* `Ctrl+KJ` 展开全部代码
* `Ctrl+K1` 折叠1级代码, 1是可变的
* `Ctrl+Shift+V` 原格式粘贴
* `Ctrl+KV` 从记录中粘贴

## 惯例配置

```json
{
    "always_show_minimap_viewport": true,
    "auto_complete": true,
    "auto_complete_commit_on_tab": true,
    "auto_complete_delay": 100,
    "auto_find_in_selection": true,
    "auto_indent": true,
    "auto_match_enabled": true,
    "bold_folder_labels": true,
    "color_scheme": "Packages/User/SublimeLinter/Monokai (SL).tmTheme",
    "default_encoding": "UTF-8",
    "default_line_ending": "unix",
    "draw_minimap_border": true,
    "draw_white_space": "all",
    "trim_automatic_white_space": false,
    "ensure_newline_at_eof_on_save": true,
    "font_size": 12,
    "highlight_line": true,
    "hot_exit": true,
    "ignored_packages":
    [
        "Vintage"
    ],
    "font_options":
    [
        "directwrite"
    ],
    "rulers":
    [
        120
    ],
    "line_padding_bottom": 3,
    "line_padding_top": 3,
    "margin": 0,
    "save_on_focus_lost": true,
    "show_encoding": true,
    "show_line_endings": true,
    "tab_size": 4,
    "translate_tabs_to_spaces": true,
    "update_check": false,
    "use_simple_full_screen": true,
    "word_wrap": true
}
```

## 惯例快捷键配置

```json
[
     { "keys": ["alt+h"], "command": "move", "args": {"by": "characters", "forward": false} },
     { "keys": ["alt+j"], "command": "move", "args": {"by": "lines", "forward": true} },
     { "keys": ["alt+k"], "command": "move", "args": {"by": "lines", "forward": false} },
     { "keys": ["alt+l"], "command": "move", "args": {"by": "characters", "forward": true} },
     { "keys": ["ctrl+alt+h"], "command": "move", "args": {"by": "words", "forward": false} },
     { "keys": ["ctrl+alt+j"], "command": "scroll_lines", "args": {"amount": -1.0 } },
     { "keys": ["ctrl+alt+k"], "command": "scroll_lines", "args": {"amount": 1.0 } },
     { "keys": ["ctrl+alt+l"], "command": "move", "args": {"by": "word_ends", "forward": true}},
     { "keys": ["alt+shift+h"], "command": "move", "args": {"by": "characters", "forward": false, "extend": true} },
     { "keys": ["alt+shift+j"], "command": "move", "args": {"by": "lines", "forward": true, "extend": true} },
     { "keys": ["alt+shift+k"], "command": "move", "args": {"by": "lines", "forward": false, "extend": true} },
     { "keys": ["alt+shift+l"], "command": "move", "args": {"by": "characters", "forward": true, "extend": true} },
     { "keys": ["ctrl+shift+alt+h"], "command": "move", "args": {"by": "words", "forward": false, "extend": true} },
     { "keys": ["ctrl+shift+alt+j"], "command": "move", "args": {"by": "pages", "forward": true} },
     { "keys": ["ctrl+shift+alt+k"], "command": "move", "args": {"by": "pages", "forward": false} },
     { "keys": ["ctrl+shift+alt+l"], "command": "move", "args": {"by": "word_ends", "forward": true, "extend": true} },

     { "keys": ["alt+."], "command": "indent" },
     { "keys": ["alt+,"], "command": "unindent" },
     { "keys": ["alt+;"], "command": "move_to", "args": {"to": "eol", "extend": false} },
     { "keys": ["alt+m"], "command": "move_to", "args": {"to": "bol", "extend": false} },
     { "keys": ["ctrl+q"], "command": "toggle_comment", "args": { "block": false } },

     { "keys": ["f1"], "command": "show_php_document" },
     { "keys": ["shift+f1"], "command": "goto_documentation" }
]
```

## 其他

### 推荐主题

* Default
* One Dark Material


### 推荐的配色

* dracula
* Monokai
* Monokai Extended

### Build System

> 快捷键:Ctrl+B执行编译,Esc键隐藏控制台

* http://sublimetext.info/docs/en/reference/build_systems.html

#### 执行php

> 依赖PHP环境 

```json
{
    "cmd": ["php", "$file"],
    "selector": "source.php"
}
```

#### 使用Yui compressor压缩js

> 依赖Java环境 

```json
{
    "cmd": ["java", "-jar", "C:\\greenEnvironment\\yuicompressor\\2.4.8\\main.jar", "--type", "js", "$file", "-o", "$file_base_name.min.js"],
    "selector": "source.js"
}
```

### Snippet

* http://www.jianshu.com/p/356bd7b2ea8e
* http://docs.sublimetext.info/en/latest/extensibility/snippets.html

### 在线制作配色

* http://tmtheme-editor.herokuapp.com/#!/editor/theme/Monokai


### 开启操作log

`sublime.log_commands(True)`


### 注册码

> 3083

```
Andrew Weber
Single User License
EA7E-855605
813A03DD 5E4AD9E6 6C0EEB94 BC99798F
942194A6 02396E98 E62C9979 4BB979FE
91424C9D A45400BF F6747D88 2FB88078
90F5CC94 1CDC92DC 8457107A F151657B
1D22E383 A997F016 42397640 33F41CFC
E1D0AE85 A0BBD039 0E9C8D55 E1B89D5D
5CDB7036 E56DE1C0 EFCC0840 650CD3A6
B98FC99C 8FAC73EE D2B95564 DF450523
```

> 3114

```
Michael Barnes
Single User License
EA7E-821385
8A353C41 872A0D5C DF9B2950 AFF6F667
C458EA6D 8EA3C286 98D1D650 131A97AB
AA919AEC EF20E143 B361B1E7 4C8B7F04
B085E65E 2F5F5360 8489D422 FB8FC1AA
93F6323C FD7F7544 3F39C318 D95E6480
FCCC7561 8A4A1741 68FA4223 ADCEDE07
200C25BE DBBC4855 C4CFB774 C5EC138C
0FEC1CEF D9DCECEC D3A5DAD1 01316C36
```
