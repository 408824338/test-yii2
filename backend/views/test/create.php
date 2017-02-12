<?php

use yii\helpers\Html;

use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\Test */

$this->title = 'Create Test';
$this->params['breadcrumbs'][] = ['label' => 'Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
