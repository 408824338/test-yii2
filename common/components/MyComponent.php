<?php
/**
 * Created by PhpStorm.
 * User: cmk
 * Date: 2017/4/14
 * Time: 9:39
 */

namespace common\components;

use Yii;
use yii\base\Component;

class MyComponent extends Component {

    public $terry;

    public function welcome() {
        echo "Hello workld" . "<br />";

        //输出参数
        if (isset(Yii::$app->controller->module->params['water'])) {
            echo Yii::$app->controller->module->params['water'] . "<br />";
        }
        //输出组件里的参数
        echo $this->terry . "<br />";
    }
}