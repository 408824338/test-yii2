<?php
/* @var $this yii\web\View */
$this->title = '商品列表';
?>
<div id="article-index">
    <h1>商品列表</h1>
    <?php echo \yii\widgets\ListView::widget([
        'dataProvider'=>$dataProvider,
        'pager'=>[
            'hideOnSinglePage'=>true,
        ],
        'itemView'=>'_item'
    ])?>
</div>