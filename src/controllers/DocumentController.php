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
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
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
        return [
            'index' => [
                'class' => IndexAction::class,
                'data' => $this->getAdditionalDataClosure(),
                'on beforePerform' => $this->getBeforePerformClosure(),
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'data' => $this->getAdditionalDataClosure(),
            ],
            'view' => [
                'class' => ViewAction::class,
                'data' => $this->getAdditionalDataClosure(),
                'on beforePerform' => $this->getBeforePerformClosure(),
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
                'data' => $this->getAdditionalDataClosure(),
                'on beforePerform' => $this->getBeforePerformClosure(),
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
            'set-orientation' => [
                'class' => OrientationAction::class,
                'allowedRoutes' => ['@document/index'],
            ],
        ];
    }

    private function getAdditionalDataClosure()
    {
        return function () {
            return [
                'states' => $this->getStateData(),
                'types' => $this->getTypeData(),
            ];
        };
    }

    private function getBeforePerformClosure()
    {
        return function ($event) {
            /** @var ViewAction $action */
            $action = $event->sender;

            $action->getDataProvider()->query
                ->joinWith('file')
                ->joinWith('object');
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
}
