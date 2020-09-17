<?php

namespace paskuale75\uppy;

use paskuale75\uppy\assets\UppyAsset;
use yii\base\Widget;
use yii\bootstrap4\Html;

class Uppyuploader extends Widget
{

    public $options = []; //
    public $clientOptions = [];

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $id = $this->getId();
        $this->registerPlugin();
        $this->registerJS();
        echo Html::tag('div','',['id'=> 'drag-drop-area']);
    }


    protected function registerPlugin()
    {
        $view = $this->getView();
        UppyAsset::register($view);
    }

    protected function registerJs()
    {
        $options = json_encode($this->options);
        $clientOptions = json_encode($this->clientOptions);

        $js = <<<JS
const Uppy = require('@uppy/core')
var uppy = Uppy.Core()
  uppy.use(Uppy.DragDrop, { target: '#drag-drop-area' })
  uppy.use(Uppy.Tus, { endpoint: 'https://master.tus.io/files/' })
JS;
        $this->view->registerJs($js);
    }
}
