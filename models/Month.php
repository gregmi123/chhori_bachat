<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "month".
 *
 * @property int $id
 * @property string $month_name
 * @property int $fk_user_id
 * @property int $fk_municipal_id
 * @property string $created_date
 */
class Month extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'month';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month_name', 'fk_user_id', 'fk_municipal_id', 'created_date'], 'required'],
            [['fk_user_id', 'fk_municipal_id'], 'integer'],
            [['month_name'], 'string', 'max' => 200],
            [['created_date'], 'string', 'max' => 234],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'month_name' => 'Month Name',
            'fk_user_id' => 'Fk User ID',
            'fk_municipal_id' => 'Fk Municipal ID',
            'created_date' => 'Created Date',
        ];
    }
}
