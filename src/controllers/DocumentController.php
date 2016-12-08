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

use Guzzle\Plugin\ErrorResponse\Exception\ErrorResponseException;
use hipanel\actions\IndexAction;
use hipanel\actions\OrientationAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
use hipanel\modules\document\forms\DocumentForm;
use hipanel\modules\document\repository\DocumentRepository;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Class DocumentController
 * @package hipanel\modules\document\controllers
 */
class DocumentController extends CrudController
{
    /**
     * @var DocumentRepository
     */
    protected $documentRepository;

    public function __construct($id, $module, DocumentRepository $documentRepository, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->documentRepository = $documentRepository;
    }

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
                'data' => function () {
                    return $this->getAdditionalData();
                },
                'on beforePerform' => $this->getBeforePerformClosure(),
            ],
            'view' => [
                'class' => ViewAction::class,
                'data' => function () {
                    return $this->getAdditionalData();
                },
                'on beforePerform' => $this->getBeforePerformClosure(),
            ],
            'validate-single-form' => [
                'class' => ValidateFormAction::class,
                'collection' => [
                    'model' => DocumentForm::class,
                ],
                'validatedInputId' => false
            ],
            'set-orientation' => [
                'class' => OrientationAction::class,
                'allowedRoutes' => ['@document/index'],
            ],
        ];
    }

    public function actionCreate()
    {
        $form = new DocumentForm(['scenario' => 'create']);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            if ($id = $this->documentRepository->insert($form)) {
                return $this->redirect(['view', 'id' => $id]);
            }
        }

        return $this->render('create', array_merge($this->getAdditionalData(), [
            'documentForm' => $form,
        ]));
    }

    public function actionUpdate($id)
    {
        $repository = $this->documentRepository;
        $document = $repository->getById($id);
        if ($document === null) {
            throw new NotFoundHttpException('Document is not available');
        }

        $form = new DocumentForm(['scenario' => 'update']);
        $form->fromDocument($document);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post()) && $repository->update($form)) {
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('update', array_merge($this->getAdditionalData(), [
            'model' => $document,
            'documentForm' => $form,
        ]));
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
