<?php
namespace app\assets;

use Yii;
use yii\web\AssetBundle;
use yii\web\View;


class AngularAsset extends AssetBundle
{
    /**
     * [$sourcePath description]
     * @var string
     */
     public $sourcePath = '@bower';
//    public $basePath = '@webroot';
//    public $baseUrl = '@web';

    /**
     * [$js description]
     * @var array
     */
    public $js = [
        'angular/angular.js',
//        'angular-route/angular-route.js',
        'angular-cookies/angular-cookies.js',
        'angular-ui-router/release/angular-ui-router.js',
        'angular-strap/dist/angular-strap.js',
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
    
    /**
     * [$depends description]
     * @var array
     */
//    public $depends = [
//        'yii\web\JqueryAsset',
//    ];
}
