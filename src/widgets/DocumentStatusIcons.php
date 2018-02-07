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
use yii\base\Widget;

/**
 * Class DocumentStatusIcons.
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
