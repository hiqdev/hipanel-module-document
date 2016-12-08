<?php

/**
 * @var hipanel\modules\document\models\Document $model
 * @var DocumentForm $documentForm
 * @var array $types
 * @var array $statuses
 */

use hipanel\helpers\Url;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\document\forms\DocumentForm;
use hipanel\widgets\Box;
use hipanel\widgets\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div>
    <?php if ($documentForm->scenario !== DocumentForm::SCENARIO_CREATE): ?>
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
            'validationUrl' => Url::toRoute(['validate-single-form', 'scenario' => $documentForm->scenario]),
            'options' => ['enctype' => 'multipart/form-data'],
        ]);

        echo $form->field($documentForm, 'id')->hiddenInput()->label(false);
        if (Yii::$app->user->can('manage')) {
            echo $form->field($documentForm, 'client')->widget(ClientCombo::class);
        }
        echo $form->field($documentForm, 'title');
        echo $form->field($documentForm, 'description')->textarea(['rows' => 3]);
        echo $form->field($documentForm, 'type')->widget(\hiqdev\combo\StaticCombo::class, [
            'data' => $types,
            'hasId' => true,
        ]);
        if (Yii::$app->user->can('manage')) {
            echo $form->field($documentForm, 'statuses')->widget(\hiqdev\combo\StaticCombo::class, [
                'data' => $statuses,
                'hasId' => true,
                'multiple' => true,
            ]);
        } ?>
        <?php if (Yii::$app->user->can('document.manage')): ?>
            <div class="row">
                <div class="col-md-6">
                    <?php
                    if ($documentForm->scenario === DocumentForm::SCENARIO_CREATE && empty($documentForm->validity_start)) {
                        $documentForm->validity_start = Yii::$app->formatter->asDate(time(), 'php:Y-m-d');
                    } elseif (!empty($documentForm->validity_start)) {
                        $documentForm->validity_start = Yii::$app->formatter->asDate($documentForm->validity_start,
                            'php:Y-m-d');
                    }

                    echo $form->field($documentForm, 'validity_start')->widget(\hipanel\widgets\DatePicker::class, [
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($documentForm, 'validity_end')->widget(\hipanel\widgets\DatePicker::class, [
                        'options' => [
                            'value' => !empty($documentForm->validity_end)
                                ? Yii::$app->formatter->asDate($documentForm->validity_end, 'php:Y-m-d')
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
        <?php if ($documentForm->scenario === DocumentForm::SCENARIO_CREATE) {
            echo $form->field($documentForm, 'attachment')->widget(FileInput::class, [
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
