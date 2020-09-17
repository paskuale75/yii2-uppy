<?php
namespace paskuale75\uppy\assets;


use yii\web\AssetBundle;


class UppyAsset extends AssetBundle{
    public $sourcePath = '@bower/uppy';
    public $js = [
        'bin/build-js.js'
    ];
    public $css = [
        '/core/dist/style.css',
        '/dashboard/dist/style.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}