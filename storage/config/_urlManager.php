<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
return [
    'class'=>'yii\web\UrlManager',
    'enablePrettyUrl'=>true,
    'showScriptName'=>false,
    'rules'=> [
        ['pattern'=>'cache/<path:(.*)>', 'route'=>'glide/index', 'encodeParams' => false]
    ]
    
    //http://ysk.dev/storage/web/cache/1/IPtH1b4kXpdH7kdQXgMsrOVbwqTGYwJd.png?w=100&s=a9549b95475bdc4b0ed1d1efb29ba941
];
