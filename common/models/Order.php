<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $price
 * @property integer $status
 * @property string $memo
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property OrderDetail[] $orderDetails
 */
class Order extends \yii\db\ActiveRecord {

    public $min_price; //查询价格 最小值 
    public $max_price; //查询价格 最大值

    /**
     * @inheritdoc
     */

    public static function tableName() {
        return '{{%order}}';
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
    public function rules() {
        return [
                [['user_id', 'status', 'is_fahuo'], 'integer'],
                [['price', 'min_price', 'max_price'], 'number'],
                [['created_at', 'updated_at', 'is_fahuo'], 'safe'],
                [['memo'], 'string', 'max' => 256],
//            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'price' => '总价格',
            'min_price' => '价格 - ',
            'max_price' => ' - 价格',
            'status' => '业务状态', //(1 正常，0 停止),
            'memo' => '备注',
            'is_fahuo' => '是否发货',
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
                "0" => "非正常",
                "1" => "正常",
            ],
            "is_fahuo" => [
                "0" => "否",
                "1" => "是",
            ]
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails() {
        return $this->hasMany(OrderDetail::className(), ['order_id' => 'id']);
    }

    /**
     * 获取用户帐户(查用户Account表) 
     */
    static public function getAccountInfoByOrderID($order_id) {
        $sql = "SELECT order.status,order.price,account.user_id,account.balance,order.is_fahuo FROM `order` LEFT JOIN account ON account.user_id = order.user_id WHERE order.id = " . $order_id;
        // echo $sql;exit;
        return Yii::$app->db->createCommand($sql)->queryOne();
    }

    /**
     * 获取订单诚意情
     * @param type $order_id
     * @return array
     */
    static public function getOrderDetailByOrderId($order_id) {
        $sql = "SELECT	procduct.name,order_detail.product_price,order_detail.product_amount,order.is_fahuo  FROM order_detail";
        $sql .= " left join `order` on order.id = order_detail.order_id ";
        $sql .= " LEFT JOIN procduct ON procduct.id = order_detail.produce_id WHERE order_detail.order_id = $order_id ";
        return Yii::$app->db->createCommand($sql)->queryAll();
    }

}
