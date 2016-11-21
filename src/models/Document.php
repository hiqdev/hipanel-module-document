<?php

namespace hipanel\modules\document;

class Document extends \hipanel\base\Model
{
    public static $i18nDictionary = 'hipanel:document';

    public function rules()
    {
        return [
            [['file_id', 'type_id', 'state_id', 'object_id', 'client_id', 'seller_id'], 'integer'],
            [['client', 'seller', 'title', 'description'], 'safe'],
            [['create_time', 'update_time'], 'datetime'],
        ];
    }
}
