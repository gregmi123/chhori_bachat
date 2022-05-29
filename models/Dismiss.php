<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dismiss".
 *
 * @property int $id
 * @property string $name
 * @property int $fk_user_id
 * @property int $fk_municipal_id
 * @property string $created_date
 */
class Dismiss extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dismiss';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['fk_user_id', 'fk_municipal_id','type'], 'integer'],
            [['name', 'created_date'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'कारण',
            'fk_user_id' => 'Fk User ID',
            'fk_municipal_id' => 'Fk Municipal ID',
            'created_date' => 'Created Date',
        ];
    }
}
