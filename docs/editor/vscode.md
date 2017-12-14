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

commands.json
```json
{
  "commands": [
    {
      "text": "$(file-symlink-directory) Project",
      "command": "projectManager.listProjectsNewWindow",
      "tooltip": "Switch Project in new window",
      "color": "#FFFF00"
    },
    {
      "text": "$(gear) Settings",
      "command": "workbench.action.openGlobalSettings",
      "tooltip": "Settings"
    },
    {
      "text": "$(terminal)",
      "command": "terminals.runTerminal",
      "tooltip": "Run a terminal"
    },
    {
      "text": "$(server) Compress JS",
      "command": "terminals.runTerminalByName",
      "arguments": ["Compress JS"],
      "tooltip": "压缩JS代码为.min.js",
      "filterLanguageRegex": "JavaScript"
    },
    {
      "text": "$(server) Compress CSS",
      "command": "terminals.runTerminalByName",
      "arguments": ["Compress CSS"],
      "tooltip": "压缩CSS代码为.min.css",
      "filterLanguageRegex": "CSS"
    },
    {
      "command": "commands.refresh",
      "text": "$(sync)",
      "tooltip": "Refresh commands",
      "color": "#FFCC00"
    }
  ]
}
```

* `Diff Tool`
* `EditorConfig for VS Code`
* `ESLint`
* `Git History`
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

terminals.json
```json
{
  "autorun": false,
  "terminals": [
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
  ]
}
```

* `TortoiseSVN`
* `VScode Great Ions`
* `vscode-goto-documentation`


## 惯例配置

```json
{
    "editor.fontSize": 16,
    "editor.rulers": [
        120
    ],
    "editor.lineHeight": 24,
    "editor.mouseWheelZoom": true,
    "editor.mouseWheelScrollSensitivity": 5,
    "editor.smoothScrolling": true,
    "editor.multiCursorModifier": "ctrlCmd",
    "editor.snippetSuggestions": "top",
    "editor.formatOnPaste": true,
    "editor.renderWhitespace": "all",
    "editor.renderIndentGuides": false,
    "editor.wordWrap": "on",
    "editor.minimap.showSlider": "always",
    "editor.minimap.renderCharacters": false,
    "files.autoSave": "onWindowChange",
    "files.eol": "\n",

    "php.validate.run": "onType",
    "php.validate.executablePath": "C:/greenEnvironment/php/7.2.0/php.exe",
        
    "git.confirmSync": false,
    "git.path": "C:/greenEnvironment/git/2.12.1/bin/git.exe",
    "workbench.colorTheme": "Monokai Pro (Filter Machine)",
    "workbench.panel.location": "bottom",
    "workbench.iconTheme": "vscode-great-icons",
    "explorer.autoReveal": false,
    "window.title": "${dirty}${rootName}${separator}${activeEditorLong}",
    "emmet.triggerExpansionOnTab": true,
    "namespaceResolver.showMessageOnStatusBar": true,
    "sublimeTextKeymap.promptV3Features": true,
    "namespaceResolver.autoSort": false,
    "terminal.integrated.fontSize": 18
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
