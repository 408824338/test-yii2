<?php

namespace common\models;

use Yii;
use \yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%procduct_category}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $memo
 * @property integer $create_date
 * @property integer $update_date
 *
 * @property Procduct[] $procducts
 */
class ProcductCategory extends \yii\db\ActiveRecord {

    public static $_catetory_list = [];

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%procduct_category}}';
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
        ];
    }

    static public function get($parentId = 0, $array = [], $level = 0, $add = 2, $repeat = '　') {
        $strRepeat = '';
        if ($level > 1) {
            for ($j = 0; $j < $level; $j++) {
                $strRepeat .= $repeat;
            }
        }

        $newArray = array();
        foreach ((array) $array as $v) {
            if ($v['pid'] == $parentId) {
                $item = (array) $v;
                $item['name'] = $strRepeat . (isset($v['title']) ? $v['title'] : $v['name']);
                $newArray[] = $item;

                $tempArray = self::get($v['id'], $array, ($level + $add), $add, $repeat);
                if ($tempArray) {
                    $newArray = array_merge($newArray, $tempArray);
                }
            }
        }
        return $newArray;
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['name'], 'required'],
                [['pid'], 'number'],
                [['created_at', 'updated_at', 'is_delete'], 'integer'],
                [['created_at', 'updated_at'], 'safe'],
                [['name'], 'string', 'max' => 32],
                [['memo'], 'string', 'max' => 256],
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

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'pid' => '分类',
            'name' => '名称',
            'memo' => '备注',
            'is_delete' => '是否删除',
            'created_at' => '创建日期',
            'updated_at' => '更新日期',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcducts() {
        return $this->hasMany(Procduct::className(), ['procduct_category_id' => 'id']);
    }

    /**
     * 获取所有的分类
     */
    public function getCategories() {
        $data = self::find()->all();
        $data = ArrayHelper::toArray($data);
        return $data;
    }

    /**
     * 遍历出各个子类 获得树状结构的数组
     */
    public static function getTree($data, $pid = 0, $lev = 1) {
        $tree = [];
        foreach ($data as $value) {
            if ($value['pid'] == $pid) {
                $value['name'] = str_repeat('|___', $lev) . $value['name'];
                $tree[] = $value;
                $tree = array_merge($tree, self::getTree($data, $value['id'], $lev + 1));
            }
        }
        return $tree;
    }

    /**
     * 得到相应  id  对应的  分类名  数组
     */
    public function getOptions() {
        if (!self::$_catetory_list) {
            $data = $this->getCategories();
            $tree = $this->getTree($data);
            $list = ['顶级分类'];
            foreach ($tree as $value) {
                $list[$value['id']] = $value['name'];
            }
            self::$_catetory_list = $list;
            return $list;
        }
        return self::$_catetory_list;
    }

    /**
     * 获取指定的栏目名
     * @param type $id
     * @return string
     */
    public function getOptionDetail($id) {
        if (!$id)
            return '|___';
        return self::$_catetory_list[$id];
    }

    static public function getOptionsByStatic() {
        if (self::$_catetory_list) {
            return self::$_catetory_list;
        } else {
            $this->getOptions();
        }
    }

}
