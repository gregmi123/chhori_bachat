<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chori_bachat".
 *
 * @property int $id
 * @property int $fk_user_id
 * @property int $fk_municipal_id 
 * @property string|null $image
 * @property string|null $camera_image
 * @property string|null $thumb_left
 * @property string $left_iso_template
 * @property string $left_ansi_template
 * @property string|null $thumb_right
 * @property string $iso_template 
 * @property string $ansi_template
 * @property string|null $guardian_image
 * @property string $name
 * @property string $dob
 * @property string $birth_certificate_no
 * @property string $birth_certificate_date
 * @property string $father_name
 * @property string|null $father_citizenship_no
 * @property string|null $mother_name
 * @property string|null $mother_citizenship_no
 * @property string|null $take_care_person
 * @property string|null $take_care_citizenship_no
 * @property int $fk_per_province
 * @property int $fk_per_district
 * @property int $fk_per_municipal
 * @property int $fk_ward
 * @property string $tole_name
 * @property string|null $chori_birth_certificate_doc
 * @property string|null $parents_citizenship_doc
 * @property string|null $sastha_certificate
 * @property string|null $hospital_certificate
 * @property string $status
 * @property string $created_date
 * @property int $payment_status
 * @property string $email
 * @property int $phone_no
 * @property int $mobile_no
 * @property string $mother_citizenship_doc
 */
