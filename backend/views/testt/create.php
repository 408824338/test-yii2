<?php

use yii\helpers\Html;

use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\Testt */

$this->title = 'Create Testt';
$this->params['breadcrumbs'][] = ['label' => 'Testts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testt-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
