<?php

namespace hipanel\modules\document\menus;

use hipanel\modules\document\models\Document;
use hipanel\widgets\FileRender;
use Yii;

class DocumentActionsMenu extends \hiqdev\menumanager\Menu
{
    /**
     * @var Document
     */
    public $model;

    public function items()
    {
        return [
            'download' => [
                'label' => Yii::t('hipanel:document', 'Download'),
                'icon' => 'fa-download',
                'url' => call_user_func(function () {
                    /** @var FileRender $fileRender */
                    $fileRender = Yii::createObject([
                        'class' => FileRender::class,
                        'file' => $this->model->file,
                    ]);

                    return $fileRender->getRoute(true);
                }),
            ],
            'view' => [
                'label' => Yii::t('hipanel', 'View'),
                'icon' => 'fa-info',
                'url' => ['@document/view', 'id' => $this->model->id],
            ],
            'update' => [
                'label' => Yii::t('hipanel', 'Update'),
                'icon' => 'fa-pencil',
                'url' => ['@document/update', 'id' => $this->model->id],
                'visible' => Yii::$app->user->can('manage'),
            ],
            'delete' => [
                'label' => Yii::t('hipanel', 'Delete'),
                'icon' => 'fa-trash',
                'url' => ['@document/delete', 'id' => $this->model->id],
                'linkOptions' => [
                    'data' => [
                        'confirm' => Yii::t('hipanel', 'Are you sure you want to delete this item?'),
                        'method' => 'POST',
                        'pjax' => '0',
                    ],
                ],
                'encode' => false,
                'visible' => Yii::$app->user->can('manage'),
            ],
        ];
    }
}