class ChoriBachat extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'chori_bachat';
    }

    /**
     * {@inheritdoc}
     */

    // status details
        // column status:
    // 0=>Not Verified
    // 1=>Verified
    // 3=>Account Requested
    // 2=>Account Opened
    // 4=>Account Rejected
    // 5=>Initial deposited
    // 6=>Withdraw
    // 7=>Account Closed

    public $thumbLeft;
    public $thumbRight;
    public $ImageFile;
    public $ParentPhoto;
    public $BirthCertificate;
    public $ParentCitizen;
    public $SasthaCertificate;
    public $HospitalCertificate;
    public $MotherCertificate;
    public $WodaSifarish;
    public $password;
    public $firstPayment;
    public $update_file;
    public $update_parent_file;
    public $photo_from_camera;
    public $photo_from_camera_guardian;
    public $file_upload;
    public function rules() {
        return [
            [['fk_user_id','fk_caste','name','last_name','dob', 'birth_certificate_no','birth_certificate_date', 'fk_per_province', 'fk_per_district', 'fk_per_municipal', 'fk_ward'], 'required'],
            [['fk_user_id','check_guardian','firstPayment','fk_per_province','payment_status', 'bank_status' ,'fk_municipal_id', 'fk_per_district', 'fk_per_municipal', 'fk_ward','fk_economic_year','fk_caste','fk_apangata','fk_month','age'], 'integer'],
            [['image','last_name','middle_name','thumb_right','thumbRight','thumbLeft','camera_image', 'ansi_template', 'thumb_left', 'iso_template', 'left_iso_template', 'left_ansi_template','birth_certificate_no', 'father_citizenship_no', 'mother_citizenship_no', 'take_care_citizenship_no', 'chori_birth_certificate_doc','guardian_image', 'mother_name','woda_sifarish_doc', 'parents_citizenship_doc', 'mother_citizenship_doc','created_date'], 'string'],
            [['HospitalCertificate','update_file','update_parent_file','SasthaCertificate','WodaSifarish','MotherCertificate','ParentCitizen','BirthCertificate','ParentPhoto','ImageFile'], 'file', 'extensions' => 'jpg,png,gif,jpeg'],
            [['take_care_person','sastha_certificate', 'hospital_certificate','father_name','password','phone_no','name', 'tole_name','unique_id','verified_date'], 'string', 'max' => 300],

            [['mobile_no'],'integer','message'=>'कृपया नम्बर अंग्रेजीमा राख्नुहोस'],
            [['email'],'email'],
            [['photo_from_camera','photo_from_camera_guardian'],'string'],
            // [['email'],'unique','targetClass' => '\app\models\ChoriBachat','message'=>'Email already exists!'],
            [['mobile_no'],'string','length'=>10],
            [['dob','birth_certificate_date'],'string','length'=>10],
            [['birth_certificate_date'],'compare', 'compareAttribute' => 'dob', 'operator' => '>=','message' => 'कृपया {attribute} जन्म मिति भन्दा बढी अथवा बराबर राख्नुहोस '],
            [[''],'safe'],
            [['file_upload'],'file','extensions'=>'xlsx,xls']
            // [['dob'],'compare', 'compareAttribute' => 'birth_certificate_date', 'operator' => '<='],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'fk_user_id' => 'Fk User ID',
            'photo_from_camera'=>'Photo',
            'fk_municipal_id' => 'FK Municipal ID',
            'image' => 'छोरीको फोटो',
            'update_file'=>'फोटो',
            'camera_image' => 'Camera Image',
            'thumb_left' => 'Thumb Left',
            'thumb_right' => 'Thumb Right',
            'guardian_image' => 'अभिभावक/संरक्षकको फोटो ',
            'update_parent_file'=>'अभिभावक/संरक्षकको फोटो ',
            'name' => 'पहिलो नाम',
            'middle_name'=>'बीचको नाम',
            'last_name'=>'थर',
            'dob' => 'जन्म मिति',
            'birth_certificate_no' => ' जन्म दर्ता न.',
            'birth_certificate_date' => 'दर्ता मिति ',
            'father_name' => 'बुवाको नाम ',
            'father_citizenship_no' => 'बुवाको नागरिता न.',
            'mother_name' => 'आमाको नाम ',
            'mother_citizenship_no' => 'आमाको नागरिता न.',
            'take_care_person' => 'संरक्षकको नाम',
            'take_care_citizenship_no' => 'संरक्षकको नागरिता न.',
            'fk_per_province' => 'प्रदेश',
            'fk_per_district' => 'जिल्ला ',
            'fk_per_municipal' => 'पालिका ',
            'fk_ward' => 'वडा',
            'email' =>'इमेल',
            'phone_no'=>'फोन न.',
            'mobile_no'=>' मोबाइल न. ',
            'tole_name' => 'टोलको नाम',
            'chori_birth_certificate_doc' => 'छोरिको जन्मदर्ता को प्रतिलिपि ',
            'parents_citizenship_doc' => 'बुवाको नागरिता को प्रतिलिपि ',
            'mother_citizenship_doc' => 'आमाको नागरिता को प्रतिलिपि ',
            'sastha_certificate' => 'सस्था दर्ताको प्रमाणपत्रको प्रतिलिपि ',
            'hospital_certificate' => 'स्वास्थ केन्द्र प्रमाणपत्र वा खोप लिएको को प्रतिलिपि ',
            'woda_sifarish_doc' =>'वडा सिफारिसको प्रतिलिपि ',
            'status' => 'Status',
            'firstPayment' =>'First Payment',
            'payment_status'=>'Payment Status',
            'password'=>'Enter Your password',
            'created_date' => 'मिति',
            'unique_id'=>'छोरीको ID',
            'fk_economic_year'=>'Fk Economic Year',
            'fk_caste'=>'जाति',
            'fk_apangata'=>'अशक्तता',
            'fk_month'=>'Month',
            'age'=>'उमेर',
            'check_guardian'=>'संरक्षक छान्नुहोस्'
        ];
    }

    public function getMunicipal($id) {
        $model = Municipals::findOne(['id' => $id]);
        //var_dump($id);die;
        return $model->municipal_nepali;
    }
    public function getDistrict($id){
        $model = District::findOne(['id'=>$id]);
        //var_dump($id);die;
        return $model->district_nepali;
    }
    
    // public function getId($id){
    //     $year=explode('-',$id);
    //     $year_name=\app\models\Year::find()->where(['id'=>$year[0]])->one();
    //     $new_unique_id=$year_name['economic_year'].'-'.$year[1].'-'.$year[2].'-'.$year[3].'-'.$year[4];
    //     return($new_unique_id);
    // }
}
