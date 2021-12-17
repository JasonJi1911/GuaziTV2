<?php

namespace pc\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class StyleShareDown extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/css/sharedown.css',
    ];
    public $js = [

    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
