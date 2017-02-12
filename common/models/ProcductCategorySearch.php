<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProcductCategory;
use yii\helpers\ArrayHelper;

/**
 * ProcductCategorySearch represents the model behind the search form about `common\models\ProcductCategory`.
 */
class ProcductCategorySearch extends ProcductCategory {

    /**
     * @inheritdoc
     */
    public $created_at_range;

    public function rules() {
        return [
            [['id', 'created_at', 'updated_at','pid','is_delete'], 'integer'],
            [['name', 'memo','created_at_range'], 'safe'],
        ];
//        return ArrayHelper::merge(
//                        [
//                        [['created_at_range'], 'safe'] // add a rule to collect the values
//                        ], parent::rules()
//        );
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = ProcductCategory::find();

//        var_dump($query);exit;
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'pid' => $this->pid,
            'is_delete' => $this->is_delete,
//            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'memo', $this->memo]);

//        var_dump($this->created_at_range);
        if (!empty($this->created_at_range) && strpos($this->created_at_range, '-') !== false) {
            list($start_date, $end_date) = explode(' - ', $this->created_at_range);
            $query->andFilterWhere(['between', 'created_at', strtotime($start_date), strtotime($end_date)]);
        }


//        $query->orderBy([ 'pid' => SORT_ASC ,'id' => SORT_DESC]);
        //var_dump($dataProvider);exit;
        return $dataProvider;
    }

}
