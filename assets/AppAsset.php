<?php
namespace app\assets;

use yii\web\AssetBundle;

/** Стили и сценарии интерфейса Language Bloom. */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = ['css/styles.css'];
    public $js = ['js/script.js'];
    public $depends = ['yii\web\YiiAsset'];
}
