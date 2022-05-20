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

use Yii;

/**
 * Class SidebarSubMenu.
 */
class SidebarSubMenu extends \hiqdev\yii2\menus\Menu
{
    public function items()
    {
        return [
            'clients' => [
                'items' => [
                    'documents' => [
                        'label' => Yii::t('hipanel:document', 'Documents'),
                        'url' => ['/document/document/index'],
                        'visible' => Yii::$app->user->can('document.read'),
                    ],
                    'mail-out' => [
                        'label' => Yii::t('hipanel.document.mailout', 'Mail-out'),
                        'url' => ['@mail-out/index'],
                        'visible' => Yii::$app->user->can('document.update'),
                    ],
                ],
            ],
        ];
    }
}
