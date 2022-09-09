<?php

namespace App\Api\Forms;

use Mix\Validate\Validator;

/**
 * Class ActivityIdioms
 * @package App\Api\Forms
 * @author liu,jian <coder.keda@gmail.com>
 */
class ActivityIdiomsForm extends Validator
{

    /**
     * @var string
     */
    public $word;
    public $nick;
    public $buy_at;

    /**
     * @var int
     */
    public $act_id;
    public $order;
    public $good_id;


    /**
     * 规则
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'create' => [],
        ];
    }

    /**
     * 消息
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
