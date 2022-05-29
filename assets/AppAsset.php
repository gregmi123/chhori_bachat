<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main1.css',
        'css/site.css',
        'css/mycssfile.css',
        'css/datatable.css'
    ];
    public $js = [
       'jsFile/nepali.datepicker.v3.2.min.js',
    //    'jsFile/datatable.js',
       //'thumb/jquery-1.8.2.js',
       'thumb/mfs100-9.0.2.6.js'
        
    ];
    public $depends = [
        // 'faryshta\disableSubmitButtons\Asset',
        'faryshta\disableSubmitButtons\Asset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
