<?php

/**
 * @var \hipanel\modules\document\forms\DocumentForm $documentForm
 * @var array $types
 * @var array $states
 * @var array $statuses
 */

$this->title = Yii::t('hipanel', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:document', 'Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_form', compact('documentForm', 'types', 'states', 'statuses')) ?>
