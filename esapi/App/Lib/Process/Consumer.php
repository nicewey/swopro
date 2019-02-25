<?php
/**
 * Created by PhpStorm.
 * User: Tioncico
 * Date: 2018/10/18 0018
 * Time: 9:43
 */

namespace App\Lib\Process;

use EasySwoole\Component\Process\AbstractProcess;
use App\Utility\Pool\RedisObject;
use App\Utility\Pool\RedisPool;
use EasySwoole\EasySwoole\Logger;

class Consumer extends AbstractProcess
{
    private $isRun = false;
    public function run($arg)
    {
        // TODO: Implement run() method.
        /*
         * 举例，消费redis中的队列数据
         * 定时500ms检测有没有任务，有的话就while死循环执行
         */

        $this->addTick(1000,function (){
            if(!$this->isRun){
                $this->isRun = true;
                try {
                     RedisPool::invoke(function(RedisObject $redis) {
                        while (true){
                            try{
                                $task = $redis->lPop('cui_list');
                                if($task){
                                    //发送邮件 推送消息 写log
                                    Logger::getInstance()->log($this->getProcessName()."__".$task);
                                }else{
                                    break;
                                }
                            }catch (\Throwable $throwable){
                                break;
                            }
                        }
                        $this->isRun = false;
                    });

                } catch (\Throwable $throwable) {
                    var_dump($throwable->getMessage());
                }
            }
        });
    }

    public function onShutDown()
    {
        // TODO: Implement onShutDown() method.
    }

    public function onReceive(string $str, ...$args)
    {
        // TODO: Implement onReceive() method.
    }
}
