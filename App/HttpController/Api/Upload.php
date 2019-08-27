<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-08-10
 * Time: 20:01
 */

namespace App\HttpController\Api;

use App\Lib\ClassArr;
use App\Lib\Upload\Image;
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
        $files = $request->getSwooleRequest()->files;
        $types = array_keys($files);
        $type = $types[0];
        if(empty($type)) {
            return $this->writeJson(400, '上传文件不合法');
        }

        //php反射机制


        try {
//            $obj = new Video($request);
//            $obj = new $obj($request);
            $classObj = new ClassArr();
            $classStats = $classObj->uploadClassStat();
            $uploadObj = $classObj->initClass($type, $classStats, [$request, $type]);

            $file = $uploadObj->upload();
        }catch (\Exception $e) {
            return $this->writeJson(400, $e->getMessage(), []);
        }

        if(empty($file)) {
            return $this->writeJson(400, "上传失败", []);
        }

        $data = [
            'url' => $file,
        ];
        return $this->writeJson(200, 'OK', $data);


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