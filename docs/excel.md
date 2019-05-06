Excel相关
==============


## 基本

### 单元格引用方式

## 函数

### 文本函数

* `len(text)` 返回文本字符串中的字符个数。
* `left(text, num_chars)` 返回文本字符串中左边的字符个数。
* `right(text, num_chars)` 返回文本字符串中右边的字符个数。
* `mid(text, start_num, num_chars)` 返回文本字符串中从指定位置开始的特定数目的字符
* `lower(text)` 将文本字符串中的字母转换为小写
* `upper(text)` 将文本字符串中的字母转换为大写
* `search(find_text, within_text, [start_num])` 查找一个字符串在另一个字符串中第一次出现的位置(不区分大小写，若要区分使用find)
* `replace(old_text，start_num，num_charts，new_charts)` 将一个字符串中的部分字符串用另外一个字符串替换
* `substitute(text，old_text，new_text，[instance_num])` 将一个字符串中的指定字符串用另外一个字符串替换
* `rept(text，number_times)` 根据指定次数重复文本
* `concatenate(text1, text2...)` 合并多个字符串为一个(类似&连接符)
* `trim(text)` 去除文本两边空格

### 查找索引函数
* `vlookup(lookup_value, table_array, col_index_num, [range_lookup])` 在某个区域中查找特定的值并返回指定列的数据（先找行再找列）
* `hlookup(lookup_value, table_array, row_index_num, [range_lookup])` 在某个区域中查找特定的值并返回指定行的数据（先找列再找行）
* `column([reference])` 单元格在第几列
* `columns(array)` 指定区域有几列
* `row([reference])` 单元格在第几行
* `rows(array)` 指定区域有几行
* `index(array, row_num, [column_num])` 在指定的区域中获取指定行列的值
* `indirect(ref_text)` 通过引用获取指定单元格的值
* `match(lookup_value, lookup_array, [match_type])` 在有个区域查找特定的值并返回所在位置

### 逻辑函数
* `and(logical1, [logical2], ...)` 全部为true结果为true
* `or(logical1, [logical2], ...)` 其中一个为true结果为true
* `not(logical)` 结果取反
* `if(logical_test, [value_if_true], [value_if_false])` 根据条件判断返回指定值
* `iferror(value, value_if_error)` 结果有错误时显示value_if_error，否则显示原来的值
* `ifna(value, value_if_na)` 结果为#N/A时显示value_if_error，否则显示原来的值

### 日期函数

### 数学函数

### 统计函数

### 其他函数

* `webservice(url)` 获取指定url的响应


## 技巧

### 快速填充

#### 文本连接分割

#### 文本提取


## 图表


## 数据透视表
