<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "district".
 *
 * @property int $id
 * @property string $district
 * @property string $district_nepali
 * @property int $fk_province
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'district';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['district', 'district_nepali', 'fk_province'], 'required'],
            [['fk_province'], 'integer'],
            [['district'], 'string', 'max' => 200],
            [['district_nepali'], 'string', 'max' => 3000],
        ];
    }

    /**
     * {@inheritdoc}
     */
     public static function getDistrict($id){
        $query = self::find()
                ->select('id,district_nepali as name')
                ->where(['fk_province'=>$id])
                ->asArray()
                ->all();
        
        return $query;
        
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'district' => 'District',
            'district_nepali' => 'District Nepali',
            'fk_province' => 'Fk Province',
        ];
    }
}
