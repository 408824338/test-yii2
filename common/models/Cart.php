<?php

namespace common\models;

use Yii;
use \yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%cart}}".
 *
 * @property string $cart_id
 * @property string $procduct_id
 * @property string $procduct_name
 * @property string $price
 * @property string $user_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cart}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['procduct_id',  'user_id'], 'integer'],
            [['procduct_name',],'required'],
            [['price','amount'], 'number'],
        ];
    }

        public function behaviors() {
        return [
            'timestamp' => [
                'class' => yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => function() {
                    return date('U');
                }, // unix timestamp  
            ],
           
            
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
          
            'cart_id' => 'Cart ID',
          
            'procduct_id' => 'Procduct ID',
          
            'procduct_name' => 'Procduct Name',
          
            'price' => 'Price',
          
            'user_id' => 'User ID',
          
            'created_at' => 'Created At',
          
            'updated_at' => 'Updated At',
        ];
    }
}
