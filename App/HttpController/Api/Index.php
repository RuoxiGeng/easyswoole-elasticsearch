<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-08-01
 * Time: 00:31
 */

namespace App\HttpController\Api;

class Index extends Base
{
    public function video() {
        $data = [
            'id' => 1,
            'name' => 'geng1',
            'params' => $this->request()->getRequestParam(),
        ];
        return $this->writeJson(201, 'OK', $data);
    }
}