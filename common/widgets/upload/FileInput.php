<?php

namespace common\widgets\upload;

use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * Created by PhpStorm.
 * User: cmk
 * Date: 2017/2/25
 * Time: 21:37
 */

/**
 * 图片上传插件
 *
 * @example
 * 同步单图上传的使用
 * ```php
 *   echo $form->field($model, 'image_url')->widget('common\widgets\upload\FileInput');
 * ```
 *
 * @see http://www.manks.top
 */
class FileInput extends InputWidget {
    public $clientOptions = [];

    public function run() {
        // 注册客户端所需要的资源
        $this->registerClientScript();
        // 构建html结构
        if ($this->hasModel()) {
            $this->options = array_merge($this->options, $this->clientOptions);
            $file = Html::activeInput('file', $this->model, $this->attribute, $this->options);
            // 如果当前模型有该属性值，则默认显示
            if ($image = $this->model->{str_replace(['[', ']'], '', $this->attribute)}) {
                $li = Html::tag('li', '', ['class' => 'uploader__file', 'style' => 'background: url(' . Yii::$app->params['imageServer'] . $image . ') no-repeat; background-size: 100%;']);
            }
            $uploaderFiles = Html::tag('ul', isset($li) ? $li : '', ['class' => 'uploaderFiles']);
            $inputButton = Html::tag('div', $file, ['class' => 'input-box']);
            echo Html::tag('div', $uploaderFiles . $inputButton, ['class' => 'file-div']);
        } else {
            throw new InvalidConfigException("'model' must be specified.");
        }

    }

    /**
     * Registers the needed client script and options.
     */
    public function registerClientScript() {
        $view = $this->getView();
        FileInputAsset::register($view);
    }

}