<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\document\grid;

use hiqdev\menumanager\MenuColumn;
use hiqdev\menumanager\widgets\MenuButton;
use hipanel\grid\ActionColumn;
use hipanel\grid\BoxedGridView;
use hipanel\grid\MainColumn;
use hipanel\grid\RefColumn;
use hipanel\grid\XEditableColumn;
use hipanel\helpers\Url;
use hipanel\modules\client\menus\ClientActionsMenu;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\widgets\ClientState;
use hipanel\modules\client\widgets\ClientType;
use hipanel\modules\finance\grid\BalanceColumn;
use hipanel\modules\finance\grid\CreditColumn;
use hipanel\widgets\ArraySpoiler;
use Yii;
use yii\helpers\Html;

/**
 * Class DocumentGridView
 * @package hipanel\modules\document\grid
 */
class DocumentGridView extends BoxedGridView
{
    /**
     * @inheritdoc
     */
    public static function defaultColumns()
    {
        return [
            'title' => [
                'attribute' => 'title',
            ],
            'state' => [
                'class'  => RefColumn::class,
                'filterAttribute' => 'state_in',
                'format' => 'raw',
                'gtype'  => 'state,document',
                'i18nDictionary' => 'hipanel:document',
                'value'  => function ($model) {
                    return ClientState::widget(compact('model'));
                },
            ],
            'type' => [
                'class'  => RefColumn::class,
                'filterAttribute' => 'type_in',
                'format' => 'raw',
                'gtype'  => 'type,document',
                'i18nDictionary' => 'hipanel:document',
                'value'  => function ($model) {
                    return ClientType::widget(compact('model'));
                },
            ],
            'actions' => [
                'class' => MenuColumn::class,
                'menuClass' => ClientActionsMenu::class,
            ],
        ];
    }
}
