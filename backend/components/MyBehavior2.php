<?php

namespace backend\components;

use Codeception\Lib\Interfaces\ActiveRecord;
use Yii;
use yii\base\Behavior;

class MyBehavior2 extends Behavior {

    public $prop1;

    public function events() {
        return[
            \yii\db\ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            \yii\base\ActionFilter ::Be
        ];

    }

    public function beforeValidate($event) {
        var_dump('2222222');
        return true;
    }

    public function getProp(){
        $this->prop1;
    }

    public function setProp($value){
        $this->prop1 = $value;
    }

    public function foo(){
        echo 'xxxx';
    }




}

?>
