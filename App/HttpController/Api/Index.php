<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-08-01
 * Time: 00:31
 */

namespace App\HttpController\Api;

use EasySwoole\Component\Di;
use App\Lib\Redis\Redis;

class Index extends Base
{
    public function video() {
        $data = [
            'id' => 1,
            'name' => 'geng1',
            'params' => $this->request()->getRequestParam(),
        ];
        return $this->writeJson(201, 'OK', $data);
    }

    /**
     * @return bool
     * @throws \Throwable
     */
    public function getVideo() {
        $db = Di::getInstance()->get("MYSQL");
        $res = $db->where("id", 1)->getOne("test");
        return $this->writeJson(200, 'OK', $res);
    }

    public function getRedis() {
//        $redis = new \Redis();
//        $redis->connect("127.0.0.1", 6379, 5);

//        $redis->set("geng12345", 100);

//        $res = Redis::getInstance()->get("geng12345");
        $res = Di::getInstance()->get("REDIS")->get("geng12345");
        return $this->writeJson(200, 'OK', $res);
    }
}