<?php
/**
 * Created by PhpStorm.
 * Author: HuangYeWuDeng
 * Date: 2/23/17
 * Time: 7:18 PM
 */

namespace common\behaviors;

use yii\base\Widget;
use yii\base\Behavior;

class CitySelectorBehavior extends Behavior
{
    public $targetRuntime;


    public function events()
    {
        return [
            //设置在winget运行之前运行
            Widget::EVENT_BEFORE_RUN => 'beforeRun',
            //`设置在winget运行之后运行
            Widget::EVENT_AFTER_RUN => 'afterRun',
        ];
    }

    public function beforeRun($event){
        echo 'Behavior调用代码之前代码运行'."<br />";
    }
    public function afterRun($event)
    {

        echo "<br />".'Behavior调用代码之后代码运行'."<br />";
    }

    public static function generateId()
    {
        return md5(time() . mt_rand(1000, 9999));
    }
}