<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Procduct */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Procducts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procduct-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'procduct_category_id',
            'name',
            'amount',
            'price',
            'status',
            'memo',
             ['attribute' => 'created_at', 'format' => ['date', 'php:Y-m-d H:i:s']],
             ['attribute' => 'updated_at', 'format' => ['date', 'php:Y-m-d H:i:s']],
        ],
    ]) ?>

</div>
