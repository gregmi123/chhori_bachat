<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PaymentChori;

/**
 * PaymentChoriSearch represents the model behind the search form of `app\models\PaymentChori`.
 */
class PaymentChoriSearch extends PaymentChori
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fk_chori_bachat', 'fk_bank_details', 'fk_user_id', 'fk_municipal', 'status'], 'integer'],
            [['post_date','fk_chori_account_details' ,'amount', 'created_date'], 'safe'],
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
        $user = \yii::$app->user->id;
        $user_details = Users::findOne(['id'=>$user]);
        
        $query = PaymentChori::find()->where(['fk_user_id'=>$user])->andWhere(['fk_municipal'=>$user_details->fk_municipal_id]);

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
            'fk_chori_bachat' => $this->fk_chori_bachat,
            'fk_bank_details' => $this->fk_bank_details,
            'fk_user_id' => $this->fk_user_id,
            'fk_municipal' => $this->fk_municipal,
           
        ]);

        $query->andFilterWhere(['like', 'post_date', $this->post_date])
            ->andFilterWhere(['like', 'amount', $this->amount])
            ->andFilterWhere(['like', 'created_date', $this->created_date]);

        return $dataProvider;
    }
}
