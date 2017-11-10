<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\document\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\OrientationAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
use Yii;
use yii\filters\AccessControl;

/**
 * Class DocumentController
 * @package hipanel\modules\document\controllers
 */
class DocumentController extends CrudController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'manage-access' => [
                'class' => AccessControl::class,
                'only' => ['update', 'delete'],
                'rules' => [
                    [
                        'allow'   => true,
                        'roles'   => ['manage'],
                    ],
                ],
            ]
        ]);
    }

    public function actions()
    {
        return array_merge(parent::actions(), [
            'index' => [
                'class' => IndexAction::class,
                'data' => function () {
                    return $this->getAdditionalData();
                },
                'on beforePerform' => $this->getBeforePerformClosure(),
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('hipanel:document', 'Document was created'),
                'data' => function () {
                    return $this->getAdditionalData();
                },
            ],
            'view' => [
                'class' => ViewAction::class,
                'on beforePerform' => function ($event) {
                    /** @var ViewAction $action */
                    $action = $event->sender;

                    $action->getDataProvider()->query->details()->showDeleted();
                },
                'data' => function () {
                    return $this->getAdditionalData();
                },
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:document', 'Document was updated'),
                'on beforeFetch' => $this->getBeforePerformClosure(),
                'data' => function () {
                    return $this->getAdditionalData();
                },
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel:document', 'Document was deleted'),
            ],
            'validate-single-form' => [
                'class' => ValidateFormAction::class,
                'validatedInputId' => false
            ],
        ]);
    }

    private function getAdditionalData()
    {
        return [
            'states' => $this->getStateData(),
            'types' => $this->getTypeData(),
            'statuses' => $this->getStatusesData()
        ];
    }

    private function getBeforePerformClosure()
    {
        return function ($event) {
            /** @var ViewAction $action */
            $action = $event->sender;

            $action->getDataProvider()->query->details();
        };
    }

    public function getStateData()
    {
        return $this->getRefs('state,document', 'hipanel:document');
    }

    public function getTypeData()
    {
        return $this->getRefs('type,document', 'hipanel:document');
    }

    public function getStatusesData()
    {
        return $this->getRefs('status,document', 'hipanel:document');
    }
}
