<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BankCard */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bank-card-form">

<?php $form = ActiveForm::begin([
    'id' => 'bank-card-id',
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form']),
]); ?>

    <?= $form->field($model, 'account_id')->textInput() ?>

    <?= $form->field($model, 'user_type')->textInput() ?>

    <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_branch_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_logo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'holder_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'authorize_letter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'province_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'card_type')->textInput() ?>

    <?= $form->field($model, 'auditor_id')->textInput() ?>

    <?= $form->field($model, 'audit_at')->textInput() ?>

    <?= $form->field($model, 'audit_status')->textInput() ?>

    <?= $form->field($model, 'is_deleted')->textInput() ?>

    <?= $form->field($model, 'audit_memo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_at')->textInput() ?>

    <?= $form->field($model, 'update_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('frontend', 'Create') : Yii::t('frontend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
