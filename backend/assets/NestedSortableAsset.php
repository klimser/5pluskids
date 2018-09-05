<?php
namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class NestedSortableAsset extends AssetBundle
{
    public $jsOptions = ['position' => View::POS_HEAD];
    public $sourcePath = '@app/resources';
    public $css = [
        'css/nestedSortable.css',
    ];
    public $js = [
        'js/nestedSortable.js',
    ];
    public $depends = [
        'backend\assets\AppAsset',
        'backend\assets\NestedSortableLib',
    ];
}