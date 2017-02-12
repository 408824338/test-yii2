<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProcductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procduct-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'procduct_category_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'amount') ?>

    <?= $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'memo') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'update_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>