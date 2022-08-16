<?php

namespace paskuale75\uppy\assets;

use Yii;
use yii\web\AssetBundle;

class UppyAsset extends AssetBundle
{

    public $sourcePath = '@bower/';


    //$lang = str_replace('-','_',Yii::$app->language);
    public $js = [
        "https://releases.transloadit.com/uppy/v3.0.0-beta.4/uppy.legacy.min.js"
    ];


    public $css = [
        'https://releases.transloadit.com/uppy/v3.0.0-beta.4/uppy.min.css',
    ];
}
