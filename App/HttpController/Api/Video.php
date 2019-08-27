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

class Video extends Base
{
    public $logType = "video:";

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