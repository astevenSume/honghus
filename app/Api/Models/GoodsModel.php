<?php

namespace App\Api\Models;

use App\Api\Forms\GoodsForm;
use Mix\Database\Pool\ConnectionPool;

/**
 * Class GoodsModel
 * @package App\Api\Models
 * @author liu,jian <coder.keda@gmail.com>
 */
class GoodsModel
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
     * 查询商品
     * @return GoodsForm $form
     */
    public function one(int $id) {
        $db = $this->pool->getConnection();

        $sql = "SELECT * FROM `goods` WHERE id = :id";
        $rows = $db->prepare($sql)->bindParams([
            'id'  => $id,
        ])->queryOne();

        return $rows;
    }


    /**
     * 新增商品
     * @param UserForm $model
     * @return bool|string
     */
    public function add(GoodsForm $form)
    {

        $date = date('Y-m-d H:i:s');
        $time = strtotime($date);
        $endTime = date('Y-m-d H:i:s' ,$time + 3600*24*3);
        $getGoodTime = date('Y-m-d H:i:s' ,$time+3600*24);

        $db       = $this->pool->getConnection();
        $status   = $db->insert('goods', [
            'name'  => $form->name,
            'price'   => $form->price,
            'bio' => $form->bio,
            'sales' => $form->sales,
            'lefts' => $form->lefts,
            'typ' => $form->typ,
            'high_level' => $form->high_level,
            'desc_sale' => $form->desc_sale,
            'unit' => $form->unit,
            'unit_nums'=> $form->unit_nums,
            'get_goods_addr'=>$form->get_goods_addr,
            'end_time'=> $endTime,
            'get_good_time'=> $getGoodTime,
            'created_at'=>$date,
        ])->execute();
        $insertId = $status ? $db->getLastInsertId() : false;
        $db->release();
        return $insertId;
    }
}
