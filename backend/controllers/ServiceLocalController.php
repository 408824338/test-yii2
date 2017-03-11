<?php
/**
 * Created by PhpStorm.
 * User: cmk
 * Date: 2017/3/11
 * Time: 23:00
 */

namespace backend\controllers;


use yii\base\Controller;
use yii\di\ServiceLocator;

class ServiceLocalController extends Controller {


    public function actionIndex() {
        ///男司机
        //下面访问car类的时候,告诉他Driver是接口不是class
        \Yii::$container->set('backend\controllers\Driver','backend\controllers\ManDriver');
        $s1 = new ServiceLocator();
        $s1->set('car',['class'=>'backend\controllers\Car']);
        $car = $s1->get('car');
        $car->run();
        //女司机
        \Yii::$container->set('backend\controllers\Driver','backend\controllers\WomanDriver');
        $s1 = new ServiceLocator();
        $s1->set('car',['class'=>'backend\controllers\Car']);
        $car = $s1->get('car');
        $car->run();
    }

}

interface Driver{
    public function driver();
}

class ManDriver implements Driver {
    public function driver() {
        echo 'i am an old man<br />';
    }
}

class WomanDriver implements Driver{
    public function driver() {
        echo 'i am an woman driver<br />';
    }
}

class Car {
    private $_driver = null;

    public function __construct(Driver $driver) {
        $this->_driver = $driver;
    }

    public function run() {
        $this->_driver->driver();
    }
}