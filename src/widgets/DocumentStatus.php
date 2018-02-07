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

use hipanel\modules\document\models\Status;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class DocumentStatus.
 */
class DocumentStatus extends Widget
{
    /**
     * @var Status
     */
    public $model;

    /**
     * @var array
     */
    public $statusCssClasses = [
        'verified' => 'primary',
        'signed' => 'success',
        '*' => 'default',
    ];

    public function run()
    {
        return Html::tag('span', Yii::t('hipanel:document', $this->model->type_label), [
            'class' => 'label label-' . $this->getStatusClass(),
            'title' => $this->getTitle(),
        ]);
    }

    protected function getStatusClass()
    {
        return isset($this->statusCssClasses[$this->model->type])
            ? $this->statusCssClasses[$this->model->type]
            : $this->statusCssClasses['*'];
    }

    protected function getTitle()
    {
        return Yii::t('hipanel:document', 'Added {date} by {login}', [
            'date' => Yii::$app->formatter->asDate($this->model->time),
            'login' => $this->model->assigned_by,
        ]);
    }
}
