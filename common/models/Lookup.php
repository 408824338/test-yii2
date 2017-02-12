<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%lookup}}".
 *
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property integer $code
 * @property string $comment
 * @property integer $active
 * @property integer $sort_order
 * @property integer $created_at
 * @property integer $updated_at
 */
class Lookup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lookup}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'active', 'sort_order', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string'],
            [['type', 'name'], 'string', 'max' => 100],
            [['type', 'name'], 'unique', 'targetAttribute' => ['type', 'name'], 'message' => 'The combination of Type and Name has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
          
            'id' => 'ID',
          
            'type' => 'Type',
          
            'name' => 'Name',
          
            'code' => 'Code',
          
            'comment' => 'Comment',
          
            'active' => 'Active',
          
            'sort_order' => 'Sort Order',
          
            'created_at' => 'Created At',
          
            'updated_at' => 'Updated At',
        ];
    }
}
