<?php

namespace paskuale75\uppy;

use paskuale75\uppy\assets\UppyAsset;
use yii\base\Widget;
use yii\bootstrap4\Html;
use Yii;

class Uppyuploader extends Widget
{
    const MODE_DRAGDROP = 'DragDrop';
    const MODE_FILEINPUT = 'FileInput';

    public $options = []; //
    public $clientOptions = [];
    public $coreOptions = [];
    public $sourceOptions = [];

    public $mode = self::MODE_DRAGDROP;

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
        $options = json_encode($this->options);
        $clientOptions = json_encode($this->clientOptions);
        $sourceOptions = json_encode($this->sourceOptions);
        $coreOptions = json_encode($this->coreOptions);

        switch ($this->mode) {
            case self::MODE_DRAGDROP:
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
                        $id.use(Uppy.DragDrop, {$sourceOptions});
                        $id.use(Uppy.Tus, { endpoint: 'https://master.tus.io/files/' });
                        $id.on('complete', result => {
                            console.log('successful files:', result.successful)
                            console.log('failed files:', result.failed)
                        })
JS;
                break;
            case self::MODE_FILEINPUT:
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
                        $id.use(Uppy.FileInput, {$sourceOptions});
                        $id.use(Uppy.Tus, { endpoint: 'https://master.tus.io/files/' });
                        $id.on('complete', result => {
                            console.log('successful files:', result.successful)
                            console.log('failed files:', result.failed)
                        })
JS;
                break;
        }



        $this->view->registerJs($js);
    }
}
