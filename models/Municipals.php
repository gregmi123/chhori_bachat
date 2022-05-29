<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "municipals".
 *
 * @property int $id
 * @property string $name
 * @property string $municipal_nepali
 * @property int $fk_district
 * @property int $fk_province
 */
class Municipals extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'municipals';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'municipal_nepali', 'fk_district', 'fk_province'], 'required'],
            [['fk_district', 'fk_province'], 'integer'],
            [['name'], 'string', 'max' => 200],
            [['municipal_nepali'], 'string', 'max' => 500],
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
            'municipal_nepali' => 'Municipal Nepali',
            'fk_district' => 'Fk District',
            'fk_province' => 'Fk Province',
        ];
    }
    public static function getMunicipals($id) {
        $query = self::find()
                ->select('id,municipal_nepali as name')
                ->where(['fk_district' => $id])
                ->asArray()
                ->all();
        return $query;
}
}
