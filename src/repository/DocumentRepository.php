<?php

namespace hipanel\modules\document\repository;

use hipanel\components\ApiConnectionInterface;
use hipanel\modules\document\forms\DocumentForm;
use hipanel\modules\document\models\Document;
use hiqdev\hiart\ErrorResponseException;
use Yii;

class DocumentRepository
{
    /**
     * @var ApiConnectionInterface
     */
    private $api;

    /**
     * DocumentRepository constructor.
     * @param ApiConnectionInterface $api
     */
    public function __construct(ApiConnectionInterface $api)
    {
        $this->api = $api;
    }

    /**
     * Finds [[Document]] by id.
     * @param $id
     * @return Document|null
     */
    public function getById($id)
    {
        return Document::find()
            ->details()
            ->where(['id' => $id])
            ->one();
    }

    public function insert(DocumentForm $form)
    {
        if (!$form->validate()) {
            return false;
        }

        try {
            $form->processFiles();
            $response = $this->api->post('documentCreate', [], $form->toArray());
        } catch (ErrorResponseException $e) {
            Yii::$app->session->addFlash('error', $e->getMessage());
            return false;
        }

        return $response['id'];
    }

    public function update(DocumentForm $form)
    {
        if (!$form->validate()) {
            return false;
        }

        try {
            $response = $this->api->post('documentUpdate', [], $form->getAttributes());
        } catch (ErrorResponseException $e) {
            Yii::$app->session->addFlash('error', $e->getMessage());
            return false;
        }

        return $response['id'];
    }
}
