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
        echo Html::tag('div', '', ['class' => 'for-Informer', 'id' => $id]);
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
        $Yii2_lang = str_replace('-','_',Yii::$app->language);

        $options = json_encode($this->options);
        $clientOptions = json_encode($this->clientOptions);

        $this->coreOptions['locale'] = 'Uppy.locales.'.$Yii2_lang;
        
        $coreOptions = json_encode($this->coreOptions);


        $js = <<<JS
console.log($coreOptions);
var uppy = Uppy.Core({$coreOptions});
uppy.use(Uppy.ProgressBar, { 
    target: '.for-ProgressBar',
    hideAfterFinish: false 
  });
  uppy.use(Uppy.Informer, {
    // Options
    target: '.for-Informer'
  })
  uppy.use(Uppy.DragDrop, { target: '.drag-drop-area' });
  uppy.use(Uppy.Tus, { endpoint: 'https://master.tus.io/files/' });
JS;
        $this->view->registerJs($js);
    }
}