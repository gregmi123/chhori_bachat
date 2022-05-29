<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Withdraw;

/**
 * WithdrawSearch represents the model behind the search form of `app\models\Withdraw`.
 */
class WithdrawSearch extends Withdraw
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fk_chori', 'fk_dismiss', 'fk_bank', 'fk_account', 'fk_user_id', 'fk_municipal', 'fk_economic_year', 'fk_month', 'fk_province', 'fk_district'], 'integer'],
            [['amount', 'created_date'], 'safe'],
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
        $query = Withdraw::find();

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
            'fk_chori' => $this->fk_chori,
            'fk_dismiss' => $this->fk_dismiss,
            'fk_bank' => $this->fk_bank,
            'fk_account' => $this->fk_account,
            'fk_user_id' => $this->fk_user_id,
            'fk_municipal' => $this->fk_municipal,
            'fk_economic_year' => $this->fk_economic_year,
            'fk_month' => $this->fk_month,
            'fk_province' => $this->fk_province,
            'fk_district' => $this->fk_district,
        ]);

        $query->andFilterWhere(['like', 'amount', $this->amount])
            ->andFilterWhere(['like', 'created_date', $this->created_date]);

        return $dataProvider;
    }
}
