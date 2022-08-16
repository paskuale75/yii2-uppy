<?php
namespace paskuale75\uppy\assets;

use Yii;
use yii\web\AssetBundle;

class UppyAsset extends AssetBundle{

    public $sourcePath = '@bower/';
    
    public function init(){
        //$lang = str_replace('-','_',Yii::$app->language);
        $this->js = [
            //"uppy--locales/dist/it_IT.min.js", //<- don't work
            //"uppy/packages/@uppy/core/src/Uppy.js",
            "https://releases.transloadit.com/uppy/v3.0.0-beta.4/uppy.legacy.min.js"
            //"https://transloadit.edgly.net/releases/uppy/locales/v1.16.7/{$lang}.min.js"
        ];
    }

    public $css = [
        'uppy/dist/uppy.min.css',
    ];
}