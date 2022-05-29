<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "economic_year".
 *
 * @property int $id
 * @property string $economic_year
 * @property int|null $fk_user_id
 * @property int|null $fk_municipal_id
 * @property int $status
 * @property string|null $created_date
 */
class EconomicYear extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'economic_year';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['economic_year', 'status'], 'required'],
            [['status'], 'integer'],
            [['economic_year', 'created_date'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'economic_year' => 'आर्थिक वर्ष',
            'fk_user_id' => 'Fk User ID',
            'fk_municipal_id' => 'Fk Municipal ID',
            'status' => 'स्थिति',
            'created_date' => 'Created Date',
        ];
    }

    public function getyearName(){
        return $this->hasone(\app\models\Year::className(),['id'=>'economic_year']);
    }
    public function year($id){
        $year_name=\app\models\Year::find()->where(['id'=>$id])->one();
        return ($year_name['economic_year']);
    }
}
