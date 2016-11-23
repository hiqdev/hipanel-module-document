<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\document\grid;

use hipanel\modules\document\widgets\DocumentType;
use hipanel\modules\document\widgets\DocumentState;
use hiqdev\menumanager\MenuColumn;
use hipanel\grid\BoxedGridView;
use hipanel\grid\RefColumn;
use hipanel\modules\client\menus\ClientActionsMenu;
use Yii;
use yii\helpers\Html;

/**
 * Class DocumentGridView
 * @package hipanel\modules\document\grid
 */
class DocumentGridView extends BoxedGridView
{
    /**
     * @inheritdoc
     */
    public static function defaultColumns()
    {
        return [
            'title' => [
                'format' => 'raw',
                'filterAttribute' => 'title_ilike',
                'value' => function ($model) {
                    return Html::a($model->title, ['@document/view', 'id' => $model->id]);
                }
            ],
            'state' => [
                'class'  => RefColumn::class,
                'filterAttribute' => 'state_in',
                'format' => 'raw',
                'gtype'  => 'state,document',
                'i18nDictionary' => 'hipanel:document',
                'value'  => function ($model) {
                    return DocumentState::widget(['model' => $model]);
                },
            ],
            'type' => [
                'class'  => RefColumn::class,
                'filterAttribute' => 'type_in',
                'format' => 'raw',
                'gtype'  => 'type,document',
                'i18nDictionary' => 'hipanel:document',
                'value'  => function ($model) {
                    return DocumentType::widget(['model' => $model]);
                },
            ],
            'actions' => [
                'class' => MenuColumn::class,
                'menuClass' => ClientActionsMenu::class,
            ],
            'size' => [
                'label' => Yii::t('hipanel:document', 'Size'),
                'value' => function ($model) {
                    return Yii::$app->formatter->asShortSize($model->file->size, 1);
                }
            ],
            'filename' => [
                'attribute' => 'file.filename',
                'label' => Yii::t('hipanel:document', 'Filename'),
            ],
            'create_time' => [
                'attribute' => 'file.create_time',
                'label' => Yii::t('hipanel:document', 'Create time'),
                'format' => 'datetime',
            ]
        ];
    }
}
