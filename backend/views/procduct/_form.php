<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Procduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procduct-form">

    <?php $form = ActiveForm::begin(); ?>

      <?php echo $form->field($model, 'procduct_category_id')->dropDownList(\yii\helpers\ArrayHelper::map(
            $categories,
            'id',
            'name'
        ), ['prompt'=>'']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <? $form->field($model, 'status')->textInput() ?>
    <?php echo $form->field($model, 'status')->dropDownList( $model::dropDown('status')) ?>

    <?= $form->field($model, 'memo')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
