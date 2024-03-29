<?php
/**
 * Documents module for HiPanel
 *
 * @link      https://hipanel.com/
 * @package   hipanel-module-document
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2018, HiQDev (http://hiqdev.com/)
 */

return [
    'aliases' => [
        '@document' => '/document/document',
        '@mail-out' => '/document/mail-out',
    ],
    'modules' => [
        'document' => [
            'class' => \hipanel\modules\document\Module::class,
        ],
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                'hipanel:document' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => dirname(__DIR__) . '/src/messages',
                ],
                'hipanel.document.mailout' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => dirname(__DIR__) . '/src/messages',
                ],
            ],
        ],
    ],
    'container' => [
        'definitions' => [
            \hiqdev\thememanager\menus\AbstractSidebarMenu::class => [
                'add' => [
                    'clients' => [
                        'menu' => [
                            'merge' => [
                                'document' => [
                                    'menu' => \hipanel\modules\document\menus\SidebarSubMenu::class,
                                    'where' => [
                                        'after' => ['contacts'],
                                    ],
                                ],
                                'mail-out' => [
                                    'menu' => \hipanel\modules\document\menus\SidebarSubMenu::class,
                                    'where' => [
                                        'after' => ['debts'],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
