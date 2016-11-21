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

use yii\web\Controller;

class DocumentsController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', ['model' => new Document()]);
    }
}
