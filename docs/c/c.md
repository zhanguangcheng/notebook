## 第一个hello world程序
```c
#include <stdio.h>

/*
我是多行注释
main为程序的入口, 一个程序里面只能有一个main函数
include为头文件包含语句, #开头的为预处理语句, 语句后面不需要分号(;)
 */
int main()
{
    // 格式化输出, 我是单行注释
    printf("Hello World!");
    return 0;
}
```

* {}括号和代码块代表一个代码单元
* main 函数可以不返回或者返回
* 普通函数必须返回
* c语言不返回不会报错,但是会有垃圾结果


## 变量

* C语言规定, 所有的变量必须先声明后使用
* 必须先申明并初始化后使用
* 变量名只能包含字母数字下划线, 不能用数字开头
* 变量名严格区分大小写
* 不能使用系统关键字
* vs2013可以使用中文, unix不能使用中文, 建议是不使用中文
* c语言老版本编译器, gcc如果没有开启c++11的支持, vc2010之前的版本, 变量必须在函数调用之前申明.


## 常量

定义常量的两种方式

```c
#define MAX 10 //常量，编译后引用MAX的地方都会被替换成10
const int MIN = 10;//实质是变量，不能直接修改(MIN=1), 但是可以间接修改*(int*)(&MIN) = 1;
```
* 一定要在定义的时候赋值，不然定义之后就无法赋值了


## 运算符

```c
//赋值运算符, 赋值运算符会自动转换数据类型
= += -+ *= /= %=

// 算术运算符
+ - * / % ++ --

// 逻辑运算符
&& || !

//关系运算符
< > <= >= !=

//位运算符
& | ~ ^ >> << >>>
```


## 分支结构

```c
/* if else */
if(/* condition */)
{
    // code
}

if(/* condition */)
{
    // code
}
else
{
    // code
}

if(/* condition */)
{
    // code
}
else if(/* condition */)
{
    // code
}
else
{
    // code
}


/* switch */
switch(/* condition */)
{
case 常量1:
    // code
    break;
case 常量2:
    // code
    break;
......
default:
    // code
}
```

## 循环结构

```c


while(/* condition */)
{
    // code
}

do
{
    
}while(/* condition */);

for (int i = 0; i < count; ++i)
{
    // code
}
```


## 数组

```c
int items1[2] = {1, 8};
int items2[] = {1, 2, 3};
int items3[10] = {1, 3};
```

* 数组中的每个元素在内存中是顺序存储的, 是有序的, 内存地址间隔大小为数组元素的数据类型的大小

## 指针

> 保存内存地址的变量

```c
int var = 1;

// 将var变量的内存地址取出来保存到指针变量ptr_var中
int* ptr_var = &var;

// 使用指针修改值
*ptr_var = 2;

// 数组中的指针
int nums[] = {1, 2, 3};
printf("%d", nums == &nums[0]);// 结果为1, 说明数组名就是数组首个元素的内存地址
```

* ptr_开头为定义指针变量的规范
* 指针变量的数据类型与要取的变量的数据类型一致
* &变量: 取变量的内存地址; *指针变量: 表示取该指针变量的值(顺藤摸瓜)
* 数组名就是数组首个元素的内存地址
* 指针是可以进行运算的, 如++, --, +5; ++之后指针则指向数组的下一个元素


## 函数

```c
int sum(int, int);
int sum(int x, int y) 
{
    return x + y;
}
```


## 字符串

```c
// 初始化字符数组时会把静态存储区的字符串拷贝到数组中
// 下面两行代码等价，字符串于字符数组的区别: 字符数组最后为\0
char str1[] = {'a', 'b', 'c', 'd', '\0'};
char str2[] = "abcd";

// 初始化指针时, 只把字符串的地址拷贝给指针
char * str3 = "abcd";
```

* C语言中用字符数组或者字符指针来表示字符串；  
* 字符数组中最后一个元素是'\0'的数组就是字符串；  
* 用双引号也可以表示字符串，其实际也会转换成最后一个元素为'\0'的字符数组；  
* 用字符指针申明字符串时，其指针可以操作，字符数组申明则不能；



## 关键字

