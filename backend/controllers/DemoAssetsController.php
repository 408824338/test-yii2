<?php
/**
 * Created by PhpStorm.
 * User: cmk
 * Date: 2017/2/25
 * Time: 20:42
 */

namespace backend\controllers;


use yii\web\Controller;

class DemoAssetsController  extends Controller {

    public function actionIndex(){

        return $this->render('index');
    }
}