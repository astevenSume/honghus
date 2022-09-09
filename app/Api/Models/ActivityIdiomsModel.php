<?php

namespace App\Api\Models;

use App\Api\Forms\ActivityIdiomsForm;
use App\Api\Forms\CyForm;
use Mix\Database\Pool\ConnectionPool;

/**
 * Class ActivityIdiomsModel
 * @package App\Api\Models
 * @author liu,jian <coder.keda@gmail.com>
 */
class ActivityIdiomsModel
{

    /**
     * @var ConnectionPool
     */
    public $pool;
    private $tablename;

    /**
     * UserModel constructor.
     */
    public function __construct()
    {
        $this->pool = context()->get('dbPool');
        $this->tablename = 'activity_idioms'; 
    }

    /**
     * 
     * @return bool 
     */
    public function isExistGoodId(string $goodId) {
        $db = $this->pool->getConnection();

        $sql = "select 1 from `activity_idioms` where good_id = :id";
        $row = $db->prepare($sql)->bindParams([
            'id' => $goodId,
        ])->queryAll();

        return count($row) > 0;
    }

    public function batchInsert(array $inArr) {
        $db = $this->pool->getConnection();
        $db->BatchInsert('activity_idioms', $inArr)->execute();
        //todo err report 
    }

 
    public function findOrderIdiomByMin(string $goodId) {
        $db = $this->pool->getConnection();

        $sql = "select * from `activity_idioms` where good_id= :gid and nick is NULL  order by `order` ASC limit 1";
        $row = $db->prepare($sql)->bindParams([
            'gid' => $goodId,
        ])->queryOne();

        return $row;
    }

    public function update(array $row) {
        $db = $this->pool->getConnection();
        // $result = $db->update('activity_idioms', $row, ['id'=>$row['id']]);
        $result = $db->update('activity_idioms', $row, ['id', "=", $row['id']])->execute();
        // echo "\n update row effect : " .$result->row. "\n";
    }

}
