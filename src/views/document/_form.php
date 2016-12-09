<?php

/**
 * @var hipanel\modules\document\models\Document $model
 * @var array $types
 * @var array $statuses
 */

use hipanel\helpers\Url;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\widgets\Box;
use hipanel\widgets\DatePicker;
use hipanel\widgets\FileInput;
use hiqdev\combo\StaticCombo;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div>
    <?php if (!$model->isNewRecord): ?>
        <div class="col-md-3">
            <?php Box::begin([
                'options' => ['class' => 'box-solid'],
            ]) ?>
            <div class="text-center">
                <?= \hipanel\widgets\FileRender::widget([
                    'file' => $model->file,
                    'thumbWidth' => 200,
                    'thumbHeight' => 200,
                    'lightboxLinkOptions' => [
                        'data-lightbox' => 'files-' . $model->file->id,
                    ],
                ]) ?>
            </div>
            <?php Box::end() ?>
        </div>
    <?php endif ?>

    <div class="col-md-6">
        <?php Box::begin(); ?>
        <?php $form = ActiveForm::begin([
            'id' => 'document-form',
            'enableAjaxValidation' => true,
            'validationUrl' => Url::toRoute(['validate-single-form', 'scenario' => $model->scenario]),
            'options' => ['enctype' => 'multipart/form-data'],
        ]);

        echo $form->field($model, 'id')->hiddenInput()->label(false);
        if (Yii::$app->user->can('document.manage')) {
            echo $form->field($model, 'client')->widget(ClientCombo::class, [
                'inputOptions' => [
                    'readonly' => !$model->isNewRecord,
                ],
            ]);
        }
        echo $form->field($model, 'title');
        echo $form->field($model, 'description')->textarea(['rows' => 3]);
        echo $form->field($model, 'type')->widget(StaticCombo::class, [
            'data' => $types,
            'hasId' => true,
        ]);
        if (Yii::$app->user->can('document.manage')) {
            $model->status_types = is_array($model->status_types) ? implode(',', $model->status_types) : $model->status_types;
            echo $form->field($model, 'status_types')->widget(StaticCombo::class, [
                'data' => $statuses,
                'hasId' => true,
                'multiple' => true,
            ]);
        } ?>
        <?php if (Yii::$app->user->can('document.manage')): ?>
            <div class="row">
                <div class="col-md-6">
                    <?php
                    if ($model->isNewRecord && empty($model->validity_start)) {
                        $model->validity_start = Yii::$app->formatter->asDate(time(), 'php:Y-m-d');
                    } elseif (!empty($model->validity_start)) {
                        $model->validity_start = Yii::$app->formatter->asDate($model->validity_start, 'php:Y-m-d');
                    }

                    echo $form->field($model, 'validity_start', [
                        'enableClientValidation' => false,
                    ])->widget(DatePicker::class, [
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'validity_end', [
                        'enableClientValidation' => false,
                    ])->widget(DatePicker::class, [
                        'options' => [
                            'value' => !empty($model->validity_end)
                                ? Yii::$app->formatter->asDate($model->validity_end, 'php:Y-m-d')
                                : null,
                        ],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                        ],
                    ]); ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($model->isNewRecord) {
            echo $form->field($model, 'attachment')->widget(FileInput::class, [
                'pluginOptions' => [
                    'previewFileType' => 'any',
                    'showRemove' => true,
                    'showUpload' => false,
                    'initialPreviewShowDelete' => true,
                ],
            ]);
        } ?>

        <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']); ?>

        <?= Html::submitButton(Yii::t('hipanel', 'Cancel'),
            ['class' => 'btn btn-default', 'onclick' => 'window.history.back();']); ?>

        <?php $form->end(); ?>
        <?php Box::end(); ?>
    </div>
</div>
