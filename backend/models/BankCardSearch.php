<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BankCard;

/**
 * BankCardSearch represents the model behind the search form about `backend\models\BankCard`.
 */
class BankCardSearch extends BankCard
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'account_id', 'user_type', 'card_type', 'auditor_id', 'audit_at', 'audit_status', 'is_deleted', 'create_at', 'update_at'], 'integer'],
            [['bank_name', 'bank_branch_name', 'bank_number', 'bank_logo', 'holder_name', 'authorize_letter', 'province_name', 'city_name', 'audit_memo'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = BankCard::find();

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
            'account_id' => $this->account_id,
            'user_type' => $this->user_type,
            'card_type' => $this->card_type,
            'auditor_id' => $this->auditor_id,
            'audit_at' => $this->audit_at,
            'audit_status' => $this->audit_status,
            'is_deleted' => $this->is_deleted,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
        ]);

        $query->andFilterWhere(['like', 'bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'bank_number', $this->bank_number])
            ->andFilterWhere(['like', 'bank_logo', $this->bank_logo])
            ->andFilterWhere(['like', 'holder_name', $this->holder_name])
            ->andFilterWhere(['like', 'authorize_letter', $this->authorize_letter])
            ->andFilterWhere(['like', 'province_name', $this->province_name])
            ->andFilterWhere(['like', 'city_name', $this->city_name])
            ->andFilterWhere(['like', 'audit_memo', $this->audit_memo]);

        return $dataProvider;
    }
}
