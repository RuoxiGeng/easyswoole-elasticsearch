<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-08-27
 * Time: 22:30
 */

namespace App\Model;

use EasySwoole\Component\Di;

class Base {
    public function __construct() {
        if (empty($this->tableName)) {
            throw new \Exception("table error");
        }

        $db = Di::getInstance()->get("MYSQL");
        if($db instanceof \MysqliDb) {
            $this->db = $db;
        } else {
            throw new \Exception("db error");
        }
    }

    /**
     * @param $data
     * @return bool
     */
    public function add($data) {
        if(empty($data) || !is_array($data)) {
            return false;
        }

        return $this->db->insert($this->tableName, $data);
    }

    /**
     * 通过ID 获取 基本信息
     *
     * @param [type] $id
     * @return void
     */
    public function getById($id) {
        $id = intval($id);
        if(empty($id)) {
            return [];
        }

        $this->db->where ("id", $id);
        $result = $this->db->getOne($this->tableName);
        return $result ?? [];
    }
}
