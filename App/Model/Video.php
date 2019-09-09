<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-08-27
 * Time: 22:30
 */

namespace App\Model;

class Video extends Base{

    public $tableName = "video";

    /**
     * 通过条件获取数据库里面的video
     * @param array $condition
     * @param int $page
     * @param int $size
     * @return array
     */
    public function getVideoData($condition = [], $page = 1, $size = 10) {
        if(!empty($condition['cat_id'])) {
            $this->db->where("cat_id", $condition['cat_id']);
        }

        $this->db->where("status", 1);
        if(!empty($size)) {
            $this->db->pageLimit = $size;
        }

        $this->db->orderBy("id", "desc");
        $res = $this->db->paginate($this->tableName, $page);

        $data = [
            'total_page' => $this->db->totalPages,
            'page_size' => $size,
            'count' => intval($this->db->totalCount),
            'lists' => $res,
        ];
        return $data;
    }

    /**
     * @param array $condition
     * @param int $size
     * @return mixed
     */
    public function getVideoCacheData($condition = [], $size = 1000) {
        if(!empty($condition['cat_id'])) {
            $this->db->where("cat_id", $condition['cat_id']);
        }

        $this->db->where("status", 1);
        if(!empty($size)) {
            $this->db->pageLimit = $size;
        }

        $this->db->orderBy("id", "desc");
        $res = $this->db->paginate($this->tableName, 1);

        return $res;
    }
}