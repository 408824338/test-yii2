<?php
/**
 * Created by PhpStorm.
 * User: cmk
 * Date: 2017/3/11
 * Time: 23:00
 */

namespace backend\controllers;


use yii\base\Controller;
use yii\di\Container;

class DiController extends Controller {

    public function actionIndex() {
        $container = new Container();
        $container->set('backend\controllers\Driver','backend\controllers\ManDriver');
        $man_car = $container->get('backend\controllers\Car');
        $man_car->run();

        $container->set('backend\controllers\Driver','backend\controllers\WomanDriver');
        $woman_car = $container->get('backend\controllers\Car');
        $woman_car->run();

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