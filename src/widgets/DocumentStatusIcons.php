<?php

namespace hipanel\modules\document\widgets;

use hipanel\modules\document\models\Document;
use yii\base\Widget;

/**
 * Class DocumentStatusIcons
 *
 * @package hipanel\modules\document\widgets
 */
class DocumentStatusIcons extends Widget
{
    /**
     * @var Document
     */
    public $model;

    public function run()
    {
        $result = [];
        foreach ($this->model->statuses as $status) {
            $result[] = DocumentStatusIcon::widget(['model' => $status]);
        }

        return implode(' ', $result);
    }
}
