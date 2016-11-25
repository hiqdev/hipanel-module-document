<?php

namespace hipanel\modules\document\models\query;

use hiqdev\hiart\ActiveQuery;

class DocumentQuery extends ActiveQuery
{
    public function details()
    {
        $this->joinWith('file');
        $this->joinWith('object');

        return $this;
    }

    public function id($id)
    {
        return $this->andWhere(['id' => $id]);
    }
}
