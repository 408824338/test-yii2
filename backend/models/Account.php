<?php

namespace backend\models;

use Yii;
use common\models\User;
use yii\behaviors\TimestampBehavior;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%account}}".
 *
 * @property integer $id
 * @property string $balance
 * @property string $frozen
 * @property string $reward
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $id0
 * @property BankCard[] $bankCards
 */
class Account extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at','user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['balance', 'frozen', 'reward'], 'number'],
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
          
            'id' => '选择用户',// fk user(user_id),
          
            'balance' => '余额',
          
            'frozen' => '冻结金额',
          
            'reward' => '奖励金额',
          
            'created_at' => '创建时间',
          
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBankCards()
    {
        return $this->hasMany(BankCard::className(), ['account_id' => 'id']);
    }
    
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
//       $arr = $this->hasOne(ProcductCategory::className(), ['id' => 'procduct_category_id']);
//       var_dump($arr);exit;
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
