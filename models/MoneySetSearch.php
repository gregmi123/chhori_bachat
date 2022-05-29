<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MoneySet;

/**
 * MoneySetSearch represents the model behind the search form of `app\models\MoneySet`.
 */
class MoneySetSearch extends MoneySet
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fk_user_id', 'fk_municipal_id', 'initial_payment', 'previous_payment', 'status'], 'integer'],
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
        $user_id = \yii::$app->user->id;
        $user_details = Users::findOne(['id'=>$user_id]);
        
        $query = MoneySet::find()->where(['fk_user_id'=>$user_id])->andWhere(['fk_municipal_id'=>$user_details->fk_municipal_id]);
  

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>array('pagesize'=>10),
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
            'fk_user_id' => $this->fk_user_id,
            'fk_municipal_id' => $this->fk_municipal_id,
            'initial_payment' => $this->initial_payment,
            'previous_payment' => $this->previous_payment,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'created_date', $this->created_date]);

        return $dataProvider;
    }
}
