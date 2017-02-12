<?php
/**
 * Created by PhpStorm.
 * User: cmk
 * Date: 2017/1/20
 * Time: 14:22
 */

namespace common\actions;


use yii\base\Action;

/**
 * Class TestAction
 * @package common\actions
 *
 * Example
 * @url  http://ysk.dev/site/test?get=abc
 *  public function actions(){
 *     return [
*           'test'=>[
 *          'class'=>'common\actions\TestAction',
 *          'param1'=>'参数1',
 *           'param2'=>'参数2',
 *              'initCallback'=> 'initCallback' => [$this, 'registerSmsInitCallback'],
 *              'beforeCallback' => [$this, 'registerSmsBeforeCallback'],
 *          ]
 *    ]
 * }
 */
class TestAction extends Action
{
    public $param1 = null;
    public $param2 = null;

    /**
     * @var string 手机号码
     */
    public $mobile;
    /**
     * @var \Closure
     * 自定义函数  初始化函数  第1步
     */
    public $initCallback;


    /**
     * @var \Closure
     * 自定义函数    初始化函数  第2步
     */
    public $beforeCallback;



    public function run($get = null)
    {
        //自定义函数 使用
        if($this->initCallback && ($this->initCallback instanceof \Closure || is_callable($this->initCallback))){
            call_user_func_array($this->initCallback,[$this]);
        }

        return $this->controller->render('test', [
            'get' => $get,
            'param1' => $this->param1,
            'param2' => $this->param2,
            'mobile'=>$this->mobile
        ]);
    }

}