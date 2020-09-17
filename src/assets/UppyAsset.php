<?php
namespace paskuale75\uppy\assets;


use yii\web\AssetBundle;


class UppyAsset extends AssetBundle{
    public $sourcePath = '@bower/uppy/';
    public $js = [
        'src/core/Core.js'
    ];
    public $css = [
        '/core/dist/style.css',
        '/dashboard/dist/style.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}