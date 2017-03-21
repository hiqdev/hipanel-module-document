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
        'verified' => 'green fa fa-check',
        'signed' => 'light-blue fa fa-certificate',
        '*' => 'default'
    ];

    public function run()
    {
        return Html::tag('span', ' ', [
            'class' => 'badge bg-' . $this->getStatusClass(),
            'title' => Yii::t('hipanel:document', $this->model->type_label) . ' - ' . $this->getTitle(),
        ]);
    }
}
