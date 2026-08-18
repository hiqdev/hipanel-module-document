<?php

/**
 * @var \yii\web\View $this
 * @var \hipanel\modules\document\models\Document $model
 * @var \hipanel\modules\document\models\Document[] $models
 * @var array $types
 * @var array $states
 * @var array $fileHistory
 */
use hipanel\modules\document\grid\DocumentGridView;
use hipanel\modules\document\menus\DocumentDetailMenu;
use hipanel\modules\finance\grid\ChargeGridView;
use hipanel\widgets\AuditButton;
use hipanel\widgets\Box;
use yii\data\ArrayDataProvider;
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
            <?= AuditButton::widget(['model' => $model, 'linkOptions' => ['class' => 'list-group-item']]) ?>
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

        <?php if (Yii::$app->user->can('document.see-history') && !empty($fileHistory)): ?>
            <?php $box = Box::begin([
                'renderBody' => false,
                'title' => Yii::t('hipanel:document', 'File replacement history'),
            ]) ?>
            <?php $box->beginBody() ?>
            <table class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th><?= Yii::t('hipanel:document', 'File') ?></th>
                        <th><?= Yii::t('hipanel:document', 'Size') ?></th>
                        <th><?= Yii::t('hipanel:document', 'Valid till') ?></th>
                        <th><?= Yii::t('hipanel:document', 'Replaced by') ?></th>
                        <th><?= Yii::t('hipanel:document', 'Reason') ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fileHistory as $entry): ?>
                    <tr>
                        <td><?= Html::encode($entry['filename']) ?></td>
                        <td><?= Yii::$app->formatter->asShortSize($entry['size']) ?></td>
                        <td><?= Yii::$app->formatter->asDatetime($entry['replaced_at']) ?></td>
                        <td><?= Html::encode($entry['client']) ?></td>
                        <td><?= Html::encode($entry['reason']) ?></td>
                        <td><?= Html::a(
                            Html::tag('i', '', ['class' => 'fa fa-download']) . ' ' . Yii::t('hipanel:document', 'Download'),
                            ['/file/get', 'id' => $entry['file_id']],
                            ['class' => 'btn btn-xs btn-default']
                        ) ?></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <?php $box->endBody() ?>
            <?php $box->end() ?>
        <?php endif ?>
    </div>

</div>

<?php $charges = $model->chargeModels; ?>
<?php if (Yii::$app->user->can('bill.charges.read') && !empty($charges)): ?>
<?php
$totals = [];
foreach ($charges as $charge) {
    $currency = $charge->currency;
    $totals[$currency] = bcadd($totals[$currency] ?? '0', (string)$charge->sum, 4);
}
?>
<div class="row">
    <div class="col-md-12">
        <?php $box = Box::begin(['renderBody' => false, 'title' => Yii::t('hipanel:document', 'Charges')]) ?>
        <?php $box->beginHeader() ?>
        <div class="pull-right">
            <?= Yii::t('hipanel:document', 'Total') ?>:
            <?php foreach ($totals as $currency => $total): ?>
                <strong><?= Yii::$app->formatter->asCurrency($total, $currency) ?></strong>
            <?php endforeach ?>
            <small class="text-muted" style="margin-left:4px">(<?= Yii::t('hipanel:document', 'excl. VAT') ?>)</small>
            <?= Html::a(
                Html::tag('i', '', ['class' => 'fa fa-list']) . ' ' . Yii::t('hipanel:document', 'All charges'),
                ['@charge/index', 'ChargeSearch[document_ids]' => $model->id],
                ['class' => 'btn btn-xs btn-default', 'style' => 'margin-left:8px']
            ) ?>
        </div>
        <?php $box->endHeader() ?>
        <?php $box->beginBody() ?>
        <?= ChargeGridView::widget([
            'dataProvider' => new ArrayDataProvider(['allModels' => $charges, 'pagination' => false]),
            'boxed' => false,
            'layout' => '{items}',
            'columns' => [
                'id',
                'bill_id',
                'type_label',
                'name',
                'sum',
                'quantity',
                'is_payed',
                'time',
                'included_in_documents',
            ],
        ]) ?>
        <?php $box->endBody() ?>
        <?php $box->beginFooter() ?>
        <div class="pull-right">
            <?= Yii::t('hipanel:document', 'Total') ?>:
            <?php foreach ($totals as $currency => $total): ?>
                <strong><?= Yii::$app->formatter->asCurrency($total, $currency) ?></strong>
            <?php endforeach ?>
            <small class="text-muted" style="margin-left:4px">(<?= Yii::t('hipanel:document', 'excl. VAT') ?>)</small>
        </div>
        <?php $box->endFooter() ?>
        <?php Box::end() ?>
    </div>
</div>
<?php endif ?>
