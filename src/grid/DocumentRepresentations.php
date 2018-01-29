<?php

namespace hipanel\modules\document\grid;

use hiqdev\higrid\representations\RepresentationCollection;
use Yii;

class DocumentRepresentations extends RepresentationCollection
{
    protected function fillRepresentations()
    {
        $this->representations = array_filter([
            'common' => [
                'label' => Yii::t('hipanel', 'common'),
                'columns' => [
                    'checkbox',
                    'seller',
                    'client_like',
                    'title',
                    'status_and_type',
                    'object',
                    'create_time',
                ],
            ],
        ]);
    }
}
