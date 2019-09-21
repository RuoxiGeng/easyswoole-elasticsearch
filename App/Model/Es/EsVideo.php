<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-09-17
 * Time: 22:15
 */

namespace App\Model\Es;

class EsVideo extends EsBase {
    public $index = "imooc_video";
    public $type = "video";
}