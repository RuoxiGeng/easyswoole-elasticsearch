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
    /**
     * 放一些请求的参数数据
     * @var array
     */
    public $params = [];

    public function index(){

    }

    /**
     * 权限相关
     * @param string|null $action
     * @return bool|null
     */
    public function onRequest(?string $action): ?bool {
        $this->getParams();
        return true;
    }

    /**
     * 获取 params
     */
    public function getParams() {
        $params = $this->request()->getRequestParam();
        $params['page'] = !empty($params['page']) ? intval($params['page']) : 1;
        $params['size'] = !empty($params['size']) ? intval($params['size']) : 5;

        $this->params = $params;
    }

    /**
     * @param \Throwable $throwable
     */
//    protected function onException(\Throwable $throwable): void {
//        $this->writeJson(400, '请求不合法');
//    }
}