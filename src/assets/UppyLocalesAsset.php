<?php
namespace paskuale75\uppy\assets;

use Yii;
use yii\web\AssetBundle;

class UppyLocalesAsset extends AssetBundle{

    public $_js = [];

    public function init(){
        parent::init();
        if(Yii::$app->params['language']){
            $this->js = [
                Yii::$app->params['language'].'.min.js'
            ];
        }
    }

    public $sourcePath = '@npm/uppy--locales/dist';
    
    public $css = [];

    
}