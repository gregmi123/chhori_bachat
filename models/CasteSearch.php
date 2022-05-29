<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Caste;

/**
 * CasteSearch represents the model behind the search form of `app\models\Caste`.
 */
class CasteSearch extends Caste
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'fk_user_id', 'fk_province_id', 'fk_district_id', 'fk_municipal_id', 'status'], 'integer'],
            [['created_date'], 'safe'],
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
        
        $query = Caste::find();
        

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
            'name' => $this->name,
            'fk_user_id' => $this->fk_user_id,
            'fk_province_id' => $this->fk_province_id,
            'fk_district_id' => $this->fk_district_id,
            'fk_municipal_id' => $this->fk_municipal_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'created_date', $this->created_date]);

        return $dataProvider;
    }
}
