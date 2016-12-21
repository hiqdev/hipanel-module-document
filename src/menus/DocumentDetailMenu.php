<?php

namespace hipanel\modules\document\menus;

use hipanel\modules\document\models\Document;

/**
 * Class DocumentDetailMenu
 */
class DocumentDetailMenu extends \hipanel\menus\AbstractDetailMenu
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
