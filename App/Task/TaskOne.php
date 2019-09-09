<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-09-03
 * Time: 22:56
 */

namespace App\Task;

use EasySwoole\EasySwoole\Crontab\AbstractCronTask;
use EasySwoole\EasySwoole\Swoole\Task\TaskManager;
use App\Lib\Cache\Video;

class TaskOne extends AbstractCronTask
{

    public static function getRule(): string
    {
        return '*/1 * * * *';
    }

    public static function getTaskName(): string
    {
        return  'taskOne';
    }

    static function run(\swoole_server $server, int $taskId, int $fromWorkerId,$flags=null)
    {
        $cacheVideoObj = new Video();

        $cacheVideoObj->setIndexVideo();
    }

    function onException(\Throwable $throwable, int $taskId, int $workerIndex)
    {
        echo $throwable->getMessage();
    }
}