<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment_chori".
 *
 * @property int $id
 * @property string $post_date
 * @property int $fk_chori_bachat
 * @property int $fk_bank_details
 * @property string $amount
 * @property int $fk_user_id
 * @property int $fk_municipal
 * @property int $fk_chori_account_details	
 * @property string $created_date
 * @property int|null $status
 */
class PaymentChori extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_chori';
    }

    /**
     * {@inheritdoc}
     */
    // status details
    // 7=>Monthly Deposited
    // 8=>Account Closed
    public $chhori_name;
    public $banks_name;
    public $chhori_account;
    public $add_month;
    public $multi_pay;
    public $bank_list;
    public $cheque;
    public $date;
    public $serial;
    public $deposit_method;
    public $month_method;
    public $pin;
    public $chhori_id;
    public function rules()
    {
        return [
            [['post_date','fk_economic_year', 'fk_chori_bachat','fk_month', 'fk_bank_details', 'amount', 'fk_user_id', 'fk_municipal', 'created_date','cheque_no','bank_request','deposit_method'], 'required'],
            [['fk_chori_bachat', 'fk_bank_details','bank_request' ,'fk_user_id','fk_chori_account_details', 'fk_municipal', 'status','add_month','bank_list','cheque','serial','fk_district_id','fk_province_id','deposit_method','month_method','pin'], 'integer'],
            [['post_date','date'], 'string', 'max' => 200],
            [['amount','multi_pay'], 'string', 'max' => 234],
            [['pin'],'string','length'=>4],
            [['created_date','chhori_name','banks_name','chhori_account','fk_economic_year'], 'string', 'max' => 233],
            [['cheque_no','fk_initial','chhori_id'],'string','max'=>255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_economic_year' =>'आर्थिक वर्ष ',
            'fk_month'=>'मासीक',
            'date' =>'महिना ',
            'post_date' => 'रकम जम्मा गरिएको मिति  ',
            'fk_chori_bachat' => 'छोरीको नाम ',
             'chhori_name' => 'छोरीको नाम ',
            'fk_bank_details' => 'बैंकको नाम',
            'amount' => 'पहिलो महिना रकम रु.',
            'fk_user_id' => 'Fk User ID',
            'fk_chori_account_details'=>'खाता न.',
            'fk_municipal' => 'Fk Municipal',
            'created_date' => 'Created Date',
            'status' => 'Status',
            'add_month'=>'थप महिना',
            'multi_pay'=>'Multi Pay',
            'bank_list'=>'बैंक',
            'cheque'=>'चेक न.',
            'date'=>'मिति',
            'bank_request'=>'बैंक',
            'cheque_no'=>'चेक न.',
            'request_date'=>'मिति',
            'deposit_method'=>'जम्मा गर्ने तरिका',
            'month_method'=>'त्रैमासीक',
            'pin'=>'Enter PIN NO.',

        ];
    }
    
    public function getChoriName(){
        return $this->hasOne(ChoriBachat::className(),['id'=>'fk_chori_bachat']);
    }
    public function getBankName(){
        return $this->hasOne(BankDetails::className(), ['id'=>'fk_bank_details']);
    }
    public function getAccountNo(){
        return $this->hasOne(ChoriAccountDetails::className(), ['id'=>'fk_chori_account_details']);
    }
}
