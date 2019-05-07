Excel相关
==============


## 基本

### 单元格引用方式

* 相对 `A1` 行列会跟随变化
* 混合 `$A1` `A$1` 行或列会跟随变化
* 绝对引用 `$A$1` 行不列会跟随变化

### 区域引用

> 可组合使用，包括单元格引用

* 单个区域 `A1:B2`
* 联合区域 `(区域1,区域2...)`：多个区域合起来
* 交集区域 `(区域1 区域2...)`：多个区域相交的部分
* 整行区域 `1:1`:单行 `1:2`:多行
* 整列区域 `A:A`:单列 `A:B`:多列
* 跨Sheet `Sheet名称!区域`

### 运算符
* 算数运算符
`+ - * / % ^`

* 比较运算符
`= > < >= <= <>`

* 文本运算符
`&`


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
* `sum(number1, [number2], ...)` 求和
* `sumif(range,criteria,[sum_range])` 根据条件求和
* `sumproduct(array1，[array2]，…)` 多条件求和
* `randbetween(bottom, top)` 生成范围内随机整数
* `round(number, num_digits)` 四舍五入
* `mod(number, divisor)` 取余
* `int(number)` 向下取整

### 统计函数
* `average(number1，[number2],…)` 求平均数
* `averageif (range,criteria，[average_range])` 条件求平均数
* `count(value1,[value2],…)` 计算包含数值单元格个数
* `counta(value1,[value2],…)` 计算非空单元格个数
* `countblank(value1,[value2],…)` 计算空值单元格个数
* `countif(range,criteria)` 按条件统计单元格个数
* `min(number1, [number2],...)` 求最小值
* `max(number1, [number2],...)` 求最大值

### 其他函数

* `webservice(url)` 获取指定url的响应


## 技巧

### 快速填充

#### 文本连接分割

#### 文本提取


## 图表


## 数据透视表
