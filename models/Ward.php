<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ward".
 *
 * @property int $id
 * @property int $fk_user_id
 * @property int $fk_municipal_id
 * @property string $ward_name
 * @property string $created_date
 */
class Ward extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ward';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ward_name','fk_user_id','fk_municipal_id', 'created_date'], 'required'],
            [['ward_name'], 'string', 'max' => 500],
            [['created_date'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ward_name' => 'वडाको नाम',
            'created_date' => 'Created Date',
        ];
    }
}
