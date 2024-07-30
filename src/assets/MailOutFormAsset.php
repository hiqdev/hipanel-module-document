<?php

namespace hipanel\modules\document\assets;

use hipanel\assets\HipanelAsset;
use hipanel\assets\Vue3CdnAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class MailOutFormAsset extends AssetBundle
{
    public $sourcePath = __DIR__;

    public $js = [
        'MailOutForm.js',
    ];

    public $css = [
        'MailOutForm.css',
    ];

    public $depends = [
        Vue3CdnAsset::class,
        HipanelAsset::class,
        JqueryAsset::class,
    ];
}
