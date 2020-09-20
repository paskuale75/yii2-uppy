<?php
namespace paskuale75\uppy\assets;

use Yii;
use yii\web\AssetBundle;

class UppyAsset extends AssetBundle{
    public $sourcePath = '@npm/uppy/dist';
    
    public function init(){
        $lang = str_replace('-','_',Yii::$app->language);
        $this->js = [
            'uppy.min.js',
            "https://transloadit.edgly.net/releases/uppy/locales/v1.16.7/{$lang}.min.js"
        ];
    }

    public $css = [
        'uppy.min.css',
    ];
    /*
    public $depends = [
        'yii\web\JqueryAsset',
    ];
    */
}