<?php
namespace paskuale75\uppy\assets;

use yii\web\AssetBundle;

class UppyAsset extends AssetBundle{
    public $sourcePath = '@npm/uppy/dist';
    public $js = [
        'uppy.js'
    ];
    public $css = [
        'uppy.min.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'paskuale75\uppy\assets\RequireAsset'
    ];
}