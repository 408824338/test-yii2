<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Order;
use common\models\User;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
             [
                'attribute' => 'user_id',
                'value' => function ($model) {
				
                   return $model->user ? $model->user->username : null;
                },
                'filter' => ArrayHelper::map(User::find()->all(), 'id', 'username')
            ],
            'price',
            'status',
             ["attribute" => "status",
                "value" => function ($model) {
                    return $model::dropDown("status", $model->status);
                },
                "filter" => Order::dropDown("status"),
            ],
             ["attribute" => "is_fahuo",
                "value" => function ($model) {
                    return $model::dropDown("is_fahuo", $model->is_fahuo);
                },
                "filter" => Order::dropDown("is_fahuo"),
            ],
            'memo',
            // 'create_date',
            // 'update_date',

            ['class' => 'yii\grid\ActionColumn', "template" => "{view}",],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
