<?php
/**
 * Created by PhpStorm.
 * User: cmk
 * Date: 2017/2/25
 * Time: 18:13
 */

namespace common\widgets;


use yii\base\Widget;

class TestWidget extends Widget {

    public function run(){
        echo "this is my test widget";
    }
}