<?php
/**
 * Documents module for HiPanel
 *
 * @link      https://hipanel.com/
 * @package   hipanel-module-document
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\document\widgets;

use Yii;
use yii\helpers\Html;

/**
 * Class DocumentStatusIcon.
 */
class DocumentStatusIcon extends DocumentStatus
{
    public $statusCssClasses = [
        'verified' => 'green fa fa-check',
        'signed' => 'light-blue fa fa-certificate',
        '*' => 'default',
    ];

    public function run()
    {
        return Html::tag('span', ' ', [
            'class' => 'badge bg-' . $this->getStatusClass(),
            'title' => Yii::t('hipanel:document', $this->model->type_label) . ' - ' . $this->getTitle(),
        ]);
    }
}
