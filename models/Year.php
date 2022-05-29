<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "year".
 *
 * @property int $id
 * @property string $name
 */
class Year extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'year';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['economic_year'], 'required'],
            [['status'],'integer'],
            [['economic_year','created_date'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'economic_year' => 'Economic Year',
        ];
    }
}
