<?php
/**
 * Created by PhpStorm.
 * User: cmk
 * Date: 2017/2/25
 * Time: 21:55
 */

namespace common\widgets\upload;


use yii\web\AssetBundle;

class FileInputAsset extends AssetBundle {

    public $sourcePath='@common/widgets/upload';
    public $css =[
        'css/fileinput.css'
    ];

    public $js=[
        'js/fileinput.js'
    ];

    public $depends = [
      'Yii\web\YiiAsset'
    ];

}