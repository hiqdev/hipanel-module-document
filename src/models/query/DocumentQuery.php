<?php

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
        return $this->andWhere(['state' => ['ok', 'outdated', 'deleted']]);
    }

    public function id($id)
    {
        return $this->andWhere(['id' => $id]);
    }
}
