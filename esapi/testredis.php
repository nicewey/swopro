<?php

$redis = new Redis();
//连接
$redis->connect('127.0.0.1', 6379);
$redis->auth("root"); //密码验证
$res=$redis->get('name');
echo $res;