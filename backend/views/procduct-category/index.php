<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProcductCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use yii\bootstrap\ActiveForm;
use common\models\ProcductCategory;
use jino5577\daterangepicker\DateRangePicker;

$this->title = 'Procduct Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procduct-category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a('Create Procduct Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?php Pjax::begin(); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        "options" => [
            // ...其他设置项
            "id" => "grid"
        ],
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                "class" => "yii\grid\CheckboxColumn",
                "name" => "id",
            ],
            'name',
                [
                'attribute' => 'pid',
                'value' => function ($model) {
                    return $model->getOptionDetail($model->pid);
                },
                'filter' => ProcductCategory::getOptionsByStatic()
            ],
                ["attribute" => "is_delete",
                "value" => function ($model) {
                    return Yii::$app->lookup->item('procduct_category_is_delete', $model->is_delete);
                },
                "filter" => Yii::$app->lookup->items('procduct_category_is_delete'),
            ],
            'memo',
                [
                // the attribute
                'attribute' => 'created_at',
                // format the value
                'value' => function ($model) {
                    return date('Y-m-d H:i:s', $model->created_at);
                },
                // some styling? 
                'headerOptions' => [
                    'class' => 'col-md-2'
                ],
                // here we render the widget
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
//                                'language'=>$config['language'],
                    'attribute' => 'created_at_range',
                    'pluginOptions' => [
//				'format' => 'Y-m-d H:i:s',
                        'locale' => [
                            'format' => 'YYYY-MM-DD',
                            'applyLabel' => '确定',
                            'cancelLabel' => '取消',
                            'fromLabel' => '起始时间',
                            'toLabel' => '结束时间',
                            'customRangeLabel' => '自定义',
                            'daysOfWeek' => ['日', '一', '二', '三', '四', '五', '六'],
                            'monthNames' => ['一月', '二月', '三月', '四月', '五月', '六月',
                                '七月', '八月', '九月', '十月', '十一月', '十二月'],
                            'firstDay' => 1
                        ],
                        'autoUpdateInput' => false
                    ]
                ])
            ],
//                ['attribute' => 'created_at', 'format' => ['date', 'php:Y-m-d H:i:s']],
            ['attribute' => 'updated_at', 'format' => ['date', 'php:Y-m-d H:i:s']],
                ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?></div>

<?= Html::a("批量删除", "javascript:void(0);", ["class" => "btn btn-success gridview", 'data-confirm' => '是否删除']) ?>



<?php
$this->registerJs('
$(".gridview").on("click", function () {
//注意这里的$("#grid")，要跟我们第一步设定的options id一致
    var keys = $("#grid").yiiGridView("getSelectedRows");
    var _url = "/admin/procduct-category/delete-all?delete_id="+keys;
   // console.log(_url);
    $.get(_url,function(data,status){
        alert("数据: " + data.meg);
        window.location.reload(); 
   })
});
');
?>
