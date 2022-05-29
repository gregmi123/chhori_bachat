<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ChoriAccountDetails;

/**
 * ChoriAccountDetailsSearch represents the model behind the search form of `app\models\ChoriAccountDetails`.
 */
class WithdrawChoriAccount extends ChoriAccountDetails
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','bank_status', 'fk_user_id'], 'integer'],
            [['bank_name','remarks', 'fk_chori_bachat','chori_unique_id','account_no', 'account_open_date', 'created_date','unique_id'], 'safe'],
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
        $economic_year=\app\models\EconomicYear::find()->where(['status'=>1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
        $query=(new \yii\db\Query())
                ->select('chori_account_details.id,chori_account_details.bank_status,chori_account_details.chori_unique_id,chori_account_details.account_no,chori_account_details.fk_chori_bachat,chori_account_details.bank_name,chori_account_details.account_open_date')
                ->from('chori_account_details')
                ->join('JOIN', 'chori_bachat', 'chori_bachat.id=chori_account_details.fk_chori_bachat')
                ->where(['chori_account_details.fk_user_id' => $user_id])
                ->andWhere(['chori_account_details.bank_status'=>2])
                ->andWhere(['chori_account_details.fk_municipal_id' => $user_details->fk_municipal_id])
                ->andWhere(['chori_bachat.payment_status' => 1])
                ->OrderBy(['chori_account_details.id'=>SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 30),
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // $query->joinWith('choriName');
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            // 'fk_chori_bachat' => $this->fk_chori_bachat,
            'fk_user_id' => $this->fk_user_id,
            'bank_status'=>$this->bank_status,
        ]);
        // var_dump($this->unique_id);die;   
        $query->andFilterWhere(['like', 'bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'account_no', $this->account_no])
            ->andFilterWhere(['like', 'account_open_date', $this->account_open_date])
            ->andFilterWhere(['like', 'unique_id', $this->unique_id])
            ->andFilterWhere(['like', 'name', $this->fk_chori_bachat])
            ->andFilterWhere(['like', 'created_date', $this->created_date])
            ->andFilterWhere(['like', 'chori_unique_id', $this->chori_unique_id]);

        return $dataProvider;
    }
}
