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

use DateTime;
use hipanel\modules\document\models\Document;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class StackedDocumentsView extends Widget
{
    /**
     * @var Document[]
     */
    public $models;

    /**
     * @var int thumbnail size. Will be used for both width and height
     */
    public $thumbSize = 64;

    public function run()
    {
        return $this->renderPreviews();
    }

    protected function getGroupedModels()
    {
        $grouped = ArrayHelper::index($this->models, 'id', [
            function ($document) {
                return (new DateTime($document->create_time))->modify('today')->format('Y-m');
            },
        ]);

        krsort($grouped, SORT_NUMERIC);

        return $grouped;
    }

    protected function renderPreviews()
    {
        $groups = $this->getGroupedModels();

        return $this->render('stackedDocuments', ['groups' => $groups]);
    }
}
