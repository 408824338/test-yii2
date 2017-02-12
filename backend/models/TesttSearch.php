<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Testt;

/**
 * TesttSearch represents the model behind the search form about `backend\models\Testt`.
 */
class TesttSearch extends Testt {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
        [['id', 'created_at', 'updated_at', 'status'], 'integer'],
        [['name', 'start_at', 'end_at'], 'safe'],
        ];
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
        $query = Testt::find();

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
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at,
        'status' => $this->status,
//            'start_at' => $this->start_at,
//        'end_at' => $this->end_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);


        if ($this->start_at) {
            $startAt = strtotime($this->start_at);
            $startAtEnd = $startAt + 24 * 3600;
            $query->andWhere("start_at >= {$startAt}");
        }

        if ($this->end_at) {
            $endAt = strtotime($this->end_at);
            $endAtEnd = $endAt + 24 * 3600;
            $query->andWhere(" end_at <= {$endAtEnd}");
        }

      //   echo $query->createCommand()->getRawSql(); 
        return $dataProvider;
    }

}
