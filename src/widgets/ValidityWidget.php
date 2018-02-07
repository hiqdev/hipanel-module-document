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

use hipanel\modules\document\models\Document;
use Yii;
use yii\base\Widget;

class ValidityWidget extends Widget
{
    /**
     * @var Document
     */
    public $model;

    /**
     * @var string
     */
    public $start_attribute = 'validity_start';

    /**
     * @var string
     */
    public $end_attribute = 'validity_end';

    protected function getStart()
    {
        return $this->model->{$this->start_attribute};
    }

    protected function getEnd()
    {
        return $this->model->{$this->end_attribute};
    }

    public function run()
    {
        if ($this->getStart()) {
            echo $this->renderStart();
            echo $this->renderDelimiter();
            echo $this->renderEnd();

            return;
        }

        echo $this->renderEmpty();

        return;
    }

    protected function renderStart()
    {
        return Yii::$app->formatter->asDate($this->getStart()); // todo: colorize
    }

    protected function renderDelimiter()
    {
        return ' &ndash; ';
    }

    protected function renderEnd()
    {
        if (!empty($this->getEnd())) {
            return Yii::$app->formatter->asDate($this->getEnd());
        }

        return Yii::t('hipanel:document', '∞');
    }

    protected function renderEmpty()
    {
        return Yii::t('hipanel:document', 'Not set');
    }
}
