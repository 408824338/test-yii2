<?php

use yii\jui\DatePicker;
?>


<?= DatePicker::widget([
   'model' => $model,
    'attribute' => 'create_at',
   'language' => 'ru',
    'clientOptions' => [
        'dateFormat' => 'yy-mm-dd',
   ],
]) ?>
