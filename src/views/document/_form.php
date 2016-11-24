<?php

/**
 * @var hipanel\modules\document\models\Document $model
 * @var array $types
 * @var array $states
 */

use hipanel\helpers\Url;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\widgets\Box;
use hipanel\widgets\FileInput;
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
            'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
            'options' => ['enctype' => 'multipart/form-data'],
        ]);

        echo $form->field($model, 'id')->hiddenInput()->label(false);
        echo $form->field($model, 'title');
        echo $form->field($model, 'description')->textarea(['rows' => 3]);
        echo $form->field($model, 'type')->widget(\hiqdev\combo\StaticCombo::class, [
            'data' => $types,
            'hasId' => true,
        ]);
        if (Yii::$app->user->can('manage')) {
            echo $form->field($model, 'state')->widget(\hiqdev\combo\StaticCombo::class, [
                'data' => $states,
                'hasId' => true,
            ]);
        }
        if ($model->isNewRecord) {
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
