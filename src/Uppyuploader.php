<?php

namespace paskuale75\uppy;

use paskuale75\uppy\assets\UppyAsset;
use yii\base\Widget;
use yii\bootstrap4\Html;
use Yii;

class Uppyuploader extends Widget
{

    public $options = []; //
    public $clientOptions = [];
    public $coreOptions = [];
    public $dragDropOptions = [];

    /**
     * @locale : default language pack
     */
    public $locale = 'it_IT';

    public function init()
    {
        parent::init();
        $this->registerPlugin();
    }

    public function run()
    {
        $html = '';
        $id = $this->getId();
        
        $this->registerJS($id);
        $content = $this->drawContentUploades();
        //$html .= Html::tag('div', '', ['class' => 'drag-drop-area', 'id' => $id]);
        $html .= Html::tag('div', '', ['class' => 'for-ProgressBar', 'id' => $id]);
        $html .= Html::tag('div', '', ['class' => 'for-Informer', 'id' => $id]);
        $html .= Html::tag('div', $content, ['class' => 'uploaded-files', 'id' => $id]);
        return $html;
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

    private function registerJs($id)
    {
        $options = json_encode($this->options);
        $clientOptions = json_encode($this->clientOptions);
        $dragDropOptions = json_encode($this->dragDropOptions);
        $coreOptions = json_encode($this->coreOptions);


        $js = <<<JS
console.log($coreOptions);
console.log($dragDropOptions);
var identifier = $id;
var $id = Uppy.Core({$coreOptions});

    $id.use(Uppy.ProgressBar, { 
        target: '.for-ProgressBar',
        hideAfterFinish: false 
    });
    $id.use(Uppy.Informer, {
        // Options
        target: '.for-Informer'
    })
    $id.use(Uppy.DragDrop, {$dragDropOptions});
    $id.use(Uppy.Tus, { endpoint: 'https://master.tus.io/files/' });
JS;
        $this->view->registerJs($js);
    }
}