<?php

/**
 * @var \hipanel\modules\document\models\Document
 * @var array $types
 * @var array $states
 * @var array $statuses
 */
$this->title = Yii::t('hipanel', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:document', 'Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_form', compact('model', 'types', 'states', 'statuses')) ?>
