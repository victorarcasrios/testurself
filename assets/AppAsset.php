<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/dataTables.bootstrap.css',
        "//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"
    ];
    public $js = [
        'js/angular.js',
        'js/dataTables.bootstrap.min.js',
        'js/questions/form.js',
        'js/questions/index.js',
        'js/tests/form.js',
        'js/tests/index.js',
        'js/examinations/form.js',
        'js/examinations/index.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
