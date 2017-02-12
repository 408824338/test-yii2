<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bank_card".
 *
 * @property integer $id
 * @property integer $account_id
 * @property integer $user_type
 * @property string $bank_name
 * @property string $bank_branch_name
 * @property string $bank_number
 * @property string $bank_logo
 * @property string $holder_name
 * @property string $authorize_letter
 * @property string $province_name
 * @property string $city_name
 * @property integer $card_type
 * @property integer $auditor_id
 * @property integer $audit_at
 * @property integer $audit_status
 * @property integer $is_deleted
 * @property string $audit_memo
 * @property integer $create_at
 * @property integer $update_at
 *
 * @property Account $account
 */
class BankCard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bank_card';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'user_type', 'card_type', 'auditor_id', 'audit_at', 'audit_status', 'is_deleted', 'create_at', 'update_at'], 'integer'],
            [['create_at'], 'required'],
            [['bank_name'], 'string', 'max' => 32],
            [['bank_branch_name', 'bank_number', 'holder_name', 'province_name', 'city_name'], 'string', 'max' => 64],
            [['bank_logo', 'authorize_letter', 'audit_memo'], 'string', 'max' => 256],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['account_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
          
            'id' => 'ID',
          
            'account_id' => '用户帐户id ',//account(account_id),
          
            'user_type' => '用户类型 ',//1 企业，2 个人,
          
            'bank_name' => '银行名称',
          
            'bank_branch_name' => '支行名称',
          
            'bank_number' => '银行卡卡号',
          
            'bank_logo' => '银行logo',
          
            'holder_name' => '持有者姓名',//如果是银行卡类型为1 企业 则为企业名称,
          
            'authorize_letter' => '企业授权书',
          
            'province_name' => '省名',
          
            'city_name' => '市名',
          
            'card_type' => '银行卡类型',//1 企业（对公），2 个人（对私）,
          
            'auditor_id' => '审核者',//user(user_id),
          
            'audit_at' => '审核时间',
          
            'audit_status' => '认证状态',//1 审核中，2 已认证，3 审核未通过,4 已删除,
          
            'is_deleted' => '是否删除',//0 否,1是,
          
            'audit_memo' => '审核备注',
          
            'create_at' => '创建时间',
          
            'update_at' => '更新时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_id']);
    }
}
