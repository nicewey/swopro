<?php

namespace App\HttpController\Api;
use App\Utility\Pool\MysqlPool;
use App\Utility\Pool\MysqlObject;
use App\Utility\Pool\RedisObject;
use App\Utility\Pool\RedisPool;



/**
 * Class Index
 * @package App\HttpController
 */
class Index extends Base
{
    /**
     * video
     * @author : evalor <master@evalor.cn>
     */
    function video()
    {
        $data = [
            'id' => '11',
            'name' => '22',
            'params' => $this->request()->getQueryParams(),
        ];
        return $this->writeJson(200,$data,'ok');
    }
    function test()
    {
        try {
            MysqlPool::invoke(function (MysqlObject $mysqlObject) {
                $res=$mysqlObject->get('test');
                return;
            });
        } catch (\Throwable $throwable) {
            $this->writeJson(Status::CODE_BAD_REQUEST, null, $throwable->getMessage());
        }catch (PoolEmpty $poolEmpty){
            $this->writeJson(Status::CODE_BAD_REQUEST, null, '没有链接可用');

        }catch (PoolUnRegister $poolUnRegister){
            $this->writeJson(Status::CODE_BAD_REQUEST, null, '连接池未注册');
        }
        //return $this->writeJson(200,$key,':?');
    }
    function testRedis()
    {
        try {
            $result = RedisPool::invoke(function(RedisObject $redis) {
                $name = $redis->get('name');
                $arr=[1,2,3,4,5,6,7,8,11,22,33,44,55,66,77,88,99];
                foreach ($arr as $v){
                    $redis->rPush('cui_list',$v);
                }
                return $name;
            });
            $this->writeJson(200, $result);
        } catch (\Throwable $throwable) {
            $this->writeJson(400, null, $throwable->getMessage());
        }
    }
}
