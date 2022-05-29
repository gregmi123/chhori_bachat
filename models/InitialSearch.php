<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Initial;

/**
 * InitialSearch represents the model behind the search form of `app\models\Initial`.
 */
class InitialSearch extends Initial
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fk_year', 'fk_province_id', 'fk_user', 'fk_municipal', 'fk_district', 'status'], 'integer'],
            [['created_date', 'payment_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Initial::find();

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
            'fk_year' => $this->fk_year,
            'fk_province_id' => $this->fk_province_id,
            'fk_user' => $this->fk_user,
            'fk_municipal' => $this->fk_municipal,
            'fk_district' => $this->fk_district,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'created_date', $this->created_date])
            ->andFilterWhere(['like', 'payment_id', $this->payment_id]);

        return $dataProvider;
    }
}
