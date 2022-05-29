<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "initial".
 *
 * @property int $id
 * @property int $fk_year
 * @property int $fk_province_id
 * @property int $fk_user
 * @property int $fk_municipal
 * @property int $fk_district
 * @property string $created_date
 * @property string $payment_id
 * @property int $status
 */
class Initial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'initial';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_year', 'fk_province_id', 'fk_user', 'fk_municipal', 'fk_district', 'created_date', 'payment_id', 'status'], 'required'],
            [['fk_year', 'fk_province_id', 'fk_user', 'fk_municipal', 'fk_district', 'status','fk_bank'], 'integer'],
            [['created_date', 'payment_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_year' => 'Fk Year',
            'fk_province_id' => 'Fk Province ID',
            'fk_user' => 'Fk User',
            'fk_municipal' => 'Fk Municipal',
            'fk_district' => 'Fk District',
            'created_date' => 'Created Date',
            'payment_id' => 'Payment ID',
            'status' => 'Status',
        ];
    }
}
