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
use common\behaviors\DogBehavior;
use horse003\event\Cat;
use horse003\event\Dog;
use horse003\event\Mourse;
use yii\base\Event;
use yii\web\Controller;

/**
 * 简单测试一下 事件是怎样宝义与触发
 * 触发的地址：http://ysk.dev/admin/demo-event/index
 */
class DemoEventController extends Controller {

    const SEND_TEST = 'send_test';//1.定义要事件执行调用的方法名 on()和trigger(),会调用到

    public function init() {
        parent::init();
        $this->on(self::SEND_TEST, function () {
            echo "I'm a test event";
        });
    }

    public function actionIndex() {
        $this->trigger(self::SEND_TEST);
    }

    /**
     * 动物事件
     * @author cmk
     */
    public function actionAnimal() {
        //触发系统的EVENT_AFTER_REQUEST
        \Yii::$app->on(\yii\base\Application::EVENT_AFTER_REQUEST, function () {
            echo 'event after request';
        });

        $cat = new Cat();
        $cat2 = new Cat();
        $mouse = new Mourse();
        $dog = new Dog();

        Event::on(Cat::className(), 'miao', function () {
            echo 'miao event has triggered<br/>';
        });
        $cat->shout();
        $cat2->shout();
    }

    public function actionDog() {
        $dog = new Dog();
        //输出绑定的行为
        $dog->eat(); //dog eat
        //1.给行为的变量赋值
        $dog->height = 50;
        //2.输出行为的变量
        echo $dog->height;
    }

    public function actionDogEvent() {
        $dog = new Dog();
        //触发狗类的行为
        $dog->trigger('wang');
    }

    public function actionDogObject(){
        $dog = new Dog();
        $dogBehavior = new DogBehavior();
        //绑定行为
        $dog->attachBehavior('dogBeh',$dogBehavior);
        //删除行为
        $dog->detachBehaviors('dogBeh');
        echo $dog->eat();
    }
}