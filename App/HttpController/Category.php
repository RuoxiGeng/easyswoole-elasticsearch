<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-08-01
 * Time: 00:31
 */

namespace App\HttpController;

use EasySwoole\Http\AbstractInterface\Controller;

class Category extends Controller
{

    public function index() {
        $data = [
            'id' => 1,
            'name' => 'geng',
        ];
        return $this->writeJson(200, 'OK', $data);
    }
}