<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-08-10
 * Time: 20:01
 */

namespace App\HttpController\Api;

use EasySwoole\Component\Di;

/**
 * 文件上传逻辑 - 视频 图片
 * Class Upload
 * @package App\HttpController\Api
 */

use App\Lib\Upload\Video;

class Upload extends Base
{
    public function file() {
        $request = $this->request();
        $obj = new Video($request);
        $obj->upload();
//        $request = $this->request();
//        $videos = $request->getUploadedFile("file");
//
//        $flag = $videos->moveTo("/Users/ruoxigeng/imooc_es/webroot/1.mp4");
//        $data = [
//            'url' => "/1.mp4",
//            'flag' => $flag,
//        ];
//
//        if($flag) {
//            return $this->writeJson(200, 'OK', $data);
//        } else {
//            return $this->writeJson(400, 'error', $data);
//        }
    }
}