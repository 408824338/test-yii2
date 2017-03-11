<?php
/**
 * Created by PhpStorm.
 * User: cmk
 * Date: 2017/2/25
 * Time: 18:13
 */

namespace common\widgets;


use yii\base\Widget;
use common\behaviors\CitySelectorBehavior;

class TestWidget extends Widget {

    public static $runTime = 0;
    public function behaviors()
    {
        return [
            //加载指定的class
            ['class' => CitySelectorBehavior::className(), 'targetRuntime' => self::$runTime],
        ];
    }

    public function run(){
        echo "this is my test widget2";
    }
}