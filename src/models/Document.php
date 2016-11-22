<?php

namespace hipanel\modules\document\models;

use hipanel\base\ModelTrait;

/**
 * Class Document represents document
 *
 * @package hipanel\modules\document\models
 */
class Document extends \hipanel\base\Model
{
    use ModelTrait;

    /**
     * @inheritdoc
     */
    public static $i18nDictionary = 'hipanel:document';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'state_id', 'object_id', 'client_id', 'seller_id'], 'integer'],
            [['client', 'seller', 'title', 'description'], 'safe'],
            [['create_time', 'update_time'], 'datetime'],
            [['type', 'state'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([

        ]);
    }
}
