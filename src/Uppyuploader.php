<?php

namespace paskuale75\uppy;

use paskuale75\uppy\assets\UppyAsset;
use yii\base\Widget;
use yii\bootstrap4\Html;

class Uppyuploader extends Widget
{

    public $options = []; //
    public $clientOptions = [];
    public $coreOptions = [];
    public $dragDropOptions = [];

    

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $id = $this->getId();
        $this->registerPlugin();
        $this->registerJS();
        $this->drawDoms($id);
    }

    private function drawDoms($id)
    {
        $content = Html::tag('h5', 'Uploaded files:<ol></ol>', []);
        if(isset($this->dragDropOptions['target'])){
            $targetClass = $this->dragDropOptions['target'];
            echo Html::tag('div', '', ['class' => $targetClass, 'id' => $id]);
        };
        echo Html::tag('div', '', ['class' => 'for-ProgressBar', 'id' => $id]);
        echo Html::tag('div', $content, ['class' => 'uploaded-files', 'id' => $id]);
    }

    protected function registerPlugin()
    {
        $view = $this->getView();
        UppyAsset::register($view);
    }

    protected function registerJs()
    {
        $locale = 'it_IT';
        $options = json_encode($this->options);
        $clientOptions = json_encode($this->clientOptions);
        $dragDropOptions = json_encode($this->dragDropOptions);


        if(isset($this->coreOptions['local'])){
            $locale = $this->coreOptions['local'];
            $this->coreOptions['local'] = 'Uppy.locales.' . $locale;
        }else{
            $this->coreOptions['local'] = 'Uppy.locales.' . $locale;
        }
        $coreOptions = json_encode($this->coreOptions);


        $js = <<<JS

var uppy = Uppy.Core({$coreOptions});

uppy.use(Uppy.ProgressBar, { 
    target: '.for-ProgressBar',
     hideAfterFinish: false 
  });
  
  uppy.use(Uppy.DragDrop, { $dragDropOptions });
  uppy.use(Uppy.Tus, { endpoint: 'https://master.tus.io/files/' });
JS;
        $this->view->registerJs($js);
    }
}
