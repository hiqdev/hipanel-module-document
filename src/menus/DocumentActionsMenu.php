<?php
/**
 * Documents module for HiPanel
 *
 * @link      https://hipanel.com/
 * @package   hipanel-module-document
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\document\menus;

use hipanel\modules\document\models\Document;
use hipanel\widgets\FileRender;
use Yii;

/**
 * Class DocumentActionsMenu.
 */
class DocumentActionsMenu extends \hiqdev\yii2\menus\Menu
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
                'visible' => Yii::$app->user->can('document.update') && $this->model->state !== 'deleted',
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
                'visible' => Yii::$app->user->can('document.delete'),
            ],
        ];
    }
}
