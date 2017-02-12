<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use \yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%order_detail}}".
 *
 * @property integer $id
 * @property integer $order_id
 * @property string $product_price
 * @property integer $product_amount
 * @property integer $produce_id
 * @property string $remark
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Order $order
 * @property Procduct $produce
 */
class OrderDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_detail}}';
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
    public function rules()
    {
        return [
            [['order_id', 'product_amount', 'produce_id'], 'integer'],
            [['product_price'], 'number'],
             [['created_at', 'updated_at'], 'safe'],
            [['remark'], 'string', 'max' => 256],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['produce_id'], 'exist', 'skipOnError' => true, 'targetClass' => Procduct::className(), 'targetAttribute' => ['produce_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
          
            'id' => 'ID',
          
            'order_id' => '父订单id',
          
            'product_price' => '单个产品价格',
          
            'product_amount' => '产品数量',
          
            'produce_id' => '产品id',
          
            'remark' => '备注',
          
            'created_at' => '创建日期',
          
            'updated_at' => '更新日期',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduce()
    {
        return $this->hasOne(Procduct::className(), ['id' => 'produce_id']);
    }
}
