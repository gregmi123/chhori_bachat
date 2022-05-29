<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ChoriBachat;

/**
 * ChoriBachatSearch represents the model behind the search form of `app\models\ChoriBachat`.
 */
class ChoriBachatSearch extends ChoriBachat
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fk_user_id','fk_municipal_id','firstPayment','fk_per_province', 'fk_per_district', 'fk_per_municipal', 'fk_ward'], 'integer'],
            [['image','unique_id', 'camera_image', 'thumb_left', 'thumb_right', 'guardian_image', 'name', 'dob', 'birth_certificate_no', 'birth_certificate_date', 'father_name', 'father_citizenship_no', 'mother_name', 'mother_citizenship_no', 'take_care_person', 'take_care_citizenship_no', 'tole_name', 'chori_birth_certificate_doc', 'parents_citizenship_doc', 'sastha_certificate', 'hospital_certificate', 'status', 'created_date'], 'safe'],
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
        $user_id = \Yii::$app->user->id;
        $user_details = Users::findOne(['id'=>$user_id]);
        $query = ChoriBachat::find()->where(['fk_user_id'=>$user_id])->andWhere(['fk_municipal_id'=>$user_details->fk_municipal_id])->andWhere(['payment_status'=>1])->OrderBy(['id'=>SORT_DESC]);

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fk_user_id' => $this->fk_user_id,
            'fk_municipal_id' =>$this->fk_municipal_id,
            'fk_per_province' => $this->fk_per_province,
            'fk_per_district' => $this->fk_per_district,
            'fk_per_municipal' => $this->fk_per_municipal,
            'fk_ward' => $this->fk_ward,
            'unique_id'=>$this->unique_id,
        ]);

        $query->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'camera_image', $this->camera_image])
            ->andFilterWhere(['like', 'thumb_left', $this->thumb_left])
            ->andFilterWhere(['like', 'thumb_right', $this->thumb_right])
            ->andFilterWhere(['like', 'guardian_image', $this->guardian_image])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'dob', $this->dob])
            ->andFilterWhere(['like', 'birth_certificate_no', $this->birth_certificate_no])
            ->andFilterWhere(['like', 'birth_certificate_date', $this->birth_certificate_date])
            ->andFilterWhere(['like', 'father_name', $this->father_name])
            ->andFilterWhere(['like', 'father_citizenship_no', $this->father_citizenship_no])
            ->andFilterWhere(['like', 'mother_name', $this->mother_name])
            ->andFilterWhere(['like', 'mother_citizenship_no', $this->mother_citizenship_no])
            ->andFilterWhere(['like', 'take_care_person', $this->take_care_person])
            ->andFilterWhere(['like', 'take_care_citizenship_no', $this->take_care_citizenship_no])
            ->andFilterWhere(['like', 'tole_name', $this->tole_name])
            ->andFilterWhere(['like', 'chori_birth_certificate_doc', $this->chori_birth_certificate_doc])
            ->andFilterWhere(['like', 'parents_citizenship_doc', $this->parents_citizenship_doc])
            ->andFilterWhere(['like', 'sastha_certificate', $this->sastha_certificate])
            ->andFilterWhere(['like', 'hospital_certificate', $this->hospital_certificate])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'created_date', $this->created_date])
            ->andFilterWhere(['like', 'unique_id',$this->unique_id]);

        return $dataProvider;
    }
}
