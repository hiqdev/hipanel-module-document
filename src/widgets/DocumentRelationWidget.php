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

use hipanel\modules\document\models\Object;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class DocumentRelationWidget extends Widget
{
    /**
     * @var object
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
            'link' => Html::a($this->model->name, ['@contact/view', 'id' => $this->model->id]),
        ]);
    }
}
