<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%testt_attachment}}".
 *
 * @property integer $id
 * @property integer $article_id
 * @property string $path
 * @property string $base_url
 * @property string $type
 * @property integer $size
 * @property string $name
 * @property integer $created_at
 * @property integer $order
 */
class TesttAttachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%testt_attachment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['testt_id', 'path'], 'required'],
            [['testt_id', 'size', 'created_at', 'order'], 'integer'],
            [['path', 'base_url', 'type', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
          
            'id' => 'ID',
          
            'testt_id' => 'testt_id',
          
            'path' => 'Path',
          
            'base_url' => 'Base Url',
          
            'type' => 'Type',
          
            'size' => 'Size',
          
            'name' => 'Name',
          
            'created_at' => 'Created At',
          
            'order' => 'Order',
        ];
    }
}
