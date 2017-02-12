<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProcductCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use yii\bootstrap\ActiveForm;
use common\models\ProcductCategory;

$this->title = 'Procduct Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procduct-category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Procduct Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <table class="table table-striped table-bordered">
        <thead>
            <tr><th>#</th>
                <th><a href="" data-sort="name">名称</a></th>
                <th><a href="" data-sort="is_delete">是否删除</a></th>
                <th><a href="" data-sort="memo">备注</a></th>
                <th><a href="" data-sort="created_at">创建日期</a></th>
                <th><a href="" data-sort="updated_at">更新日期</a></th>
                <th><a href="" data-sort="name">操作</a></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($rows as $row) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['is_delete'] . "</td>";
                echo "<td>" . $row['memo'] . "</td>";
                echo "<td>" . date('Y-m-d H:i:s', $row['created_at']) . "</td>";
                echo "<td>" . date('Y-m-d H:i:s', $row['updated_at']) . "</td>";
                echo "<td>修改</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

