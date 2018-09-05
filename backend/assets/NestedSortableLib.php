<?php
namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class NestedSortableLib extends AssetBundle
{
    public $jsOptions = ['position' => View::POS_HEAD];
    public $sourcePath = '@vendor/ilikenwf/nestedSortable';
    public $js = [
        'jquery.mjs.nestedSortable.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
    ];
}