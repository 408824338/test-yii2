<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 */
class Test extends \yii\db\ActiveRecord {

    

    
    
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'test';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
        [['name'], 'required'],
         [[ 'send_at'], 'integer'],         
        [['created_at', 'updated_at','status'], 'safe'],
        [['name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @status
     */
    public static function Status($key = false) {
        $array = [
        '0' => '否',
        '1' => '是'
        ];
        if ($key === false) {
            return $array;
        } else {
            return isset($array[$key]) ? $array[$key] : '';
        }
    }
    
    /**
     *  下拉筛选
     *  @column string 字段
     *  @value mix 字段对应的值，不指定则返回字段数组
     *  @return mix 返回某个值或者数组
     */
    public static function dropDown ($column, $value = null)
    {
        $dropDownList = [
            "is_delete"=> [
                "0"=>"显示",
                "1"=>"删除",
            ],
            "is_hot"=> [
                "0"=>"否",
                "1"=>"是",
            ],
            "status"=> [
                "0"=>"否",
                "1"=>"是",
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
    

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
        'id' => 'ID',
        'name' => '名字',
        'status' => '状态',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        ];
    }

}
