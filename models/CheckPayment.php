<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "check_payment".
 *
 * @property int $id
 * @property int $fk_economic_year
 * @property string $fk_chori_bachat
 * @property string $fk_month
 * @property string $created_date
 */
class CheckPayment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'check_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_economic_year', 'fk_chori_bachat', 'fk_month', 'created_date'], 'required'],
            [['fk_economic_year'], 'integer'],
            [['fk_chori_bachat'], 'string', 'max' => 55],
            [['fk_month'], 'string', 'max' => 45],
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
            'fk_economic_year' => 'Fk Economic Year',
            'fk_chori_bachat' => 'Fk Chori Bachat',
            'fk_month' => 'Fk Month',
            'created_date' => 'Created Date',
        ];
    }
}
