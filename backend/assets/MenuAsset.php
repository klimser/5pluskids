<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class MenuAsset extends AssetBundle
{
    public $jsOptions = ['position' => View::POS_HEAD];
    public $sourcePath = '@app/resources';
    public $js = [
        'js/menu.js',
        'js/menuitem.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'backend\assets\NestedSortableAsset',
    ];
}
