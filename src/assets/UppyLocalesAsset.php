<?php
namespace paskuale75\uppy\assets;

use Yii;
use yii\web\AssetBundle;

class UppyLocalesAsset extends AssetBundle{


    public $sourcePath = '@npm/uppy--locales/dist';
    public $js = [];
    public $css = [];
}