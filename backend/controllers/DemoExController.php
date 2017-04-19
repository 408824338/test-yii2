<?php
/**
 * Created by PhpStorm.
 * User: cmk
 * Date: 2017/3/12
 * Time: 22:10
 */

namespace backend\controllers;


use yii\base\Controller;

class DemoExController extends Controller {

    public function actionIndex(){

    }

    /***
     * rsa 使用
     *  var_dump($rsa->privateDecrypt($rsa->publicEncrypt('bar')));
     * @author cmk
     */
    public function actionRsa(){
           $s1= \Yii::$app->rsa->publicEncrypt('bar');
           echo \Yii::$app->rsa->privateDecrypt($s1);
    }
}