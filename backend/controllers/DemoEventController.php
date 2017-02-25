<?php
/**
 * Created by PhpStorm.
 * User: cmk
 * Date: 2017/2/12
 * Time: 12:17
 */

namespace backend\controllers;


use backend\components\event\MailEvent;
use Codeception\Module\FunctionalHelper;
use yii\web\Controller;

/**
 * 简单测试一下 事件是怎样宝义与触发
 * 触发的地址：http://ysk.dev/admin/demo-event/index
 */
class DemoEventController extends Controller {

    const SEND_TEST = 'send_test';//1.定义要事件执行调用的方法名 on()和trigger(),会调用到

    public function init() {
        parent::init();
        $this->on(self::SEND_TEST,function (){
            echo "I'm a test event" ;
        });
    }

    public function actionIndex(){
        $this->trigger(self::SEND_TEST);
    }
}