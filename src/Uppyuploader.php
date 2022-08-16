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

    public $events_onComplete;

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

        $html .= Html::tag('div', '', ['class' => 'for-ProgressBar', 'id' => 'ProgressBar_' . $id]);
        $html .= Html::tag('div', '', ['class' => 'for-Informer', 'id' => $id]);
        if ($this->options['source']['type'] == self::MODE_DRAGDROP) {
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
        $identifier = $id;
        $coreOptions = json_encode($this->coreOptions);
        if (!isset($this->options['source'])) {
            return new HttpException('505', 'You must define source element in option array!');
        } else {
            $sourceOptions = json_encode($this->options['source']['options']);
        }
        if (!isset($this->options['destination'])) {
            return new HttpException('505', 'You must define destination element in option array!');
        } else {
            $destinationOptions = json_encode($this->options['destination']['options']);
        }

        $progressBarOptions = json_encode($this->options['progressBar']);

        $onComplete = $this->events_onComplete;

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


        switch ($this->options['destination']['type']) {
            case self::DEST_TUS:
                $destinationObject = <<<JS
                        $id.use(Tus, {$destinationOptions})
JS;
                break;
            case self::DEST_XHR:
                $destinationObject = <<<JS
                        $id.use(XHRUpload, {$destinationOptions})
JS;
                break;
        }


        $js = <<<JS
        import Uppy from '@uppy/core'
        import FileInput from '@uppy/file-input'
        import XHRUpload from '@uppy/xhr-upload'
        import ProgressBar from '@uppy/progress-bar'

        document.querySelector('.Uppy').innerHTML = ''

        const uppy = new Uppy({ debug: true, autoProceed: true })
        uppy.use(FileInput, {
        target: '.Uppy',
        })
        uppy.use(ProgressBar, {
        target: '.UppyProgressBar',
        hideAfterFinish: false,
        })
        uppy.use(XHRUpload, {
        endpoint: 'https://xhr-server.herokuapp.com/upload',
        formData: true,
        fieldName: 'files[]',
        })

        // And display uploaded files
        uppy.on('upload-success', (file, response) => {
        const url = response.uploadURL
        const fileName = file.name

        const li = document.createElement('li')
        const a = document.createElement('a')
        a.href = url
        a.target = '_blank'
        a.appendChild(document.createTextNode(fileName))
        li.appendChild(a)

        document.querySelector('.uploaded-files ol').appendChild(li)
})
JS;

        $this->view->registerJs($js);
    }
}
