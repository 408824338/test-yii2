<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Procduct */

$this->title = 'Create Procduct';
$this->params['breadcrumbs'][] = ['label' => 'Procducts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procduct-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
         'categories' => $categories
    ]) ?>

</div>
