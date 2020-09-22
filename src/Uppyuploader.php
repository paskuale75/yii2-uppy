<?php

namespace paskuale75\uppy;

use paskuale75\uppy\assets\UppyAsset;
use yii\base\Widget;
use yii\bootstrap4\Html;
use Yii;
use yii\web\HttpException;

class Uppyuploader extends Widget
{
    const MODE_DRAGDROP = 'DragDrop';
    const MODE_FILEINPUT = 'FileInput';

    const DEST_XHR = '';
    const DEST_TUS = 'Tus';

    public $options = []; //
    public $clientOptions = [];
    public $coreOptions = [];
    public $sourceOptions = [];

    public $source = self::MODE_DRAGDROP;
    public $destination = self::DEST_XHR;

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
        $id = $this->getId();
        $this->registerJS($id);
        return $this->drawHtmlElements();
    }

    private function drawContentUploades()
    {
        return Html::tag('h5', 'Uploaded files:<ol></ol>', []);
    }

    private function drawHtmlElements()
    {
        $id = $this->getId();
        $html = '';
        $content = $this->drawContentUploades();
        
        $html .= Html::tag('div', '', ['class' => 'for-ProgressBar', 'id' => $id]);
        $html .= Html::tag('div', '', ['class' => 'for-Informer', 'id' => $id]);
        if ($this->mode == self::MODE_DRAGDROP) {
            $html .= Html::tag('div', $content, ['class' => 'uploaded-files', 'id' => $id]);
        }

        return $html;
    }

    protected function registerPlugin()
    {
        $view = $this->getView();
        UppyAsset::register($view);
    }

    private function registerJs($id)
    {
        
        $coreOptions = json_encode($this->coreOptions);
        if(!isset($this->options['source'])){
            return new HttpException('505', 'You must define source element in option array!');
        }else{
            $sourceOptions = json_encode($this->options['source']['options']);
        }
        if(!isset($this->options['destination'])){
            return new HttpException('505', 'You must define destination element in option array!');
        }else{
            $destinationOptions = json_encode($this->options['destination']['options']);
        }

        switch ($this->options['source']['type']) {
            case self::MODE_DRAGDROP:
                $inputObject = <<<JS
                        $id.use(Uppy.DragDrop, {$sourceOptions});
JS;
                break;
            case self::MODE_FILEINPUT:
                $inputObject = <<<JS
                        $id.use(Uppy.FileInput, {$sourceOptions});
JS;
                break;
        }


        switch ($this->options['destinaton']['type']) {
            case self::DEST_TUS:
                $destinationObject = <<<JS
                        $id.use(Tus, {$destinationOptions
                            //endpoint: 'https://master.tus.io/files/', // use your tus endpoint here
                            //resume: true,
                            //retryDelays: [0, 1000, 3000, 5000]
                        })
JS;
                break;
            case self::DEST_XHR:
                $destinationObject = <<<JS
                        $id.use(XHRUpload, {
                            $destinationOptions
                        })
JS;
                break;
        }


        $js = <<<JS
        console.log($coreOptions);
        console.log($sourceOptions);
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
            $inputObject
            $destinationObject
            $id.on('complete', result => {
                console.log('successful files:', result.successful)
                console.log('failed files:', result.failed)
            })
JS;

        $this->view->registerJs($js);
    }
}
