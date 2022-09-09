<?php

namespace App\Api\Forms;

use Mix\Validate\Validator;

/**
 * Class CyForm
 * @package App\Api\Forms
 * @author liu,jian <coder.keda@gmail.com>
 */
class CyForm extends Validator
{

    /**
     * @var string
     */
    public $wordE;
    public $wordS;
    public $name;
    public $spell;
    public $content;
    public $derivation;
    public $samples;
    public $pyE;
    public $pyS;


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
