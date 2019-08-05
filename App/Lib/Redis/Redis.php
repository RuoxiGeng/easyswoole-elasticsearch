<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-08-05
 * Time: 22:11
 */

namespace App\Lib\Redis;

use Composer\Config;
use EasySwoole\Component\Singleton;

class Redis {
    use Singleton;

    public $redis = "";

    private function __construct() {
        if(!extension_loaded('redis')) {
            throw new \Exception("redis.so不存在");
        }

        try {
            $redisConfig = \EasySwoole\EasySwoole\Config::getInstance()->getConf("redis");
            $this->redis = new \Redis();
            $res = $this->redis->connect($redisConfig['host'], $redisConfig['port'], $redisConfig['time_out']);
        } catch (\Exception $e) {
            throw new \Exception("redis服务异常");
        }

        if($res === false) {
            throw new \Exception("redis连接失败");
        }
    }

    /**
     * @param $key
     * @return bool|string
     */
    public function get($key) {
        if(empty($key)) {
            return '';
        }

        return $this->redis->get($key);
    }
}