<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-08-01
 * Time: 22:29
 */

namespace App\HttpController\Api;

use EasySwoole\Http\AbstractInterface\Controller;

/**
 * Api模块基类
 * Class Base
 * @package App\HttpController\Api
 */
class Base extends Controller
{
    public function index(){

    }

    /**
     * 权限相关
     * @param string|null $action
     * @return bool|null
     */
    public function onRequest(?string $action): ?bool {
        return true;
    }

    /**
     * @param \Throwable $throwable
     */
    protected function onException(\Throwable $throwable): void {
        $this->writeJson(400, '请求不合法');
    }
}