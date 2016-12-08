<?php

namespace hipanel\modules\document\widgets;

use hipanel\modules\document\models\Status;
use hipanel\widgets\Type;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class DocumentStatus
 *
 * @package hipanel\modules\document\widgets
 */
class DocumentStatus extends Widget
{
    /**
     * @var Status
     */
    public $model;

    public function run()
    {
        return Html::tag('span', Yii::t('hipanel:document', $this->model->type_label), [
            'class' => 'label ' . $this->getStatusClass(),
            'title' => $this->getTitle()
        ]);
    }

    private function getStatusClass()
    {
        $map = [
            'verified' => 'label-primary',
            'signed' => 'label-success',
        ];

        return isset($map[$this->model->type]) ? $map[$this->model->type] : 'label-default';
    }

    private function getTitle()
    {
        return Yii::t('hipanel:document', 'Added {date} by {login}', [
            'date' => Yii::$app->formatter->asDate($this->model->time),
            'login' => $this->model->assigned_by,
        ]);
    }
}
