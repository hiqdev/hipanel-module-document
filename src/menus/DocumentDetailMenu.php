<?php

namespace hipanel\modules\document\menus;

use hipanel\modules\document\models\Document;
use hiqdev\menumanager\Menu;

class DocumentDetailMenu extends Menu
{
    /**
     * @var Document
     */
    public $model;

    /**
     * @inheritdoc
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
