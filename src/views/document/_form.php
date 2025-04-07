<?php

/**
 * @var hipanel\modules\document\models\Document $model
 * @var array $types
 * @var array $statuses
 */

use hipanel\modules\document\widgets\DocumentFormWidget;

?>

<div class="row">
    <?= DocumentFormWidget::widget([
        'model' => $model,
        'statuses' => $statuses,
        'types' => $types,
    ]) ?>
</div>
