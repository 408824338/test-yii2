<?php
/**
 * Created by PhpStorm.
 * User: cmk
 * Date: 2017/2/25
 * Time: 18:15
 */

namespace backend\controllers;


use yii\web\Controller;

class DemoWidgetController extends Controller {



    public function actionIndex(){
        return $this->render('index');
    }

}