<?php
/**
 * @var $this yii\web\View
 * @var $model common\models\Article
 */
use yii\helpers\Html;

?>
<hr/>
<div class="article-item row">
    <div class="col-xs-12">
        <h2 class="article-title">
            <?php echo Html::a($model->name, ['view', 'detail_id'=>$model->id]) ?>
        </h2>
        <div class="article-meta">
            <span class="article-date">
                <?php echo Yii::$app->formatter->asDatetime($model->created_at) ?>
            </span>,
            <span class="article-category">
       
            </span>
        </div>
        <div class="article-content">
     
   
        </div>
    </div>
</div>
