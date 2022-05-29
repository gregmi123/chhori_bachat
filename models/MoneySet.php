<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "money_set".
 *
 * @property int $id
 * @property int $fk_user_id
 * @property int $fk_municipal_id
 * @property int $initial_payment
 * @property int $previous_payment
 * @property int $status
 * @property string|null $created_date
 */
class MoneySet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'money_set';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_user_id', 'fk_municipal_id', 'initial_payment', 'previous_payment', 'status'], 'required'],
            [['fk_user_id', 'fk_municipal_id', 'initial_payment', 'previous_payment', 'status'], 'integer'],
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
            'fk_user_id' => 'Fk User ID',
            'fk_municipal_id' => 'Fk Municipal ID',
            'initial_payment' => 'पहिलो महिनाको  भुक्तानी रु. ',
            'previous_payment' => 'बाकी महिनाको भुक्तानी रु.',
            'status' => 'स्थिति',
            'created_date' => 'Created Date',
        ];
    }
}
