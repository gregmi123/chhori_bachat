<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "withdraw".
 *
 * @property int $id
 * @property int $fk_chori
 * @property int $fk_dismiss
 * @property string $amount
 * @property int $fk_bank
 * @property int $fk_account
 * @property string $created_date
 * @property int $fk_user_id
 * @property int $fk_municipal
 * @property int $fk_economic_year
 * @property int $fk_month
 * @property int $fk_province
 * @property int $fk_district
 */
class Withdraw extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'withdraw';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'fk_dismiss','fk_month'], 'required'],
            [['fk_chori', 'fk_dismiss', 'fk_bank', 'fk_account', 'fk_user_id', 'fk_municipal', 'fk_economic_year', 'fk_month', 'fk_province', 'fk_district','type'], 'integer'],
            [['amount', 'created_date','description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_chori' => 'Fk Chori',
            'fk_dismiss' => 'खाता खारिज गर्ने कारण',
            'amount' => 'कुल रकम',
            'fk_bank' => 'Fk Bank',
            'fk_account' => 'Fk Account',
            'created_date' => 'Created Date',
            'fk_user_id' => 'Fk User ID',
            'fk_municipal' => 'Fk Municipal',
            'fk_economic_year' => 'Fk Economic Year',
            'fk_month' => 'महिना',
            'fk_province' => 'Fk Province',
            'fk_district' => 'Fk District',
            'description'=>'विवरण',
            'type'=>'Type',
        ];
    }
}
