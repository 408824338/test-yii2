<?php
/**
 * Created by PhpStorm.
 * User: cmk
 * Date: 2017/2/12
 * Time: 12:24
 */

namespace backend\components\event;


use yii\base\Event;

class MailEvent extends Event {

    public $email;
    public $subject;
    public $content;

}