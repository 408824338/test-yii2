<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProcductCategory */

$this->title = 'Update Procduct Category: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Procduct Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="procduct-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'list' => $list,
    ]) ?>

</div>
