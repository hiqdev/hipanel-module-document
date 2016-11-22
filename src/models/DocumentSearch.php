<?php

namespace hipanel\modules\document\models;

use hipanel\base\SearchModelTrait;
use Yii;

class DocumentSearch extends Document
{
    use SearchModelTrait;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'type_in' => Yii::t('hipanel', 'Type'),
            'state_in' => Yii::t('hipanel', 'State'),
        ]);
    }
}
