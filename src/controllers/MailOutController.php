<?php

declare(strict_types=1);

namespace hipanel\modules\document\controllers;

use Exception;
use hipanel\filters\EasyAccessControl;
use hipanel\modules\document\forms\MailOutFormInterface;
use hipanel\modules\document\forms\PrepareMailOutForm;
use hipanel\modules\document\forms\SendMailOutForm;
use yii\web\Controller;
use yii\web\Response;

class MailOutController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access-mail-out' => [
                'class' => EasyAccessControl::class,
                'actions' => [
                    '*' => 'document.update',
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'prepareMailOutForm' => new PrepareMailOutForm(),
            'sendMailOutForm' => new SendMailOutForm(),
        ]);
    }

    public function actionPrepare()
    {
        return $this->handleForm(new PrepareMailOutForm());
    }

    public function actionPreview()
    {
        return $this->handleForm(new SendMailOutForm(['test' => true]));
    }

    public function actionSend()
    {
        return $this->handleForm(new SendMailOutForm(['test' => false]));
    }

    public function actionDownloadEml()
    {
        $form = new SendMailOutForm(['test' => true]);
        if (($form->load($this->request->get()) || $form->load($this->request->get(), ''))) {
            if (!$form->validate()) {
                $first = $form->getFirstErrors();

                return $this->renderContent(reset($first));
            }
            try {
                $form->perform();
            } catch (Exception $e) {
                return $this->renderContent($e->getMessage());
            }
            [$recipient,] = explode(':', $form->recipients);
            $data = $form->toArray();
            $content = $data[$recipient]['preview'] ?? '';
            if (!empty($content)) {
                return $this->response->sendContentAsFile(
                    $content,
                    implode('.', [$recipient, 'eml']),
                    ['inline' => true, 'mimeType' => 'application/octet-stream']
                );
            }
        }
    }

    private function handleForm(MailOutFormInterface $form): Response
    {
        if ($this->request->isAjax && ($form->load($this->request->post()) || $form->load($this->request->post(),
                    ''))) {
            if (!$form->validate()) {
                $first = $form->getFirstErrors();

                return $this->asJson($this->prepareResponse([], reset($first)));
            }
            try {
                $form->perform();
            } catch (Exception $e) {
                return $this->asJson($this->prepareResponse([], $e->getMessage()));
            }

            return $this->asJson($this->prepareResponse($form->toArray()));
        }
    }

    private function prepareResponse(array $data, ?string $errorMessage = null, ?string $successMessage = null): array
    {
        return [
            'errorMessage' => $errorMessage,
            'successMessage' => $successMessage,
            'data' => $data,
        ];
    }
}
