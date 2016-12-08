<?php

namespace hipanel\modules\document\models;

use hipanel\base\ModelTrait;

class Object extends \hipanel\base\Model
{
    use ModelTrait;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'class_name'], 'safe']
        ];
    }
}
