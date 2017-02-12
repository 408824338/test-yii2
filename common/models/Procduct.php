<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%procduct}}".
 *
 * @property integer $id
 * @property integer $procduct_category_id
 * @property string $name
 * @property integer $amount
 * @property string $price
 * @property integer $status
 * @property string $memo
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property OrderDetail[] $orderDetails
 * @property ProcductCategory $procductCategory
 */
class Procduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%procduct}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['procduct_category_id', 'amount', 'status'], 'integer'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 32],
            [['memo'], 'string', 'max' => 256],
            [['procduct_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProcductCategory::className(), 'targetAttribute' => ['procduct_category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
          
            'id' => 'ID',
          
            'procduct_category_id' => '产品分类',
          
            'name' => '名称',
          
            'amount' => '数量 ',
          
            'price' => '产品价格',
          
            'status' => '业务状态',//(1 正常，0 停止),
          
            'memo' => '备注',
          
            'created_at' => '创建日期',
          
            'updated_at' => '更新日期',
        ];
    }
    
    /**
     *  下拉筛选
     *  @column string 字段
     *  @value mix 字段对应的值，不指定则返回字段数组
     *  @return mix 返回某个值或者数组
     */
    public static function dropDown($column, $value = null) {
        $dropDownList = [
            "status" => [
                "0" => "停止",
                "1" => "正常",
            ],
                //有新的字段要实现下拉规则，可像上面这样进行添加
                // ......
        ];
        //根据具体值显示对应的值
        if ($value !== null)
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        //返回关联数组，用户下拉的filter实现
        else
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
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
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetail::className(), ['produce_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcductCategory()
    {
//       $arr = $this->hasOne(ProcductCategory::className(), ['id' => 'procduct_category_id']);
//       var_dump($arr);exit;
        return $this->hasOne(ProcductCategory::className(), ['id' => 'procduct_category_id']);
    }
}
