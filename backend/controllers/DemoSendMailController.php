<?php
/**
 * Created by PhpStorm.
 * User: cmk
 * Date: 2017/2/12
 * Time: 12:17
 */

namespace backend\controllers;


use backend\components\event\MailEvent;
use yii\web\Controller;

/**
 * 功能描述，通过event的事件要触发邮件发送
 * 触发的地址：http://ysk.dev/admin/demo-send-mail/send
 */
class DemoSendMailController extends Controller {


    const SEND_MAIL = 'send_mail';//1.定义要事件执行调用的方法名 on()和trigger(),会调用到

    public function init() {
        parent::init();
        /**
         * 2.
         * 预先绑定加载事件类-要触发的功能
         * (注：触发方法 sendMail 位于 'backend\components\Mail')，等待触发
         * 待指定的方法，如 http://ysk.dev/admin/demo-send-mail/send 则会触发
         */
        $this->on(self::SEND_MAIL, ['backend\components\Mail', 'sendMail']);

    }

    /**
     * 3.
     * 触发的方法
     * a.配置里添加 mailer组件类
     * b.添加组件 Mail类
     * c.添加event类 MailEvent
     * @author cmk
     */
    public function actionSend() {
        try {
            //1.配置邮件行为类
            $event = new MailEvent();
            $event->email = '823624320@qq.com';
            $event->subject = '测试事件邮件标题2';
            $event->content = '测试的事件的内容2';
            //
            /**
             * 2.触发函数运行
             * self::SEND_MAIL //要触发的函数方法（跟上面on()里的方法名一致）
             * $event  //上面配置的参数，传过去
             */
            $this->trigger(self::SEND_MAIL, $event);
            echo '发送成功';
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}