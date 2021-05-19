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

use hipanel\models\Ref;
use yii\base\Widget;
use Exception;

class DocumentFormWidget extends Widget
{
    /**
     * @var object
     */
    public $model;

    /**
     * @var array
     */
    public $statuses;

    /**
     * @var array
     */
    public $states;

    /**
     * @var array
     */
    public $types;

    /**
     * @var integer
     */
    public $boxWidth;

    /** {@inheritdoc} */
    public function init()
    {
        if ($this->model === null) {
            throw new Exception('`model` could not be empty');
        }

        if ($this->statuses === null) {
            $this->statuses = $this->getAttributeData("status");
        }

        if ($this->states === null) {
            $this->states = $this->getAttributeData("state");
        }

        if ($this->types === null) {
            $this->types = $this->getAttributeData("type");
        }

        if ($this->boxWidth === null) {
            $this->boxWidth = 6;
        }
    }

    /** {@inheritdoc} */
    public function run()
    {
        return $this->render("DocumentFormWidget", [
            'model' => $this->model,
            'statuses' => $this->statuses,
            'states' => $this->states,
            'types' => $this->types,
            'boxWidth' => $this->boxWidth,
        ]);
    }

    protected function getAttributeData($attribute)
    {
        return Ref::getList("{$attribute},document", "hipanel:document");
    }
}
