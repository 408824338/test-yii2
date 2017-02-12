<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProcductCategory */

$this->title = 'Create Procduct Category';
$this->params['breadcrumbs'][] = ['label' => 'Procduct Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procduct-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'list' => $list,
    ]) ?>

</div>
