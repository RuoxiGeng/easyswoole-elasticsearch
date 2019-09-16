<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-08-27
 * Time: 21:53
 */

namespace App\HttpController\Api;

use App\Model\Video as VideoModel;
use EasySwoole\Http\Message\Status;
use EasySwoole\Validate\Rule;
use EasySwoole\Log\Logger;
use EasySwoole\EasySwoole\Swoole\Task\TaskManager;
use EasySwoole\Component\Di;

class Video extends Base
{
    public $logType = "video:";

    /**
     * 视频播放页面基本信息接口
     *
     * @return void
     */
    public function index() {
        $id = intval($this->params['id']);
        if(empty($id)) {
            return $this->writeJson(Status::CODE_BAD_REQUEST, "请求不合法");
        }

        // 获取视频的基本信息
        try {
            $video = (new VideoModel())->getById($id);
        }catch(\Exception $e) {
            // 记录日志 $e->getMessage()
            return $this->writeJson(Status::CODE_BAD_REQUEST, "请求不合法");
        }
        if(!$video || $video['status'] != \Yaconf::get("status.normal")) {
            return $this->writeJson(Status::CODE_BAD_REQUEST, "该视频不存在");
        }
        $video['video_duration'] = gmstrftime("%H:%M:%S", $video['video_duration']);

        // 播放数统计逻辑
        // 投放task异步任务
        TaskManager::async(function() use($id) {
            // 逻辑
            //sleep(10);
            // redis记录视频播放数
            $res = Di::getInstance()->get("REDIS")->zincrby(\Yaconf::get("redis.video_play_key"), 1, $id);
            // 按天记录
        });

        return $this->writeJson(200, 'OK', $video);
    }

    /**
     * 排行接口 总排行
     * @return array
     * @throws \Throwable
     */
    public function rank() {
        $res = Di::getInstance()->get("REDIS")->zrevrange(\Yaconf::get("redis.video_play_key"), 0, 1, "withscores");
        return $this->writeJson(200, "OK", $res);
    }

    public function love() {
        $videoId = intval($this->params['videoId']);
        if(empty($videoId)) {
            return $this->writeJson(Status::CODE_BAD_REQUEST, "参数不合法");
        }
        // 跟据这个视频id查询是否存在该视频  todo
        //
        //
        $res = Di::getInstance()->get("REDIS")->zincrby(\Yaconf::get("redis.video_love"), 1, $videoId);

    }

    public function add() {
        $params = $this->request()->getRequestParam();
        $log = new Logger();
        $log->log($this->logType . "add:". json_encode($params));

        //数据校验
        $ruleObj = new Rule();
        $ruleObj->add('name', "视频名称错误")->withRule(Rule::REQUIRED);

        $validate = $this->validateParams($ruleObj);

        if($validate->hasError()) {
            print_r($validate->getErrorList());
            return $this->writeJson(Status::CODE_BAD_REQUEST, $validate->getErrorList()->first()->getMessage());
        }

        $data = [
            'name' => $params['name'],
            'url' => $params['url'],
            'image' => $params['image'],
            'content' => $params['content'],
            'cat_id' => intval($params['cat_id']),
            'create_time' => time(),
            'uploader' => 'geng',
            'status' => \Yaconf::get("status.normal"),
        ];
//        return $this->writeJson(200, 'OK', $params);
        //insert
        try {
            $modelObj = new VideoModel();
            $videoId = $modelObj->add($data);
        }catch (\Exception $e) {
            return $this->writeJson(Status::CODE_BAD_REQUEST, $e->getMessage());
        }

        if(!empty($videoId)) {
            return $this->writeJson(Status::CODE_OK, 'OK', ['id' => $videoId]);
        } else {
            return $this->writeJson(Status::CODE_BAD_REQUEST, '提交视频有误', ['id' => 0]);
        }
    }
}