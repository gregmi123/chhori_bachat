<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "other_month_payment".
 *
 * @property int $id
 * @property int $fk_payment_chori
 * @property int $fk_chori_bachat
 * @property int $fk_bank_details
 * @property int $fk_chori_account_details
 * @property float $amount
 */
class OtherMonthPayment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'other_month_payment';
    }

    /**
     * {@inheritdoc}
     */
    public $from_date;
    public $to_date;
    public $province_search;
    public $district_search;
    public $local_level;
    public $bank_search;
    public $caste_search;
    public $apangata_search;
    public $year_search;
    public $age_search;
    public $verified;
    public $age_from;
    public $age_to;
    public $bank;
    public $check_update;
    public $ward_search;
    public function rules()
    {
        return [
            [['fk_payment_chori'], 'required'],
            [['fk_payment_chori','bank','check_update','fk_chori_bachat','fk_year','fk_month','fk_user_id','fk_municipal','fk_bank','cheque_no','fk_district_id','fk_province_id','province_search','district_search','local_level','bank_search','caste_search','apangata_search','year_search','amount','ward_search'], 'integer'],
            [['created_date','from_date','to_date'],'string','max'=>255,'length'=>10],
            [['age_from','age_to'],'integer','max'=>255],
            [['verified'],'string','max'=>255],
            ['to_date','compare', 'compareAttribute' => 'from_date', 'operator' => '>'],
            ['age_to','compare', 'compareAttribute' => 'age_from', 'operator' => '>','type' => 'number'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_payment_chori' => 'Fk Payment Chori',
            'fk_year'=>'Fk Year',
            'fk_month'=>'Fk Month',
            'amount' => 'Amount',
            'fk_user_id'=>'Fk User ID',
            'fk_municipal'=>'Fk Municipal ID',
            'created_date'=>'Date',
            'fk_bank'=>'बैंक',
            'cheque_no'=>'चेक न.',
            'from_date'=>'मिति देखि',
            'to_date'=>'मिति सम्म',
            'province_search'=>'प्रदेश',
            'district_search'=>'जिल्ला',
            'local_level'=>'स्थानिय तह',
            'bank_search'=>'बैंक',
            'caste_search'=>'जाति',
            'apangata_search'=>'अशक्तता',
            'year_search'=>'आर्थिक बर्ष',
            'fk_chori_bachat'=>'Chori Bachat',
            'age_from'=>'उमेर देखि',
            'age_to'=>'उमेर सम्म',
            'ward_search'=>'वडा',
            
        ];
    }
}
