<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-08-29
 * Time: 21:07
 */

namespace App\HttpController\Api;

class Category extends Base {

    public function index() {
        $config = \Yaconf::get("category.cats");
        return $this->writeJson(200, 'OK', $config);
    }
}