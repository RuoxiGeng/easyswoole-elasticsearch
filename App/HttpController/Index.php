<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-08-01
 * Time: 00:31
 */

namespace App\HttpController;

use EasySwoole\Http\AbstractInterface\Controller;
use App\Lib\AliyunSdk\AliVod;
use Elasticsearch\ClientBuilder;

class Index extends Controller
{

    function index()
    {
        // 测试 php-elasticsearch demo
        $params = [
            "index" => "imooc_video",
            "type" => "video",
            //"id" => 1,
            'body' => [
                'query' => [
                    'match' => [
                        'name' => '刘德华'
                    ],
                ],
            ],
        ];

        $client = ClientBuilder::create()->setHosts(["127.0.0.1:8301"])->build();
        $result = $client->search($params);

        return $this->writeJson(200, "OK", $result);
    }

    public function testAli() {
        $obj = new AliVod();
        $title = "geng-test";
        $videoName = "1.mp4";
        $res = $obj->createUploadVideo($title, $videoName);

        $uploadAddress = json_decode(base64_decode($res->uploadAddress), true);

        $uploadAuth = json_decode(base64_decode($res->uploadAuth), true);

        $obj->initOssClient($uploadAuth, $uploadAddress);

        $videoFile = "/home/work/hdtocs/imooc/imooc_esapi/webroot/video/2018/10/7648e6280470bbbc.mp4";
        $result = $obj->uploadLocalFile($uploadAddress, $videoFile);

        print_r($result);
    }

    public function getVideo() {
        $videoId = "345183ba6d54420080ae63830afb663c";
        $obj = new AliVod();
        print_r($obj->getPlayInfo($videoId));
    }

}