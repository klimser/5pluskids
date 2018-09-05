<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class TranslitAsset extends AssetBundle
{
    public $jsOptions = ['position' => View::POS_HEAD];
    public $sourcePath = '@app/resources';
    public $js = [
        'js/translit.js',
    ];
}
