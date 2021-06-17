<?php
/**
 * Documents module for HiPanel
 *
 * @link      https://hipanel.com/
 * @package   hipanel-module-document
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2018, HiQDev (http://hiqdev.com/)
 */

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
                    'number_and_time',
                    'title',
                    'status',
                    'sender',
                    'receiver',
                    'requisite',
                    'object',
                ],
            ],
        ]);
    }
}
