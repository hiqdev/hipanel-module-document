<?php

return [
    'aliases' => [
        '@document' => '/document/document',
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
                    'basePath' => '@hipanel/modules/document/messages',
                ],
            ],
        ],
    ],
    'container' => [
        'definitions' => [
            \hiqdev\thememanager\menus\AbstractSidebarMenu::class => [
                'add' => [
                    'client' => [
                        'menu' => [
                            'merge' => [
                                'document' => [
                                    'menu' => \hipanel\modules\document\menus\SidebarSubMenu::class,
                                    'where' => [
                                        'after' => ['contacts'],
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
