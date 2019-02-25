<?php

namespace App\HttpController\Api;

use EasySwoole\Http\AbstractInterface\Controller;


/**
 * Class Index
 * @package App\HttpController
 */
class Base extends Controller
{
    /**
     * Api 模块基础类库
     * @author : evalor <master@evalor.cn>
     */
    function index()
    {
        $this->writeJson(400,[11,22],static::class);
    }

    /**
     * @param null|string $action
     * @return bool|null
     */
    protected function onRequest(?string $action): ?bool
    {
        return true;
    }

    /**
     * @param \Throwable $throwable
     * @throws \Throwable
     */
    /*protected function onException(\Throwable $throwable): void
    {
        $this->writeJson(400,[11,22],'Illegal request');
    }*/

}
