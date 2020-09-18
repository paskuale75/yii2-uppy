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

    /**
     * @locale : language pack
     */
    public $locale = 'it_IT';

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $id = $this->getId();
        $this->registerPlugin();
        $this->registerJS();
        $content = $this->drawContentUploades();
        echo Html::tag('div', '', ['class' => 'drag-drop-area', 'id' => $id]);
        echo Html::tag('div', '', ['class' => 'for-ProgressBar', 'id' => $id]);
        echo Html::tag('div', $content, ['class' => 'uploaded-files', 'id' => $id]);
    }

    private function drawContentUploades()
    {
        return Html::tag('h5', 'Uploaded files:<ol></ol>', []);
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

        if(isset($this->coreOptions['local'])){
            $value = $this->coreOptions['local'];
            $this->coreOptions['local'] = 'Uppy.locales.' . $value;
        }
        $coreOptions = json_encode($this->coreOptions);


        $js = <<<JS

var uppy = Uppy.Core({$coreOptions});
uppy.use(Uppy.ProgressBar, { 
    target: '.for-ProgressBar',
     hideAfterFinish: false 
  });
  
  uppy.use(Uppy.DragDrop, { target: '.drag-drop-area' });
  uppy.use(Uppy.Tus, { endpoint: 'https://master.tus.io/files/' });
JS;
        $this->view->registerJs($js);
    }
}