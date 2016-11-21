<?php

/**
 * @var \hipanel\modules\document\Document $model
 * @var \hipanel\modules\document\Document[] $models
 */

$this->title = $model->title;
$this->params['subtitle'] = Yii::t('hipanel:document', 'Document detailed information');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:document', 'Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">

</div>
