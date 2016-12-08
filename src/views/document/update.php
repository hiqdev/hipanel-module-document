<?php

use yii\helpers\Html;

/**
 * @var \hipanel\modules\document\models\Document $model
 * @var \hipanel\modules\document\models\Document[] $models
 * @var array $types
 * @var array $states
 * @var array $statuses
 */

$this->title = Yii::t('hipanel', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:document', 'Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['@document/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>


<?= $this->render('_form', compact('model', 'documentForm', 'types', 'statuses')) ?>
