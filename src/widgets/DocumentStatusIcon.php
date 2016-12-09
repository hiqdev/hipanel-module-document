<?php

namespace hipanel\modules\document\widgets;

use hipanel\modules\document\models\Status;
use hipanel\widgets\Type;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class DocumentStatusIcon
 *
 * @package hipanel\modules\document\widgets
 */
class DocumentStatusIcon extends DocumentStatus
{
    public $statusCssClasses = [
        'verified' => 'success fa fa-check',
        'signed' => 'info fa fa-certificate',
        '*' => 'default'
    ];

    public function run()
    {
        return Html::tag('i', '', [
            'class' => 'text-' . $this->getStatusClass(),
            'title' => Yii::t('hipanel:document', $this->model->type_label) . ' - ' . $this->getTitle(),
        ]);
    }
}
