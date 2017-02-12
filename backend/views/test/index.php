<?php
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Test;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Test', ['create'], ['class' => 'btn btn-success','id'=>'create','data-toggle'=>'modal','data-target'=>'#operate-modal']) ?>
    

    </p>
    
    
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
//          [ "attribute" => "status",
//            "value" => function ($model) {
//                return Test::dropDown("status", $model->status);
//            },
//            "filter" => Test::dropDown("status"),
//        ],
          [ "attribute" => "status",
            "value" => function ($model) {
                return $model::dropDown("status", $model->status);
            },
            "filter" => Test::dropDown("status"),
        ],
//           'created_at:datetime',
            ['attribute'=>'created_at','format'=>['date','php:Y-m-d H:i:s']],
          ['attribute'=>'updated_at','format'=>['date','php:Y-m-d H:i:s']],

           [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}  {delete}',
                'header' => '操作',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a("更新", $url, [
                                'title' => '', 
                                // btn-update 目标class
                                'class' => 'btn btn-default btn-update',
                                'data-toggle' => 'modal',
                                'data-target' => '#operate-modal',
                        ]); 
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('删除', $url, [
                            'title' => '',
                            'class' => 'btn btn-default',
                            'data' => [
                                'confirm' => '确定要删除么?',
                                'method' => 'post',
                            ],
                        ]); 
                    },
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>


<?php
// 创建modal
Modal::begin([
    'id' => 'operate-modal',
    'header' => '<h4 class="modal-title"></h4>',
]); 

Modal::end();


// 创建
$requestCreateUrl = Url::toRoute('create');

// 更新
$requestUpdateUrl = Url::toRoute('update');
$js = <<<JS
    
    // 创建操作
    $('#create').on('click', function () {
        $('.modal-title').html('创建');
        $.get('{$requestCreateUrl}',
            function (data) {
                $('.modal-body').html(data);
            }  
        );
    });

    // 更新操作
    $('.btn-update').on('click', function () {
        $('.modal-title').html('信息');
        $.get('{$requestUpdateUrl}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }  
        );
    });
JS;
$this->registerJs($js);

?>