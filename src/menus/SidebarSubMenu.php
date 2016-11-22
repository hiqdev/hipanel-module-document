<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\document\menus;

use Yii;

/**
 * Class SidebarSubMenu
 * @package hipanel\modules\document\menus
 */
class SidebarSubMenu extends \hiqdev\menumanager\Menu
{
    public function items()
    {
        return [
            'documents' => [
                'label' => Yii::t('hipanel:document', 'Documents'),
                'url' => ['/document/document/index'],
            ],
        ];
    }
}
