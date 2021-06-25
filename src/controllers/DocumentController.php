<?php
/**
 * Documents module for HiPanel
 *
 * @link      https://hipanel.com/
 * @package   hipanel-module-document
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\document\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
use hipanel\filters\EasyAccessControl;
use hipanel\modules\document\models\Document;
use hiqdev\hiart\ResponseErrorException;
use Yii;

/**
 * Class DocumentController.
 */
class DocumentController extends CrudController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access-document' => [
                'class' => EasyAccessControl::class,
                'actions' => [
                    'create,import,copy'    => 'document.create',
                    'update'                => 'document.update',
                    'delete'                => 'document.delete',
                    '*'                     => 'document.read',
                ],
            ],
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
                'validatedInputId' => false,
            ],
        ]);
    }

    private function getAdditionalData()
    {
        return [
            'states' => $this->getStateData(),
            'types' => $this->getTypeData(),
            'statuses' => $this->getStatusesData(),
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

    public function actionArchive()
    {
        $response = Yii::$app->response;
        if (empty(Yii::$app->request->get())) {
            Yii::$app->getSession()->setFlash('error', Yii::t('hipanel:document', 'Filter document first'));
            return $this->redirect(Yii::$app->request->referrer);
        }
        try {
            $data = Document::perform('export', array_shift(Yii::$app->request->get()), ['batch' => true]);
        } catch (ResponseErrorException $e) {
            Yii::$app->getSession()->setFlash('error', Yii::t('hipanel:document', 'Error during creating archive'));
            return $this->redirect(Yii::$app->request->referrer);
        }

        $response->sendContentAsFile($data, 'archive.zip')->send();
    }
}
