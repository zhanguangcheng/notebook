Visual Studio Code
===============================

> [Visual Studio Code](https://code.visualstudio.com/). Code editing. Redefined. Free. Open source. Runs everywhere.

## 常用插件

* `Apache Conf`
* `AutoFileName`
* `Better Align`
* `bootcdn`
* `Bracket Pair Colorizer`
* `Code Runner`
* `Commands`
* `Comment Translate`
* `Diff Tool`
* `EditorConfig for VS Code`
* `ESLint`
* `Git History`
* `HTML CSS Support`
* `PHP Debug`
* `PHP DocBlocker`
* `PHP Intelephense`
* `PHP Namespace Resolver`
* `Project Manager`
* `RSPG - Random String or Password Generator`
* `Settings Sync`
* `Sublime Text Keymap`
* `SVN`
* `Terminals Manager`
* `TortoiseSVN`
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
    "editor.lineHeight": 24,
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
    "search.useIgnoreFiles": false,
    "window.newWindowDimensions": "maximized",
    "window.title": "${rootName}@${activeEditorMedium}",
    "workbench.editor.enablePreviewFromQuickOpen": false,
    "workbench.editor.openPositioning": "last",
    
    "diffEditor.renderSideBySide": false,
    "namespaceResolver.showMessageOnStatusBar": true,
    "namespaceResolver.autoSort": true,
    "namespaceResolver.sortAlphabetically": true,
    "commands.commands": [
        {
            "text": "$(gear)",
            "command": "workbench.action.openGlobalSettings",
            "tooltip": "Settings"
        },
        {
            "text": "$(file-directory)",
            "command": "workbench.action.files.openFolder",
            "tooltip": "Open Folder",
        },
        {
            "text": "$(file-submodule)",
            "command": "workbench.action.openWorkspace",
            "tooltip": "Switch Workspaces",
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
            "command": "workspace tortoise-svn update",
            "text": "$(arrow-down)",
            "tooltip": "svn update"
        },
        {
            "command": "workspace tortoise-svn commit",
            "text": "$(arrow-up)",
            "tooltip": "svn commit"
        },
        {
            "command": "file tortoise-svn commit",
            "text": "$(arrow-small-up)",
            "tooltip": "svn file commit"
        },
        {
            "command": "workspace tortoise-svn log",
            "text": "$(history)",
            "tooltip": "svn log"
        },
        {
            "command": "file tortoise-svn log",
            "text": "$(clock)",
            "tooltip": "svn file log"
        }
    ],
    "terminals.terminals": [
        {
            "name": "Compress JS",
            "open": true,
            "onlySingle": true,
            "command": "java -jar C:/portable-env/yuicompressor/2.4.8/main.jar --type js -o '.js$:.min.js' [file]"
        },
        {
            "name": "Compress CSS",
            "open": true,
            "onlySingle": true,
            "command": "java -jar C:/portable-env/yuicompressor/2.4.8/main.jar --type css -o '.css$:.min.css' [file]"
        }
    ],
    "launch": {
        "version": "0.2.0",
        "configurations": [
            {
                "name": "XDebug",
                "type": "php",
                "request": "launch",
                "port": 9000,
                "xdebugSettings": {
                    "max_children": 100,
                    "max_data": 10000,
                    "show_hidden": 1
                }
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
    },
    "php.validate.run": "onType",
    "explorer.confirmDelete": false,
    "window.zoomLevel": 0,
    "svn.autorefresh": false,
    "workbench.startupEditor": "newUntitledFile",
    "editor.renderControlCharacters": false,
    "workbench.colorTheme": "Quiet Light",
    "search.followSymlinks": false,
    "files.autoSaveDelay": 100,
    "editor.fontSize": 12,
    "debug.toolBarLocation": "docked",
    "workbench.iconTheme": "vscode-great-icons",
    "[html]": {
        "editor.defaultFormatter": "HookyQR.beautify"
    },
    "[javascript]": {
        "editor.defaultFormatter": "HookyQR.beautify"
    },
    "commentTranslate.targetLanguage": "zh-CN",
    "editor.minimap.enabled": false,
    "editor.fontFamily": "'Fira Code'",
    "editor.fontWeight": "500",
    "editor.fontLigatures": true,
    "terminal.integrated.fontWeightBold": "500",
    "diffEditor.ignoreTrimWhitespace": true,
    "window.menuBarVisibility": "hidden",
    "update.mode": "start",
    "terminal.integrated.rendererType": "dom",
    "terminal.integrated.shell.windows": "C:\\WINDOWS\\System32\\cmd.exe",
    "editor.minimap.renderCharacters": false,
    "timeline.excludeSources": []
}
```


## 惯例快捷键配置

```json
[
    { "key": "alt+h", "command": "cursorLeft", "when": "editorTextFocus" },
    { "key": "alt+l", "command": "cursorRight", "when": "editorTextFocus" },
    { "key": "alt+j", "command": "cursorDown", "when": "editorTextFocus" },
    { "key": "alt+k", "command": "cursorUp", "when": "editorTextFocus" },

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
    { "key": "ctrl+alt+j", "command": "editor.action.moveLinesDownAction", "when": "editorTextFocus" },
    { "key": "ctrl+alt+k", "command": "editor.action.moveLinesUpAction", "when": "editorTextFocus" },
    
    { "key": "alt+shift+h", "command": "cursorLeftSelect", "when": "editorTextFocus" },
    { "key": "alt+shift+l", "command": "cursorRightSelect", "when": "editorTextFocus" },
    { "key": "alt+shift+j", "command": "cursorDownSelect", "when": "editorTextFocus" },
    { "key": "alt+shift+k", "command": "cursorUpSelect", "when": "editorTextFocus" },

    { "key": "alt+ctrl+shift+h", "command": "cursorWordStartLeftSelect", "when": "editorTextFocus" },
    { "key": "alt+ctrl+shift+l", "command": "cursorWordStartRightSelect", "when": "editorTextFocus" },
    { "key": "alt+ctrl+shift+k", "command": "cursorPageUp", "when": "textInputFocus" },
    { "key": "alt+ctrl+shift+j", "command": "cursorPageDown", "when": "textInputFocus" },

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

