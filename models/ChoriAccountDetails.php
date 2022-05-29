<?php

namespace app\models;
use app\models\PaymentChori;
use app\models\OtherMonthPayment;

use Yii;

/**
 * This is the model class for table "chori_account_details".
 *
 * @property int $id
 * @property int $chori_unique_id
 * @property int $fk_chori_bachat
 * @property int $fk_municipal_id
 * @property string $bank_name
 * @property string $account_no
 * @property string $account_open_date
 * @property int $fk_user_id
 * @property string $remarks
 * @property string $radio_status
 * @property string $created_date
 */
class ChoriAccountDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chori_account_details';
    }

    /**
     * {@inheritdoc}
     */
    // status Details
    //     column Bank_status:
    //     2=>Account Opened
    //     5=>Account Rejected
    //     3=>Withdraw
    //     4=>Account Closed

    public $unique_id;
    public function rules()
    {
        return [
            [['fk_chori_bachat', 'bank_name','fk_user_id', 'created_date'], 'required'],
            [[ 'fk_municipal_id','bank_name','fk_user_id','bank_status','fk_district_id','fk_province_id','fk_year'], 'integer'],
            [['created_date'], 'string', 'max' => 300],
            [['account_no','radio_status'], 'string', 'max' => 45],
            [['account_open_date'], 'string', 'max' => 234],
            [['remarks','amount'],'string'],
            [['unique_id','chori_unique_id'],'string','max'=>255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Account_ID',
            'fk_chori_bachat' => 'छोरिको नाम',
            'bank_name' => 'खाता खोलेको बैंक को नाम ',
            'account_no' => 'खाता न.',
            'account_open_date' => 'खाता खोलेको मिति ',
            'fk_user_id' => 'Fk User ID',
            'radio_status' =>'पेश गरिएको सबै कागजातहरु कानुन बमोजिम मान्य हुने छन् । ',
            'remarks'=>'आवशेक परेको  अन्य कागजातहरु ',
            'created_date' => 'Created Date',
            'amount'=>'Amount',
            'unique_id'=>'ID',
            'chori_unique_id'=>'Unique',
            
        ];
    }
    public function getChoriName(){
        return $this->hasOne(ChoriBachat::className(),['id' => 'fk_chori_bachat']);
    }
    public function getChoriInitial(){
        return $this->hasOne(PaymentChori::className(),['fk_chori_bachat' => 'fk_chori_bachat']);
    }
    public function getBank(){
        return $this->hasOne(BankDetails::className(),['id' => 'bank_name']);
    }
    public function getId($id){
        $year=explode('-',$id);
        $year_name=\app\models\Year::find()->where(['id'=>$year[0]])->one();
        $new_unique_id=$year_name['economic_year'].'-'.$year[1].'-'.$year[2].'-'.$year[3].'-'.$year[4];
        return($new_unique_id);
    }
}
