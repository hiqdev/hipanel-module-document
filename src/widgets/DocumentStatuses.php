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
use hipanel\modules\document\models\Status;
use yii\base\Widget;

class DocumentStatuses extends Widget
{
    /**
     * @var Document
     */
    public $model;

    public function run()
    {
        return implode('&nbsp', array_merge([$this->renderState()], $this->renderStatuses()));
    }

    private function renderState()
    {
        return DocumentState::widget([
            'model' => $this->model,
        ]);
    }

    private function renderStatuses()
    {
        $result = [];

        foreach ($this->model->statuses as $status) {
            /** @var Status $status */
            $result[] = DocumentStatus::widget([
                'model' => $status,
            ]);
        }

        return $result;
    }
}
