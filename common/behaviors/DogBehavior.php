<?php
/**
 * Created by PhpStorm.
 * User: cmk
 * Date: 2017/3/11
 * Time: 20:48
 */

namespace common\behaviors;


use yii\base\Behavior;

class DogBehavior extends Behavior {

    public $height;

    //狗添加吃的行为
    public function eat(){
        echo 'dog eat<br />';
    }

    //添加行为的触发的方法
    public function events() {
       return [
           'wang'=>'shout'
       ];
    }

    //行为要触发的方法
    public function shout($event){
        echo 'wang wang wang<br />';
    }
}