<?php

namespace rbac\controllers;

use common\models\Procduct;
use common\models\ProcductSearch;
use common\models\Cart;
use common\models\Order;
use common\models\OrderDetail;
use Prophecy\Call\Call;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\models\Account;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ClosureController extends Controller {

    function actionIndex() {

        //1
        /*
        $arr = [1, 2, 3, 4];
        array_walk($arr, create_function('$value', 'echo $value;')); //1234
        */

        $func = create_function('', 'echo "Function created dynamic";');

        $call = new Callme();
        $call(1398383823);

        $func = function (){
            echo "hello";
        };

        echo gettype($func);
        echo "<br />";
        echo get_class($func);

        echo "<br />";
        $name = 'TIPI Team';
        $func = function () use($name){
            echo 'hello,'.$name;
        };
        $func();
    }


}


class Callme{
    public function __invoke($phone_num) {
        echo "hello:".$phone_num;
    }
}
