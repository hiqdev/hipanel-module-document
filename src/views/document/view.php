<?php

/**
 * @var \hipanel\modules\document\models\Document
 * @var \hipanel\modules\document\models\Document[] $models
 * @var array $types
 * @var array $states
 */
use hipanel\modules\document\grid\DocumentGridView;
use hipanel\modules\document\menus\DocumentDetailMenu;
use hipanel\widgets\Box;
use yii\helpers\Html;

$this->title = Html::encode($model->getDisplayTitle());
$this->params['subtitle'] = Yii::t('hipanel:document', 'Document detailed information');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:document', 'Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-md-3">
        <?php Box::begin([
            'options' => ['class' => 'box-solid'],
            'bodyOptions' => ['class' => 'no-padding'],
        ]) ?>
        <div class="profile-user-img text-center">
            <?= \hipanel\widgets\FileRender::widget([
                'file' => $model->file,
                'thumbWidth' => 200,
                'thumbHeight' => 200,
                'iconOptions' => [
                    'class' => 'fa-5x',
                ],
                'lightboxLinkOptions' => [
                    'data-lightbox' => 'files-' . $model->file->id,
                ],
            ]) ?>
        </div>
        <p class="text-center">
            <span class="profile-user-name"><?= $this->title ?></span>
        </p>
        <div class="profile-usermenu">
            <?= DocumentDetailMenu::widget(['model' => $model]) ?>
        </div>
        <?php Box::end() ?>
    </div>

    <div class="col-md-6">
        <?php $box = Box::begin([
            'renderBody' => false,
            'title' => Yii::t('hipanel:document', 'Document information'),
        ]) ?>
        <?php $box->beginBody() ?>
        <?= DocumentGridView::detailView([
            'boxed' => false,
            'model' => $model,
            'columns' => [
                'seller_id', 'client_id',
                'object', 'filename',
                'size', 'type', 'statuses',
                'create_time', 'validity',
                'description',
            ],
        ]) ?>
        <?php $box->endBody() ?>
        <?php $box->end() ?>

    </div>
</div>
