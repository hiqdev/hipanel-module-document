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

/**
 * Class DocumentDetailMenu.
 */
class DocumentDetailMenu extends \hipanel\menus\AbstractDetailMenu
{
    /**
     * @var Document
     */
    public $model;

    /**
     * {@inheritdoc}
     */
    public function items()
    {
        $actions = DocumentActionsMenu::create([
            'model' => $this->model,
        ])->items();

        unset($actions['view']);

        return $actions;
    }
}
