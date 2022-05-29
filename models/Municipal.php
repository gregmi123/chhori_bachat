<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "municipal".
 *
 * @property int $id
 * @property string $name
 * @property int $fk_province
 * @property int $fk_district
 * @property string|null $address
 * @property string|null $head_officer
 * @property string|null $municipal_code
 * @property int $fk_user_id
 * @property string|null $logo
 * @property string $created_date
 */
class Municipal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'municipal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'fk_province', 'fk_district', 'fk_user_id', 'created_date'], 'required'],
            [['fk_province', 'fk_district', 'fk_user_id'], 'integer'],
            [['name', 'head_officer'], 'string', 'max' => 200],
            [['address'], 'string', 'max' => 234],
            [['municipal_code'], 'string', 'max' => 45],
            [['logo'], 'string', 'max' => 50],
            [['created_date'], 'string', 'max' => 34],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'पालिका नाम ',
            'fk_province' => 'प्रदेश',
            'fk_district' => 'जिल्ला ',
            'address' => 'ठेगाना',
            'head_officer' => ' पालिका हेड ',
            'municipal_code' => 'पालिका कोड',
            'fk_user_id' => 'Fk User ID',
            'logo' => 'फोटो',
            'created_date' => 'Created Date',
        ];
    }
}
