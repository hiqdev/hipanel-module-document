<?php

namespace hipanel\modules\document\assets;

use hipanel\assets\HipanelAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class MailOutFormAsset extends AssetBundle
{
    public $sourcePath = __DIR__;

    public $js = [
        (YII_DEBUG ? 'https://unpkg.com/vue@3' : 'https://unpkg.com/vue@3/dist/vue.global.prod.js'),
        'MailOutForm.js',
    ];

    public $css = [
        'MailOutForm.css',
    ];

    public $depends = [
        HipanelAsset::class,
        JqueryAsset::class,
    ];
}
