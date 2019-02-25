<?php
/**
 * 使用ps -ef | grep redis查看redis进程
 * ps是Process Status的缩写，用来列出系统中当前运行的那些进程。
 * netstat命令默认是不显示LISTEN状态的网络连接和LISTEING状态的UNIX域连接，只有使用带-a或者-l参数的命令才能显示出来。
 * chrome --no-sandbox
 *就是说nginx 和 apache 都写好了方法在访问时先把数据放进去了 我能理解的就是 -- http服务器做的
 *拿swoole 写 http 服务写的时候 这个也有要单独写的；所以拿参数 一般是用swoole自带的方法；
 *多进程代码是一样的 所以 要考虑的是变量生存时间 变量共享，要记住代码是一套，别弄混了，
 * ：？就是限制函数输出的类型；
 * 连接池就是php 有自带的方法  产生连接放到连接池里面 用完回收放到连接池里面 其实就是这样
 * 首先是连接池对象还就是单例这种连接的资源文件 最好不要太多 设计成的单例；其实也就是数据库的连接对象一个道理；
 * 经我测试这static::class返回当前完整类路径
 * $redis = new \Redis();
//连接
$redis->connect('127.0.0.1', 6379);
$redis->auth("root"); //密码验证
$res=$redis->get('name');
echo $res;
 * 直接原生可以这么写 -- 但是没必要别人都写好 单例  连接池  协程了
 *
 *前端部署 --
 */