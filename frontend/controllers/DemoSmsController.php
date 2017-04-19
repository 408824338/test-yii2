<?php
namespace frontend\controllers;

use ihacklog\sms\models\Sms;
use Yii;
use frontend\models\ContactForm;
use yii\web\Controller;

/**
 * Site controller
 */
class DemoSmsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actionIndex(){
        $sms = new Sms();
        $res = $sms->sendNotice('13418511035', [''], 1111);
        if($res){
            echo '发送完毕';
        }else{
            echo '发送失败';
        }
    }

    public function actionTest(){
        $res = Yii::$app->sms->send('18899998888', ['6532','5']);
        if($res){
            echo '发送完毕';
        }else{
            echo '发送失败';
        }
    }
}
