<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\client\widgets\combo\ContactCombo;
use hipanel\modules\client\widgets\combo\SellerCombo;
use hiqdev\yii2\daterangepicker\DateRangePicker;
use hiqdev\combo\StaticCombo;
use yii\helpers\Html;

/**
 * @var \hipanel\widgets\AdvancedSearch $search
 * @var array $states
 * @var array $types
 */
?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('number_ilike') ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('title_ilike') ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('type_in')->widget(StaticCombo::class, [
        'data'      => $types,
        'hasId'     => true,
        'multiple'  => true,
    ]) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('state_in')->widget(StaticCombo::class, [
        'data'      => $states,
        'hasId'     => true,
        'multiple'  => true,
    ]) ?>
</div>

<?php if (Yii::$app->user->can('support')) {
        ?>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('client_id')->widget(ClientCombo::class) ?>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('seller_id')->widget(SellerCombo::class) ?>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('sender_id')->widget(ContactCombo::class) ?>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('receiver_id')->widget(ContactCombo::class) ?>
    </div>
<?php
    } ?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <div class="form-group">
        <?= Html::tag('label', Yii::t('hipanel:document', 'Creation date'), ['class' => 'control-label']); ?>
        <?= DateRangePicker::widget([
            'model' => $search->model,
            'attribute' => 'create_time_ge',
            'attribute2' => 'create_time_le',
            'options' => [
                'class' => 'form-control',
            ],
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>
    </div>
</div>
