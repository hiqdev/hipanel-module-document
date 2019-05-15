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

use hipanel\grid\BoxedGridView;
use hipanel\grid\RefColumn;
use hipanel\modules\client\menus\ClientActionsMenu;
use hipanel\modules\document\widgets\DocumentRelationWidget;
use hipanel\modules\document\widgets\DocumentState;
use hipanel\modules\document\widgets\DocumentStatuses;
use hipanel\modules\document\widgets\DocumentStatusIcons;
use hipanel\modules\document\widgets\DocumentType;
use hipanel\modules\document\widgets\ValidityWidget;
use hiqdev\yii2\menus\grid\MenuColumn;
use Yii;
use yii\helpers\Html;

/**
 * Class DocumentGridView.
 */
class DocumentGridView extends BoxedGridView
{
    /**
     * {@inheritdoc}
     */
    public function columns()
    {
        return array_merge(parent::columns(), [
            'title' => [
                'format' => 'raw',
                'filterAttribute' => 'title_ilike',
                'value' => function ($model) {
                    return implode(' ', [
                        DocumentType::widget(['model' => $model]),
                        Html::a($model->getDisplayTitle(), ['@document/view', 'id' => $model->id]),
                    ]);
                },
            ],
            'state' => [
                'class' => RefColumn::class,
                'filterAttribute' => 'state_in',
                'format' => 'raw',
                'gtype' => 'state,document',
                'i18nDictionary' => 'hipanel:document',
                'value' => function ($model) {
                    return DocumentState::widget(['model' => $model]);
                },
            ],
            'type' => [
                'class' => RefColumn::class,
                'filterAttribute' => 'type_in',
                'format' => 'raw',
                'gtype' => 'type,document',
                'i18nDictionary' => 'hipanel:document',
                'value' => function ($model) {
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
                },
            ],
            'filename' => [
                'attribute' => 'file.filename',
                'label' => Yii::t('hipanel:document', 'Filename'),
            ],
            'create_time' => [
                'attribute' => 'file.create_time',
                'label' => Yii::t('hipanel:document', 'Create time'),
                'format' => 'datetime',
            ],
            'validity' => [
                'label' => Yii::t('hipanel:document', 'Validity'),
                'format' => 'raw',
                'value' => function ($model) {
                    return ValidityWidget::widget(['model' => $model]);
                },
            ],
            'statuses' => [
                'label' => Yii::t('hipanel:document', 'Statuses'),
                'format' => 'raw',
                'value' => function ($model) {
                    return DocumentStatuses::widget(['model' => $model]);
                },
            ],
            'sender' => [
                'filterAttribute' => 'sender_ilike',
                'label' => Yii::t('hipanel:document', 'Sender'),
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a($model->sender, ['@contact/view', 'id' => $model->sender_id]);
                },
            ],
            'receiver' => [
                'filterAttribute' => 'receiver_ilike',
                'label' => Yii::t('hipanel:document', 'Receiver'),
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a($model->receiver, ['@contact/view', 'id' => $model->receiver_id]);
                },
            ],
            'object' => [
                'label' => Yii::t('hipanel:document', 'Related object'),
                'format' => 'raw',
                'value' => function ($model) {
                    return DocumentRelationWidget::widget(['model' => $model->object]);
                },
            ],
            'status_and_type' => [
                'label' => Yii::t('hipanel:document', 'Statuses'),
                'format' => 'raw',
                'value' => function ($model) {
                    return DocumentState::widget(['model' => $model]) . ' ' . DocumentStatusIcons::widget(['model' => $model]);
                },
            ],
        ]);
    }
}
