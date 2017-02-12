<?php

namespace backend\models;

use trntv\filekit\behaviors\UploadBehavior;
use yii\behaviors\TimestampBehavior;
use \yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "testt".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property integer $start_at
 * @property integer $end_at
 */
class Testt extends \yii\db\ActiveRecord {

    /**
     * @var array
     */
    public $attachments;

    /**
     * @var array
     */
    public $thumbnail;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'testt';
    }

    public function behaviors() {
        return [
            TimestampBehavior::className(),
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
            //附件 支付上传多个文件        
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'attachments',
                'multiple' => true,
                'uploadRelation' => 'testtAttachments',
                'pathAttribute' => 'path',
                'baseUrlAttribute' => 'base_url',
                'orderAttribute' => 'order',
                'typeAttribute' => 'type',
                'sizeAttribute' => 'size',
                'nameAttribute' => 'name',
            ],
            //上传图片
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'thumbnail',
                'pathAttribute' => 'thumbnail_path',
                'baseUrlAttribute' => 'thumbnail_base_url'
            ]
        ];
    }

    //插入数据之前的数据操作
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->start_at = strtotime($this->start_at);
            $this->end_at = strtotime($this->end_at);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['name', 'detail','body','content'], 'required'],
                [['status'], 'integer'],
                [['detail','body','content'], 'string'], //编辑器里定义定义这个,否则不能保存
            [['id', 'created_at', 'updated_at', 'start_at', 'end_at', 'thumbnail', 'attachments'], 'safe'],
                [['name'], 'string', 'max' => 30],
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
            "is_delete" => [
                "0" => "显示",
                "1" => "删除",
            ],
            "is_hot" => [
                "0" => "否",
                "1" => "是",
            ],
            "status" => [
                "0" => "否",
                "1" => "是",
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
            'name' => '姓名',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => '状态', //1为是 0为否,
            'detail' => '详情',
            'thumbnail' => '缩略图',
            'attachments' => '附件',
            'start_at' => '开始时间',
            'end_at' => '结束时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTesttAttachments() {
        return $this->hasMany(TesttAttachment::className(), ['testt_id' => 'id']);
    }

}
