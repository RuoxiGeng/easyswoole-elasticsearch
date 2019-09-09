<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-08-01
 * Time: 00:31
 */

namespace App\HttpController\Api;

use EasySwoole\Http\Message\Status;
use EasySwoole\Component\Di;
use App\Lib\Redis\Redis;
use App\Model\Video as VideoModel;
use EasySwoole\FastCache\Cache;
use App\Lib\Cache\Video as VideoCache;

class Index extends Base
{
    public function index() {

    }

    /**
     * 第一套方案 原始 读取mysql
     * @return bool
     */
    public function lists0() {
        $condition = [];
        if(!empty($this->params['cat_id'])) {
            $condition['cat_id'] = intval($this->params['cat_id']);
        }
        //1 查询条件下 count
        //2 lists
        try {
            $videoModel = new VideoModel();
            $data = $videoModel->getVideoData($condition, $this->params['page'], $this->params['size']);
        }catch (\Exception $e) {
            //错误信息写入日志
            return $this->writeJson(Status::CODE_BAD_REQUEST, '服务异常');
        }

        if(!empty($data['lists'])) {
            foreach ($data['lists'] as &$list) {
                $list['create_time'] = date("Ymd H:i:s", $list['create_time']);
                //时间转换
                $list['video_duration'] = gmstrftime("%H:%M:%S", $list['video_duration']);
            }
        }
        return $this->writeJson(Status::CODE_OK, 'OK', $data);
    }

    /**
     * 第二套方案 直接读取静态化json数据
     * @return bool
     */
    public function lists() {
        $catId = !empty($this->params['cat_id']) ? intval($this->params['cat_id']) : 0;

        try {
            $videoData = (new VideoCache())->getCache($catId);
        }catch (\Exception $e) {
            return $this->writeJson(Status::CODE_BAD_REQUEST, '请求失败');
        }

        $count = count($videoData);

        return $this->writeJson(Status::CODE_OK, 'OK', $this->getPagingDatas($count, $videoData));
    }

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

    public function yaconf() {
        $res = \Yaconf::get('redis');
        return $this->writeJson(200, 'OK', $res);
    }

    public function pub() {
        $params = $this->request()->getRequestParam();

        Di::getInstance()->get('REDIS')->rPush('geng_list_test', $params['f']);
    }
}