<?php


namespace backend\components;

use Yii;
use yii\base\Object;

class ThemeControl extends \yii\base\ActionFilter{
    
    
public function init(){
    /**
     *  动态主题的切换 
     * http://ysk.dev/admin/test/index?switch=1  访问 
     * http://ysk.dev/admin/test/index?switch=0  访问圣诞主题
     */
     $switch = intval(Yii::$app->request->get('switch'));
     $theme = $switch ? 'spring' : 'christmas';
     Yii::$app->view->theme = Yii::createObject([
          'class'=>'yii\base\Theme',
            'pathMap'=>[
               '@app/views'=>[
                    "@app/themes/{$theme}",
               ]
            ]
     ]);
}
    
}