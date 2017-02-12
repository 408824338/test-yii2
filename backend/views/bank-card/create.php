<?php

use yii\helpers\Html;

use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\BankCard */

$this->title = Yii::t('frontend', 'Create Bank Card');
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Bank Cards'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-card-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
