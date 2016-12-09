<?php

/**
 * @var \hipanel\modules\document\models\Document $model
 * @var \hipanel\modules\document\models\Document[] $models
 * @var array $types
 * @var array $states
 */

use hipanel\modules\document\menus\DocumentDetailMenu;
use hipanel\widgets\Box;
use hiqdev\menumanager\widgets\DetailMenu;
use yii\helpers\Html;

$this->title = Html::encode($model->title ?: Yii::t('hipanel:document', 'Untitled document'));
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
        <div class="profile-usermenu">
            <?= DocumentDetailMenu::create(['model' => $model])->render(DetailMenu::class) ?>
        </div>
        <?php Box::end() ?>
    </div>

    <div class="col-md-6">
        <?php $box = Box::begin([
            'renderBody' => false,
            'title' => Yii::t('hipanel:document', 'Document information'),
        ]) ?>
            <?php $box->beginBody() ?>
                <?= \hipanel\modules\document\grid\DocumentGridView::detailView([
                    'boxed'   => false,
                    'model'   => $model,
                    'columns' => [
                        'seller_id',
                        'client_id',
                        'filename',
                        'size',
                        'type',
                        'statuses',
                        'create_time',
                        'validity',
                        'description',
                    ],
                ]) ?>
            <?php $box->endBody() ?>
        <?php $box->end() ?>

    </div>
</div>
