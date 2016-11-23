<?php

/**
 * @var \hipanel\modules\document\models\Document $model
 * @var array $types
 */

$this->title = Yii::t('hipanel', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:document', 'Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_form', compact('model', 'types', 'states')) ?>
