<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/5/28
 * Time: 下午6:33
 */

namespace EasySwoole\EasySwoole;


use App\Lib\Process\ConsumerTest;
use EasySwoole\Component\Di;
use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\Mysqli\Mysqli;
use App\Lib\Redis\Redis;
use EasySwoole\Utility\File;
use EasySwoole\EasySwoole\Crontab\Crontab;
use App\Task\TaskOne;
use EasySwoole\Component\Timer;

class EasySwooleEvent implements Event
{

    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set('Asia/Shanghai');

        self::loadConf(EASYSWOOLE_ROOT . '/Config');
    }

    public static function loadConf($ConfPath)
    {
        $Conf  = Config::getInstance();
        $files = File::scanDirectory($ConfPath);

        if (!is_array($files)) {
            return;
        }
        foreach ($files['files'] as $file) {
            $data = require_once $file;
            $Conf->setConf(strtolower(basename($file, '.php')), (array)$data);
        }
    }

    public static function mainServerCreate(EventRegister $register)
    {
        // TODO: Implement mainServerCreate() method.
        $conf = new \EasySwoole\Mysqli\Config(Config::getInstance()->getConf('MYSQL'));
        Di::getInstance()->set('MYSQL', Mysqli::class, $conf);

        Di::getInstance()->set('REDIS', Redis::getInstance());

        $allNum = 3;
        for ($i = 0 ;$i < $allNum;$i++){
            ServerManager::getInstance()->getSwooleServer()->addProcess((new ConsumerTest("geng_consumer_test_{$i}"))->getProcess());
        }

//        Crontab::getInstance()->addTask(TaskOne::class);

        $register->add(EventRegister::onWorkerStart, function (\swoole_server $server, $workerId) {
            if($workerId == 0) {
                Timer::getInstance()->loop(1000 * 2, function() use($workerId) {
//                  Crontab::getInstance()->addTask(TaskOne::class);
                    var_dump($workerId);
                });
            }
        });
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