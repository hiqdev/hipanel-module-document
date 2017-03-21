<?php

namespace hipanel\modules\document\widgets;


use DateTime;
use hipanel\modules\document\models\Document;
use Yii;
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
