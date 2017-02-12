<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Test;

/**
 * TestSearch represents the model behind the search form about `backend\models\Test`.
 */
class TestSearch extends Test {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
        [['id', 'status'], 'integer'],
        [['name', 'created_at', 'updated_at'], 'safe'],
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
        $query = Test::find();

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
//        'created_at' => $this->created_at,
        'status' => $this->status,
        'updated_at' => $this->updated_at,
       
        ]);

     //  if($this->name){
              $query->andFilterWhere(['like', 'name', $this->name]);
    //   }

      if ($this->created_at) {     
            $createdAt = strtotime($this->created_at);
            $createdAtEnd = $createdAt + 24 * 3600;
            $query->andWhere("created_at >= {$createdAt} AND created_at <= {$createdAtEnd}");
        }

        return $dataProvider;
    }

}
