<?php
/**
 * Created by PhpStorm.
 * User: cmk
 * Date: 2017/2/12
 * Time: 12:16
 */

namespace backend\components;


class Mail {

    public static function sendMail($event) {
        //1.调用邮件类
        $mail = \Yii::$app->mailer->compose();
        $mail->setTo($event->email);//要发送给那个人的邮箱
        $mail->setSubject($event->subject);//邮件主题
        $mail->setTextBody($event->content);//发布纯文字文本
        //邮件发送
        return $mail->send();
    }

}