<?php
namespace rbac\controllers;

use Yii;
use frontend\models\ContactForm;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'thumb' => 'iutbay\yii2imagecache\ThumbAction',
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
            'set-locale'=>[
                'class'=>'common\actions\SetLocaleAction',
                'locales'=>array_keys(Yii::$app->params['availableLocales'])
            ],
            'test'=>[
                'class'=>'common\actions\TestAction',
                'param1'=>'参数1',
                'param2'=>'参数2',
                'beforeCallback' => [$this, 'registerSmsBeforeCallback'],
                'initCallback' => [$this, 'registerSmsInitCallback'],
            ]
        ];
    }

    /**
     * @author cmk
     *  第1步  自定义函数  initCallback
     *  获取表单输入框内容
     */
   public function registerSmsInitCallback($action){
        $action->mobile = '134185112232';
   }

    /**
     * @author cmk
     *  第2步  自定义函数  initCallback
     *  后端验证规则 是否输入正确
     * @param $action
     * @return bool
     */
    public function registerSmsBeforeCallback($action){

   }

    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->contact(Yii::$app->params['adminEmail'])) {
                Yii::$app->getSession()->setFlash('alert', [
                    'body'=>Yii::t('frontend', 'Thank you for contacting us. We will respond to you as soon as possible.'),
                    'options'=>['class'=>'alert-success']
                ]);
                return $this->refresh();
            } else {
                Yii::$app->getSession()->setFlash('alert', [
                    'body'=>\Yii::t('frontend', 'There was an error sending email.'),
                    'options'=>['class'=>'alert-danger']
                ]);
            }
        }

        return $this->render('contact', [
            'model' => $model
        ]);
    }
    
 public function actionError()
{
     echo 'xxx';exit;
    $exception = Yii::$app->errorHandler->exception;
    if ($exception !== null) {
        return $this->render('error', ['exception' => $exception]);
    }
}

}
