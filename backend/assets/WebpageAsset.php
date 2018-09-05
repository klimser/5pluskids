<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class WebpageAsset extends AssetBundle
{
    public $jsOptions = ['position' => View::POS_HEAD];
    public $sourcePath = '@app/resources';
    public $js = [
        'js/webpage.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'backend\assets\TranslitAsset',
    ];
}
