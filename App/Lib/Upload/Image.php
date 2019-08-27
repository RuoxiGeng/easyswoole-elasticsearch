<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-08-13
 * Time: 22:20
 */

namespace App\Lib\Upload;

class Image extends Base {

    /**
     * @var string
     */
    public $fileType = "image";

    /**
     * @var int
     */
    public $maxSize = 122;

    /**
     * 文件后缀的mediaType
     * @var array
     */
    public $fileExtTypes = [
        'png',
        'jpeg',
    ];
}