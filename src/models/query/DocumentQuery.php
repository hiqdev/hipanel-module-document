<?php
/**
 * Documents module for HiPanel
 *
 * @link      https://hipanel.com/
 * @package   hipanel-module-document
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\document\models\query;

use hiqdev\hiart\ActiveQuery;

class DocumentQuery extends ActiveQuery
{
    public function details()
    {
        $this->joinWith('file');
        $this->joinWith('object');
        $this->joinWith('statuses');

        return $this;
    }

    public function showDeleted()
    {
        return $this->andWhere(['state_in' => ['ok', 'outdated', 'deleted']]);
    }

    public function id($id)
    {
        return $this->andWhere(['id' => $id]);
    }
}
