<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/5/28
 * Time: 下午6:33
 */

namespace EasySwoole\EasySwoole;


use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\Component\Pool\PoolManager;
use App\Utility\Pool\MysqlPool;
use App\Utility\Pool\RedisPool;
use App\Lib\Process\Consumer;

class EasySwooleEvent implements Event
{

    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set('Asia/Shanghai');
        PoolManager::getInstance()->register(MysqlPool::class, Config::getInstance()->getConf('MYSQL.POOL_MAX_NUM'));
    }

    public static function mainServerCreate(EventRegister $register){
        // TODO: Implement mainServerCreate() method.
        $register->add($register::onWorkerStart, function (\swoole_server $server, int $workerId) {
            if ($server->taskworker == false) {
                PoolManager::getInstance()->getPool(MysqlPool::class)->preLoad(1);
                //PoolManager::getInstance()->getPool(RedisPool::class)->preLoad(预创建数量,必须小于连接池最大数量);
            }
            // var_dump('worker:' . $workerId . 'start');
        });
        $register->add($register::onWorkerStart, function (\swoole_server $server, int $workerId) {
            if ($server->taskworker == false) {
                PoolManager::getInstance()->getPool(RedisPool::class)->preLoad(1);
                //PoolManager::getInstance()->getPool(RedisPool::class)->preLoad(预创建数量,必须小于连接池最大数量);
            }

            // var_dump('worker:' . $workerId . 'start');
        });
        //分3个进程去每隔500毫秒执行消费者 run方法
        $allNum = 3;
        for ($i = 0 ;$i < $allNum;$i++){
            ServerManager::getInstance()->getSwooleServer()->addProcess((new Consumer("cui_consumer_{$i}"))->getProcess());
        }
    }

    public static function onRequest(Request $request, Response $response): bool
    {
        // TODO: Implement onRequest() method.
        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {
        // TODO: Implement afterAction() method.
    }
}