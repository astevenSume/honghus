<?php

namespace App\Api\Models;

use App\Api\Forms\CyForm;
use Mix\Database\Pool\ConnectionPool;

/**
 * Class CyModel
 * @package App\Api\Models
 * @author liu,jian <coder.keda@gmail.com>
 */
class CyModel
{

    /**
     * @var ConnectionPool
     */
    public $pool;

    /**
     * UserModel constructor.
     */
    public function __construct()
    {
        $this->pool = context()->get('dbPool');
    }

    /**
     * 
     * @return CyForm $form
     */
    public function randGetOne() {
        $db = $this->pool->getConnection();

        $id = rand(1, 100);
        $sql = "select name from `cy` where id = :id";
        $row = $db->prepare($sql)->bindParams([
            'id' => $id,
        ])->queryOne();

        return $row;
    }

    /**
     * 
     * @return string $nextIdiom
     */
    public function findByWordSOrderFirst(string $word){
        $db = $this->pool->getConnection();

        $sql = "select name from `cy` where `wordS`=:word order by id asc";
        $row = $db->prepare($sql)->bindParams([
            'word' => $word,
        ])->queryOne();

        return $row['name'];
    }

    /**
     * 
     * @return string $nextIdiom
     */
    public function findRandIdiomByWordS(string $word){
        $db = $this->pool->getConnection();

        $sql = "select name from `cy` where `wordS`=:word";
        $row = $db->prepare($sql)->bindParams([
            'word' => $word,
        ])->queryAll();

        // echo "\n ".$word. "................. has [".count($row)."] idioms may choose..............\n";
        $r = 0;
        if (count($row) > 0) {
            $r = rand(0, count($row)-1);
        } else {
            return "";
        }

        return $row[$r]['name'];
    }

}
