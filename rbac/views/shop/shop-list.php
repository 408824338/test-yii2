<?php 
use yii\helpers\Html;

use yii\bootstrap\ActiveForm;
?>
<style>
    ul.carlist{display: block;
               width: 100%;
               border-bottom: 1px #ccc solid;
               overflow: hidden;}   
    ul.carlist li{float: left;list-style: none;padding:5px 0px 0 0;boder-bottom:1px #ccc solid;display: block;width:100px;}
    
    .button_submit{float: right;border: 1px #ccc solid;padding: 5px 20px;}
    .tip{display: block;width:100%;padding:20px 0;}
</style>

<div class="tip">
    <?php if(Yii::$app->session->hasFlash('info')){ echo Yii::$app->session->getFlash('info');} ?>
</div>
<ul class="carlist">
    <li>产品名</li>
    <li>价格</li>
    <li>数量</li>
    <li>金额</li>
</ul>
 <?php $form = ActiveForm::begin([
            'action' => yii\helpers\Url::to(['card-submit']),
        ]) ?>
<?php foreach ($data as $i=>$_data) { ?>
    <ul class="carlist">
        <li><?php echo $_data['procduct_name']; ?></li>
        <li><?php echo $_data['price']; ?></li>
        <li><?php echo $_data['amount']; ?></li>
        <li><?php echo $_data['price']*$_data['amount']; ?></li>
    </ul>
<?php } ?>
    <?php // Html::a('提交', ['card-submit'],['class'=>'button_submit','data-confirm'=>'确定要提交吗？']) ?>

    <?php echo Html::submitButton('提交',['class'=>'button_submit']); ?>

<?php ActiveForm::end() ?>