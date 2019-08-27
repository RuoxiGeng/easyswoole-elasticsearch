<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-08-14
 * Time: 09:48
 */

namespace App\Lib;

/**
 * 做一些反射机制有关的处理
 */
class ClassArr {

    /**
     * [uploadClassStat description]
     * @auth   singwa
     * @date   2018-10-21T11:23:12+0800
     * @return array [type]                   [description]
     */
    public function uploadClassStat() {
        return [
            "image" => "\App\Lib\Upload\Image",
            "video" => "\App\Lib\Upload\Video",
        ];
    }

    /**
     * [initClass description]
     * @auth   singwa
     * @date   2018-10-21T11:28:05+0800
     * @param $type
     * @param $supportedClass
     * @param  array $params [description]
     * @param  boolean $needInstance [description]
     * @return bool|object [type]                                   [description]
     * @throws \ReflectionException
     */
    public function initClass($type, $supportedClass, $params = [], $needInstance = true) {
        if(!array_key_exists($type, $supportedClass)) {
            return false;
        }

        $className = $supportedClass[$type];

        return $needInstance ? (new \ReflectionClass($className))->newInstanceArgs($params) : $className;
    }

}