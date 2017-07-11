<?php
/* @var $this yii\web\View */
/* @var $model common\models\Article */

use yii\helpers\Html;
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content">
    <article class="article-item">
        <h1><?php echo $model->name ?></h1>

        <ul>
            <li>价格:<?php echo $model->price ?></li>
            <li>数量:<?php echo $model->amount ?></li>
            <li>备注:<?php echo $model->memo ?></li>
        </ul>

          <?php echo Html::a('加入购物车', ['add-card', 'product_id'=>$model->id]) ?>




    </article>
</div>