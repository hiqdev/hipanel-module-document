<?php

/*
 * HiPanel core package
 *
 * @link      https://hipanel.com/
 * @package   hipanel-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\document\models;

use hipanel\base\ModelTrait;

class Status extends \hipanel\base\Model
{
    use ModelTrait;

    public function rules()
    {
        return [
            [['object_id', 'assigned_by_id', 'type_id'], 'integer'],
            [['type', 'type_label', 'assigned_by', 'time'], 'safe'],
        ];
    }
}
