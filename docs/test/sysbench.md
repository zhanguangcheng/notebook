Sysbench
========================

简介
-----

[Sysbench](https://github.com/akopytov/sysbench)是一个模块化的、跨平台、多线程基准测试工具。

它主要包括以下几种方式的测试：
1. cpu性能
2. 磁盘io性能
3. 内存访问性能
4. 线程调度性能
5. POSIX互斥锁性能
6. 数据库性能(OLTP基准测试)

基本语法
---------
```bash
sysbench [options]... [testname] [command]
```

* testname
    * cpu
    * memory
    * fileio
    * threads
    * mutex
    * lua脚本名字或lua脚本路径

* options
    * 通用options
        * --threads 工作线程数，默认1
        * --time 总测试时间（秒），默认10
        * --report-interval 生成报告间隔时间（秒），默认0：不生成
    * 数据库options
        * --mysql-host
        * --mysql-port
        * --mysql-user
        * --mysql-password
        * --mysql-db 数据库名，默认为sbtest

        * --oltp-tables-count 测试表数量
        * --oltp-table-size 每个测试表记录数
        * --oltp-test-mode 测试模式
            * simple 查询测试
            * nontrx 无事务CRUD
            * complex 事务型CRUD

* command
    * prepare 准备测试数据
    * run 执行测试
    * cleanup 清理测试数据
    * help 查看帮助文档，如：`sysbench cpu help`

CPU测试
---------
命令
```bash
sysbench --threads=2 --time=60 cpu run
```
结果
```
sysbench 1.0.20 (using bundled LuaJIT 2.1.0-beta2)

Running the test with following options:
Number of threads: 2
Initializing random number generator from current time


Prime numbers limit: 10000

Initializing worker threads...

Threads started!

CPU speed:
    events per second:   943.23 #每秒处理event数量

General statistics:
    total time:                          60.0030s #总处理时间
    total number of events:              56600 #总处理event数量

Latency (ms):
         min:                                    0.76 #处理event最少用时
         avg:                                    2.12 #处理event平均用时
         max:                                   24.09 #处理event最多用时
         95th percentile:                        2.81 #95%以上event用时
         sum:                               119864.97

Threads fairness:
    events (avg/stddev):           28300.0000/5.00 #平均每个线程完成envet的次数/标准差
    execution time (avg/stddev):   59.9325/0.00 #平均每个线程平均耗时/标准差
```

memory测试
---------
命令
```bash
sysbench memory run
```

磁盘io测试
---------
命令
```bash
sysbench fileio --threads=20 --file-total-size=2G --file-test-mode=rndrw prepare
sysbench fileio --threads=20 --file-total-size=2G --file-test-mode=rndrw run
sysbench fileio cleanup
```

数据库测试
------------
```bash
# 数据准备，数据库需提前创建
sysbench /usr/share/sysbench/tests/include/oltp_legacy/oltp.lua \
    --mysql-host=127.0.0.1 \
    --mysql-port=3306 \
    --mysql-user=root \
    --mysql-password=root \
    --mysql-db=sbtest \
    --oltp-tables-count=10 \
    --oltp-table-size=10000 \
    prepare

# 执行测试
sysbench /usr/share/sysbench/tests/include/oltp_legacy/oltp.lua \
    --mysql-host=127.0.0.1 \
    --mysql-port=3306 \
    --mysql-user=root \
    --mysql-password=root \
    --mysql-db=sbtest \
    --oltp-test-mode=complex \
    --time=600 \
    --report-interval=10 \
    --threads=10 \
    run

# 清理测试数据
sysbench /usr/share/sysbench/tests/include/oltp_legacy/oltp.lua \
    --mysql-host=127.0.0.1 \
    --mysql-port=3306 \
    --mysql-user=root \
    --mysql-password=root \
    --mysql-db=sbtest \
    --oltp-tables-count=10 \
    cleanup
```
