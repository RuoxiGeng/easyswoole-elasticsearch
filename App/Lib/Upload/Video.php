<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-08-10
 * Time: 20:35
 */

namespace App\Lib\Upload;

class Video extends Base {

    /**
     * @var string
     */
    public $fileType = "video";

    /**
     * @var int
     */
    public $maxSize = 122;

    /**
     * 文件后缀的mediaType
     * @var array
     */
    public $fileExtTypes = [
        'mp4',
        'x-flv',
    ];
}