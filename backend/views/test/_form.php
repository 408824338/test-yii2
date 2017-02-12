<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Test */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="test-form">

<?php $form = ActiveForm::begin([
    'id' => 'test-id',
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form']),
]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
     <?php echo $form->field($model, 'status')->dropDownList( $model::Status()) ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        
       
    </div>

    <?php ActiveForm::end(); ?>

</div>
