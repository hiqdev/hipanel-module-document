<?php

namespace hipanel\modules\document\widgets;

use hipanel\modules\document\models\Object;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class DocumentRelationWidget extends Widget
{
    /**
     * @var Object
     */
    public $model;

    public function run()
    {
        if ($this->model === null) {
            return '';
        }

        return $this->renderRelationLink();
    }

    protected function renderRelationLink()
    {
        switch ($this->model->class_name) {
            case 'contact':
                return $this->renderContactLink();
            default:
                return '';
        }
    }

    protected function renderContactLink()
    {
        return Yii::t('hipanel:document', 'Contact: {link}', [
            'link' => Html::a($this->model->name, ['@contact/view', 'id' => $this->model->id])
        ]);
    }
}
