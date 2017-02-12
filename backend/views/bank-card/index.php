<?php
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;



/* @var $this yii\web\View */
/* @var $searchModel backend\models\BankCardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'Bank Cards');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-card-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('frontend', 'Create Bank Card'), ['create'], ['class' => 'btn btn-success','id'=>'create','data-toggle'=>'modal','data-target'=>'#operate-modal']) ?>
    

    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'account_id',
            'user_type',
            'bank_name',
            'bank_branch_name',
            // 'bank_number',
            // 'bank_logo',
            // 'holder_name',
            // 'authorize_letter',
            // 'province_name',
            // 'city_name',
            // 'card_type',
            // 'auditor_id',
            // 'audit_at',
            // 'audit_status',
            // 'is_deleted',
            // 'audit_memo',
            // 'create_at',
            // 'update_at',

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
</div>


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