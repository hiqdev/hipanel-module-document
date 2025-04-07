<?php

/**
 * @var hipanel\modules\document\models\Document $model
 * @var array $types
 * @var array $statuses
 * @var array $states
 * @var string $boxWidth
 */

use hipanel\helpers\Url;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\finance\widgets\combo\RequisitesCombo;
use hipanel\modules\document\models\Document;
use hipanel\modules\document\widgets\combo\ContactIndependentCombo;
use hipanel\widgets\Box;
use hipanel\widgets\combo\ObjectCombo;
use hipanel\widgets\DatePicker;
use hipanel\widgets\FileInput;
use hipanel\widgets\FileRender;
use hiqdev\combo\StaticCombo;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php if (!$model->isNewRecord): ?>
    <div class="col-md-3">
        <?php Box::begin([
            'options' => ['class' => 'box-solid'],
        ]) ?>
        <div class="text-center">
            <?= FileRender::widget([
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

<div class="col-md-<?= $boxWidth ?>">
    <?php Box::begin(); ?>
    <?php $form = ActiveForm::begin([
        'id' => 'document-form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::toRoute([
            'validate-single-form',
            'scenario' => $model->scenario,
        ]),
        'options' => ['enctype' => 'multipart/form-data'],
    ]) ?>

    <?php if ($model->scenario === Document::SCENARIO_UPDATE): ?>
        <?= Html::activeHiddenInput($model, 'file_id') ?>
    <?php endif ?>

    <?= Html::activeHiddenInput($model, 'id') ?>

    <?php if (Yii::$app->user->can('document.update')): ?>
        <?= $form->field($model, 'client')->widget(ClientCombo::class, [
            'type' => 'main/client',
            'inputOptions' => [
                'readonly' => !$model->isNewRecord,
            ],
        ]) ?>
    <?php endif ?>
    <?= $form->field($model, 'title') ?>
    <?php if (Yii::$app->user->can('support')): ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'sender_id')->widget(ContactIndependentCombo::class, ['type' => 'sender/contact']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'receiver_id')->widget(ContactIndependentCombo::class, ['type' => 'receiver/contact']) ?>
            </div>
        </div>
    <?php else : ?>
        <?= $form->field($model, 'sender_id')->hiddenInput()->label(false) ?>
    <?php endif ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>
    <?php if (Yii::$app->user->can('support')): ?>
        <?= $form->field($model, 'type')->widget(StaticCombo::class, [
            'data' => $types,
            'hasId' => true,
        ]) ?>
        <?= $form->field($model, 'object_id')->widget(ObjectCombo::class, [
            'class_attribute_name' => 'class',
        ]) ?>
    <?php endif ?>
    <?php if (Yii::$app->user->can('requisites.read')): ?>
        <?= $form->field($model, 'requisite_id')->widget(RequisitesCombo::class) ?>
    <?php endif ?>
    <?php if (Yii::$app->user->can('document.update')): ?>
        <?= $form->field($model, 'status_types')->widget(StaticCombo::class, [
            'data' => $statuses,
            'hasId' => true,
            'multiple' => true,
        ]) ?>
    <?php endif ?>
    <?php if (Yii::$app->user->can('document.update')): ?>
        <div class="row">
            <div class="col-md-6">
                <?php if ($model->isNewRecord && empty($model->validity_start)): ?>
                    <?php $model->validity_start = Yii::$app->formatter->asDate(time(), 'php:Y-m-d') ?>
                <?php elseif (!empty($model->validity_start)): ?>
                    <?php $model->validity_start = Yii::$app->formatter->asDate($model->validity_start, 'php:Y-m-d') ?>
                <?php endif ?>

                <?= $form->field($model, 'validity_start', [
                    'enableClientValidation' => false,
                ])->widget(DatePicker::class) ?>
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
                ]) ?>
            </div>
        </div>
    <?php endif ?>
    <?php if ($model->isNewRecord): ?>
        <?= $form->field($model, 'attachment')->widget(FileInput::class) ?>
    <?php endif ?>

    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']); ?>
    &nbsp;
    <?= Html::submitButton(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'window.history.back();']); ?>

    <?php $form->end(); ?>
    <?php Box::end(); ?>
</div>
