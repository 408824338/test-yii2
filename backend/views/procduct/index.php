<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\ProcductCategory;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProcductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Procducts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procduct-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Procduct', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'procduct_category_id',
                'value' => function ($model) {
				
                   return $model->procductCategory ? $model->procductCategory->name : null;
                },
                'filter' => ArrayHelper::map(ProcductCategory::find()->all(), 'id', 'name')
            ],
            'name',
            'amount',
            'price',
            // 'status',
            // 'memo',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
