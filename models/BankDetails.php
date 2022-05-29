<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bank_details".
 *
 * @property int $id
 * @property string $name
 * @property int $fk_user_id
 * @property int $fk_municipal_id
 * @property string $created_date
 */
class BankDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bank_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bank_name', 'fk_user_id', 'created_date'], 'required'],
            [['fk_user_id','fk_municipal_id','fk_district_id','fk_province_id','status'], 'integer'],
            [['bank_name'], 'string', 'max' => 200],
            [['created_date'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bank_name' => 'बैंकको नाम',
            'fk_user_id' => 'Fk User ID',
            'created_date' => 'Created Date',
            'fk_district_id'=>'District',
            'fk_province_id'=>'Province',
        ];
    }
}
