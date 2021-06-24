<?php

use hipanel\modules\document\grid\DocumentGridView;
use hipanel\widgets\IndexPage;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\data\ActiveDataProvider
 * @var \hipanel\modules\document\models\Document $model
 * @var \hipanel\modules\document\models\Document[] $models
 * @var array $types
 * @var array $states
 * @var array $statuses
 */
$this->title = Yii::t('hipanel:document', 'Documents');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

    <?= $page->setSearchFormData(compact(['types', 'states', 'statuses'])) ?>

    <?php $page->beginContent('main-actions') ?>
        <?php $couldGetArchive = array_filter(Yii::$app->request->get($model->formName(), [])) ?>
        <?= Html::a(Yii::t('hipanel:document', 'Create document'), 'create', ['class' => 'btn btn-sm btn-success']) ?>
            <?= Html::a(Yii::t('hipanel:document', 'Get documents as compressed file'), Url::to(array_merge(['archive'], Yii::$app->request->get())), array_filter([
                'class' => 'btn btn-sm btn-success',
                'disabled' => !$couldGetArchive,
                'onClick' => !$couldGetArchive ? "return false;" : null,
            ])) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('sorter-actions') ?>
        <?= $page->renderSorter([
            'attributes' => [
                'title',
                'type',
                'state',
                'client',
                'seller',
                'create_time',
            ],
        ]) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('table') ?>
        <?php $page->beginBulkForm() ?>
            <?= DocumentGridView::widget([
                'boxed' => false,
                'dataProvider' => $dataProvider,
                'filterModel'  => $model,
                'columns' => $representationCollection->getByName($uiModel->representation)->getColumns(),
            ]) ?>
        <?php $page->endBulkForm() ?>
    <?php $page->endContent() ?>

<?php $page->end() ?>
