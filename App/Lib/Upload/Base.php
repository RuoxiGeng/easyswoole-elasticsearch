<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-08-10
 * Time: 21:28
 */

namespace App\Lib\Upload;

class Base {

    /**
     * 上传文件的 file - key
     * @var string
     */
    public $type = "";

    public function __construct($request) {
        $this->request = $request;
        $files = $this->request->getSwooleRequest()->files;
        $types = array_keys($files);
        $this->type = $types[0];
    }

    public function upload() {
        if($this->type != $this->fileType) {
            return false;
        }
        $videos = $this->request->getUploadedFile($this->type);

        $this->size = $videos->getSize();
        $this->checkSize();

        $fileName = $videos->getClientFileName();
        $this->clientMediaType = $videos->getClientMediaType();

        $this->checkMediaType();
    }

    public function checkSize() {
        if(empty($this->size)) {
            return false;
        }
    }

    public function checkMediaType() {
        echo $this->clientMediaType;
    }
}