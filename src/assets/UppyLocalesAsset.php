<?php
namespace paskuale75\uppy\assets;

use Yii;
use yii\web\AssetBundle;

class UppyLocalesAsset extends AssetBundle{

    public $sourcePath = '@npm/uppy--locales/lib';
    
    public $js = [];

    public function init(){
        $this->js = [
            'it_IT.js'
        ];
    }

    
    
    public $css = [];
}