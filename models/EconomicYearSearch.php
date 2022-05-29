<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EconomicYear;

/**
 * EconomicYearSearch represents the model behind the search form of `app\models\EconomicYear`.
 */
class EconomicYearSearch extends EconomicYear
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','status'], 'integer'],
            [['economic_year', 'created_date'], 'safe'],
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
        
        $query = EconomicYear::find()->where(['fk_province_id'=>$user_details['fk_province_id']]);
        
        
        

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
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'economic_year', $this->economic_year])
            ->andFilterWhere(['like', 'created_date', $this->created_date]);

        return $dataProvider;
    }
}
