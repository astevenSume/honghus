<?php

namespace App\Api\Forms;

use Mix\Validate\Validator;

/**
 * Class GoodsForm
 * @package App\Api\Forms
 * @author liu,jian <coder.keda@gmail.com>
 */
class GoodsForm extends Validator
{

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $image;

    /**
     * @var string
     */
    public $price;

    /**
     * @var string
     */
    public $bio;
    
    /**
     * @var int
     */
    public $sales;

    public $lefts;
    public $typ;

    /**
     * @var string
     */
    public $end_time;
    public $get_good_time;

    /**
     * @var int
     */
    public $high_level;

    /**
     * @var string
     */
    public $desc_sale;
    public $unit;

    /**
     * @var int
     */
    public $unit_nums;

    /**
     * @var string
     */
    public $get_good_addr;
    public $created_at;

    /**
     * 规则
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => ['string', 'maxLength' => 25, 'filter' => ['trim']],
            'high_level'   => ['integer', 'unsigned' => true, 'min' => 0, 'max' => 1],
            'price' => ['double'],
            'bio' => ['string'],
            'sales' => ['integer'],
            'lefts' => ['integer'],
            'typ' => ['integer'],
            'high_level' => ['integer'],
            'desc_sale' => ['string'],
            'unit'=>['string'],
            'unit_nums'=>['integer', 'unsigned'],
            'get_goods_addr'=> ['string'],
            'created_at'=> ['string'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'create' => ['required' => ['name'], 'optional' => ['price', 'bio', 'sales', 'lefts', 'typ', 'high_level', 'desc_sale', 'unit', 'unit_nums', 'get_goods_addr', 'created_at']],
        ];
    }

    /**
     * 消息
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'  => '名称不能为空.',
            // 'price.float64'    => '价格不能为负数',
        ];
    }
}
