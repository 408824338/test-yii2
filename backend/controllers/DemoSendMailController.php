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

class DemoSendMailController extends Controller {

    const SEND_MAIL = 'send_mail';

    public function init() {
        parent::init();
        $this->on(self::SEND_MAIL, ['backend\components\Mail', 'sendMail']);

    }

    /**
     * 1.配置里添加 mailer组件类
     * 2.添加组件 Mail类
     * 3.添加event类 MailEvent
     * @author cmk
     */
    public function actionSend() {
        try {
            $event = new MailEvent();
            $event->email = '823624320@qq.com';
            $event->subject = '测试事件邮件标题2';
            $event->content = '测试的事件的内容2';
            $this->trigger(self::SEND_MAIL, $event);
            echo '发送成功';
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}