<?php
/**
 * Created by PhpStorm.
 * User: cmk
 * Date: 2017/2/26
 * Time: 22:20
 */

namespace common\behaviors;


use yii\base\Behavior;
use yii\base\Widget;

class MyBehavior  extends Behavior {
    // 行为的一个属性
    public $property1 = 'this is property is MyBehavior';

    // 行为的一个方法
    public function method1(){
        return 'Method in MyBehavior is called';
    }


}








