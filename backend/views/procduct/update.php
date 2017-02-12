<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Procduct */

$this->title = 'Update Procduct: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Procducts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="procduct-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
         'categories' => $categories
    ]) ?>

</div>
