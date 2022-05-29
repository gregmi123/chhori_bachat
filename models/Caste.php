<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "caste".
 *
 * @property int $id
 * @property int $name
 * @property int $fk_user_id
 * @property int $fk_province_id
 * @property int $fk_district_id
 * @property int $fk_municipal_id
 * @property string $created_date
 * @property int $status
 */
class Caste extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'caste';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['fk_user_id', 'fk_province_id', 'fk_district_id', 'fk_municipal_id', 'status'], 'integer'],
            [['name','created_date'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'fk_user_id' => 'Fk User ID',
            'fk_province_id' => 'Fk Province ID',
            'fk_district_id' => 'Fk District ID',
            'fk_municipal_id' => 'Fk Municipal ID',
            'created_date' => 'Created Date',
            'status' => 'Status',
        ];
    }
}
