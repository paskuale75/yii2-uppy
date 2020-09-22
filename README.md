# yii2-uppy
Uppy wrapper, modular JavaScript file uploader that integrates seamlessly with any application. It’s fast, easy to use and lets you worry about more important problems than building a file uploader.

## Installation ##

Install **yii2-uppy** in the usual way with [Composer](https://getcomposer.org/). 
Add the following to the require section of your `composer.json` file:

`"paskuale75/yii2-uppy": "*"` 

or run:

`composer require paskuale75/yii2-uppy` 

You can manually install **yii2-uppy** by [downloading the source in ZIP-format](https://github.com/paskuale75/yii2-uppy/archive/master.zip).

## Usage
```php
echo '<div  id="div_'.$myID.'" class="col-md-12">';
echo Uppyuploader::widget([
    // default mode => MODE_DRAGDROP
    'mode' => Uppyuploader::MODE_FILEINPUT,
    'options' => [
        'informer' => [
            //'class' => 'alert alert-primary'
        ]
    ],
    'coreOptions' => [
        'debug' => true,
        'autoProceed' => true,
        'target' => '#div_'.$myID,
        'locale' => str_replace('-','_',Yii::$app->language),
        'restrictions' => [
            'maxFileSize' => 1000000,
            'maxNumberOfFiles' => 1,
            'minNumberOfFiles' => 1,
            'allowedFileTypes' => ['image/*', 'video/*']
        ]
    ],
    'sourceOptions' => [
        'target' => '#div_'.$myID
    ]
]);
echo '</div>
```


## P.S.
You may encounter problems with the 'composer update' command if you are using composer version 1.10.13, 
downgrade to 1.10.10 and everything will work as it should.
Downgrade with   `"composer self-update 1.10.10"`
