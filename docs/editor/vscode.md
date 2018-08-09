Visual Studio Code
===============================

> [Visual Studio Code](https://code.visualstudio.com/). Code editing. Redefined. Free. Open source. Runs everywhere.

## 常用插件

* `Align`
* `Apache Conf`
* `AutoFileName`
* `Bracket Pair Colorizer`
* `Code Runner`
* `Commands`
* `Diff Tool`
* `EditorConfig for VS Code`
* `ESLint`
* `Git History`
* `GitHub Plus Theme`
* `HTML CSS Support`
* `Monokai Pro`
* `PHP Debug`
* `PHP DocBlocker`
* `PHP Intelephense`
* `PHP Namespace Resolver`
* `Project Manager`
* `RSPG - Random String or Password Generator`
* `Settings Sync`
* `Sublime Text Keymap`
* `SVN`
* `Terminals`
* `Todo Tree`
* `TortoiseSVN`
* `Translator`
* `VScode Great Ions`
* `vscode-goto-documentation`
* `vscode-random`


## 惯例配置

```json
{
    "debug.inlineValues": true,
    "debug.internalConsoleOptions": "neverOpen",
    "debug.showInStatusBar": "always",
    "editor.acceptSuggestionOnEnter": "off",
    "editor.find.autoFindInSelection": true,
    "editor.fontSize": 16,
    "editor.formatOnPaste": true,
    "editor.lineHeight": 24,
    "editor.minimap.renderCharacters": false,
    "editor.minimap.showSlider": "always",
    "editor.mouseWheelScrollSensitivity": 5,
    "editor.mouseWheelZoom": true,
    "editor.multiCursorModifier": "ctrlCmd",
    "editor.quickSuggestionsDelay": 100,
    "editor.renderWhitespace": "all",
    "editor.rulers": [
        120
    ],
    "editor.smoothScrolling": true,
    "editor.snippetSuggestions": "top",
    "emmet.triggerExpansionOnTab": true,
    "explorer.autoReveal": false,
    "extensions.ignoreRecommendations": true,
    "files.autoSave": "onFocusChange",
    "files.eol": "\n",
    "git.confirmSync": false,
    "git.path": "C:/greenEnvironment/git/2.12.1/bin/git.exe",
    "search.useIgnoreFiles": false,
    "window.newWindowDimensions": "maximized",
    "window.title": "${rootName}@${activeEditorMedium}",
    "workbench.editor.enablePreviewFromQuickOpen": false,
    "workbench.editor.openPositioning": "last",
    "workbench.iconTheme": "vscode-great-icons",
    
    "php.validate.run": "onType",
    "php.validate.executablePath": "C:/greenEnvironment/php/7.2.0/php.exe",
    "diffEditor.renderSideBySide": false,
    "namespaceResolver.showMessageOnStatusBar": true,
    "namespaceResolver.autoSort": false,
    "namespaceResolver.sortAlphabetically": true,
    "terminal.integrated.fontSize": 18,
    "todo-tree.regex": "((//|#|<!--|;|/\\*|\\*)\\s*($TAGS)|^\\s*- \\[ \\])",
    "todo-tree.expanded": true,
    "todo-tree.flat": true,
    "commands.commands": [
        {
            "text": "$(file-symlink-directory)",
            "command": "projectManager.listProjectsNewWindow",
            "tooltip": "Switch Project in new window",
        },
        {
            "text": "$(gear)",
            "command": "workbench.action.openGlobalSettings",
            "tooltip": "Settings"
        },
        {
            "text": "$(server) Compress JS",
            "command": "terminals.runTerminalByName",
            "arguments": [
                "Compress JS"
            ],
            "tooltip": "压缩JS代码为.min.js",
            "filterLanguageRegex": "JavaScript"
        },
        {
            "text": "$(server) Compress CSS",
            "command": "terminals.runTerminalByName",
            "arguments": [
                "Compress CSS"
            ],
            "tooltip": "压缩CSS代码为.min.css",
            "filterLanguageRegex": "CSS"
        },
        {
            "command": "translator.translate",
            "text": "$(book)",
            "tooltip": "Translate"
        },
        {
            "command": "editor.action.sortLinesAscending",
            "text": "$(arrow-up)",
            "tooltip": "Sort lines"
        }
    ],
    "terminals.terminals": [
        {
            "name": "Compress JS",
            "open": true,
            "onlySingle": true,
            "command": "java -jar C:/greenEnvironment/yuicompressor/2.4.8/main.jar --type js -o '.js$:.min.js' [file]"
        },
        {
            "name": "Compress CSS",
            "open": true,
            "onlySingle": true,
            "command": "java -jar C:/greenEnvironment/yuicompressor/2.4.8/main.jar --type css -o '.css$:.min.css' [file]"
        }
    ],
    "launch": {
        "version": "0.2.0",
        "configurations": [
            {
                "name": "XDebug",
                "type": "php",
                "request": "launch",
                "port": 9000
            },
            {
                "name": "Launch currently open script",
                "type": "php",
                "request": "launch",
                "program": "${file}",
                "cwd": "${fileDirname}",
                "port": 9000
            }
        ]
    }
}
```


## 惯例快捷键配置

```json
[
    { "key": "alt+h", "command": "cursorLeft", "when": "editorTextFocus" },
    { "key": "alt+l", "command": "cursorRight", "when": "editorTextFocus" },
    { "key": "alt+j", "command": "cursorDown", "when": "editorTextFocus" },
    { "key": "alt+k", "command": "cursorUp", "when": "editorTextFocus" },

    { "key": "alt+j", "command": "repl.action.historyNext", "when": "editorTextFocus && inDebugRepl && onLastDebugReplLine" },
    { "key": "alt+k", "command": "repl.action.historyPrevious", "when": "editorTextFocus && inDebugRepl && onFirsteDebugReplLine" },
    { "key": "alt+j", "command": "showNextParameterHint", "when": "editorTextFocus && parameterHintsMultipleSignatures && parameterHintsVisible" },
    { "key": "alt+k", "command": "showPrevParameterHint", "when": "editorTextFocus && parameterHintsMultipleSignatures && parameterHintsVisible" },
    { "key": "alt+j", "command": "selectNextSuggestion", "when": "editorTextFocus && suggestWidgetMultipleSuggestions && suggestWidgetVisible" },
    { "key": "alt+k", "command": "selectPrevSuggestion", "when": "editorTextFocus && suggestWidgetMultipleSuggestions && suggestWidgetVisible" },
    { "key": "alt+j", "command": "list.focusDown", "when": "listFocus" },
    { "key": "alt+k", "command": "list.focusUp", "when": "listFocus" },
    { "key": "alt+j", "command": "search.focus.nextInputBox", "when": "inputBoxFocus && searchViewletVisible" },
    { "key": "alt+k", "command": "search.focus.previousInputBox", "when": "inputBoxFocus && searchViewletVisible && !searchInputBoxFocus" },
    { "key": "alt+j", "command": "workbench.action.interactivePlayground.arrowDown", "when": "interactivePlaygroundFocus && !editorTextFocus" },
    { "key": "alt+k", "command": "workbench.action.interactivePlayground.arrowUp", "when": "interactivePlaygroundFocus && !editorTextFocus" },

    { "key": "ctrl+alt+h","command": "cursorWordStartLeft", "when": "editorTextFocus" },
    { "key": "ctrl+alt+l","command": "cursorWordStartRight", "when": "editorTextFocus" },

    { "key": "alt+shift+h", "command": "cursorLeftSelect", "when": "editorTextFocus" },
    { "key": "alt+shift+l", "command": "cursorRightSelect", "when": "editorTextFocus" },
    { "key": "alt+shift+j", "command": "cursorDownSelect", "when": "editorTextFocus" },
    { "key": "alt+shift+k", "command": "cursorUpSelect", "when": "editorTextFocus" },

    { "key": "alt+ctrl+shift+h", "command": "cursorWordStartLeftSelect", "when": "editorTextFocus" },
    { "key": "alt+ctrl+shift+l", "command": "cursorWordStartRightSelect", "when": "editorTextFocus" },

    { "key": "alt+.","command": "editor.action.indentLines", "when": "editorTextFocus && !editorReadonly" },
    { "key": "alt+,","command": "editor.action.outdentLines", "when": "editorTextFocus && !editorReadonly" },
    { "key": "ctrl+q", "command": "editor.action.commentLine", "when": "editorTextFocus && !editorReadonly" },
    { "key": "alt+m", "command": "cursorHome", "when": "editorTextFocus" },
    { "key": "alt+;", "command": "cursorEnd", "when": "editorTextFocus" }

]
```

## 快捷键

* <kbd>Ctrl</kbd>+<kbd>K</kbd>,<kbd>Ctrl</kbd>+<kbd>P</kbd> 活动文件跳转
* <kbd>Ctrl</kbd>+<kbd>Shift</kbd>+<kbd>鼠标左键</kbd> 列编辑

