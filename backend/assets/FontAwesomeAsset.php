<?php

namespace backend\assets;

use yii\web\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@npm/fortawesome--fontawesome-free';
    public $css = [
        'css/all.css',
        'css/fontawesome.css',
    ];
    public $publishOptions = [
        'only' => ['webfonts/*', 'css/*'],
    ];
}