|关键字    |描述|
|---------|---|
|\_Packed ||
|auto     ||
|break    |分支&循环语句|
|case     |swtich语句|
|char     ||
|const    ||
|continue |for语句|
|default  |swtich语句|
|double   ||
|do       ||
|else     |分支语句|
|enum     ||
|extern   ||
|float    ||
|for      ||
|goto     ||
|if       |分支语句|
|int      ||
|long     ||
|register ||
|return   ||
|short    ||
|signed   ||
|sizeof   |得到某一数据类型占用的字节数|
|static   ||
|struct   ||
|switch   | 分支语句|
|typedef  ||
|union    ||
|unsigned ||
|void     ||
|volatile ||
|while    |
|


## 数据类型

* 在32位以上操作系统 int等价于long int

### 整数
* short int
* int
* long int
* long long int
* unsigned short int
* unsigned int
* unsigned long int
* unsigned long long int
* char

### 浮点数

* float
* double


## 内置函数

### stdio.h

```c
int printf(const char *format, ...);
int sprintf(char *buffer, const char *format, ...);
int scanf(const char *format, ...);

// 获取字符串, 长度无限制
char *gets(char *str );

// 获取字符串, 可以限制长度, 缺点: 会多加一个\n字符
char *fgets(char *str, int count, FILE *stream);
```

### stdlib.h

```c
// 以seed播种, 向rand()生成随机种子。
void srand(unsigned seed);

// 生成 0 ~ RAND_MAX(32767) 之间的随机数
int rand();

// 终止程序并返回exit_code
void exit(int exit_code);

// 执行命令command
int system(const char *command);

// 分配size字节的未初始化内存。返回最低位（首位）字节的指针
void* malloc(size_t size);

// 为num个对象size字节分配内存，并初始化所有分配存储中的字节为零。
void* calloc(size_t num, size_t size);

// 释放动态分配的内存空间
void* free(void* ptr);
```

### time.h

```c
time_t time(time_t *arg);
```

### windows.h

```c
Sleep()
```

### ctype.h

```c
int isupper(int ch);
int islower(int ch);
int isalpha(int ch);
int isdigit(int ch);
int toupper(int ch);
int tolower(int ch);
```

### math.h

```c
double ceil(double arg);
double floor(double arg);
double sqrt(double arg);
double pow(double base, double exponent);
int abs(int);
```

## string.h

```c
// 计算字符串的长度
size_t strlen( const char *str );

// 字符串赋值, dest的内存空间不能小于src, 不然会溢出, 影响其他内存空间
char *strcpy( char *dest, const char *src );

// 字符串比较, 相同返回0
int strcmp( const char *lhs, const char *rhs );

// 字符串连接, 注意dest的内存空间
char *strcat( char *dest, const char *src );
```

## 进制转换

```
2->10
    1101 -> 1*2^3+1*2^2+0*2^1+1*2^0=13
8->10
    0123 -> 1*8^2+2*8^1+3*8^0=83
16->10
    0x12 -> 1*16^1+2*16^0=18
2->8 (3位一分割)
    1101 -> 001 101 -> 15
8->2
    12 -> 1=001 2=010 001010 -> 1010
2->16(四位一分割)
    100101101 -> 1 0010 1101 -> 12d
16->2
    ox12d -> 1=001 2=010 d= 1101 -> 100101101
10->2
```


## 内存

* 手机,电脑都是低位占低字节, 高位占高字节
* unix系统相反

## 原码,反码,补码

* 手机,电脑,服务器内存都是保存补码
* 高位为1表示负数,为0表示正数
* 正数的原码,反码,补码都一样
* 负数 反码: 原码取反(符号位除外) 补码:反码+1
* -7的补码

```
原码1000 0111
反码1111 1000
补码1111 1001
```


## 变量cpu原理

```c
int a;
a = 10;
a += 5;
```

1. 预编译将变量a导入符号表
2. 将10放到cpu寄存器中,再放到内存对应的a的地址中
3. 将10导入到寄存器中,进行运算,得出结果放到寄存器, 在放到对应的内存中


## 命令

gcc [options] files...

options

* -o <file\> 指定输出文件名
* -E 代表预编译


## 其他

```c
// void*表示返回任意类型的指针
void* malloc( size_t size );
```
