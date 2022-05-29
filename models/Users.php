<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property int $fk_municipal_id
 * @property string $name
 * @property int $phone
 * @property string $position
 * @property string $username
 * @property string $password
 * @property string $authkey
 * @property string $created_date
 * @property string $updated_date
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public $verify;
    public function rules()
    {
        return [
            [[ 'name', 'phone', 'position', 'username','user_type', 'password', 'created_date', 'updated_date'], 'required'],
            [['fk_municipal_id','fk_province_id','fk_district_id','pin'], 'integer'],
            [['name', 'position', 'username', 'password','authkey'], 'string', 'max' => 2000],
            [['created_date'], 'string', 'max' => 250],
            [['pin','verify'],'string','length'=>4],
            [['updated_date'], 'string', 'max' => 456],
            [['user_type','phone'], 'string', 'max' => 255],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
           'fk_municipal_id' =>'स्थानीय तह',
            'name' => 'नाम',
            'phone' => 'फोन न.',
            'position' => 'पद',
            'username' => 'इमेल',
            'password' => 'पासवोर्ड',
            'pin' => 'PIN NO.',
            'created_date' => 'जारि मिति',
            'updated_date' => 'Updated Date',
            'user_type'=>'प्रयोगकर्ताको प्रकार',
            'fk_province_id' =>'प्रदेश',
            'fk_district_id' =>'जिल्ला',
            'verify'=>'PIN NO.',
        ];
    }
     public static function primaryKey() {
        return ['id'];
    }

    public function getAuthKey(): string {
        return $this->authkey;
    }

    public function getId() {
        return $this->getPrimaryKey();
    }

    public function validateAuthKey($authKey): bool {
        return $this->authkey === $authKey;
    }

    public static function findIdentity($id) {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException();
    }

    public static function findByUsername($username) {
        return self::findOne(['username' => $username]);
    }

    public function validatePassword($password) {
        return $this->password === $password;
    }
    
    
    public function getMunicipalName(){
       return  $this->hasOne(Municipals::className(),['id'=>'fk_municipal_id']);
    }
}
