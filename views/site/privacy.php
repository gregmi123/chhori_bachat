<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\data\SqlDataProvider;

$model= new \app\models\OtherMonthPayment();
$user_id=yii::$app->user->id;
$user_details=\app\models\Users::findone(['id'=>$user_id]);


$account_details = (new \yii\db\Query())
->select('chori_bachat.id,chori_bachat.fk_economic_year,chori_bachat.fk_caste,chori_bachat.fk_apangata,'
    . 'chori_bachat.dob,chori_bachat.created_date,chori_bachat.mobile_no,chori_bachat.tole_name,'
    . 'chori_bachat.father_name,chori_bachat.fk_per_district,chori_bachat.fk_ward,chori_bachat.fk_per_municipal,'
    . 'chori_bachat.name,chori_account_details.id as account_id,payment_chori.id as pid,payment_chori.amount,
    bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name')
        ->from('chori_bachat')
        ->join('LEFT JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
        ->join('LEFT JOIN', 'bank_details', 'bank_details.id=chori_bachat.fk_bank_details')
        ->join('LEFT JOIN', 'payment_chori', 'payment_chori.fk_chori_bachat=chori_bachat.id')
        ->where(['chori_bachat.fk_per_municipal' => $user_details['fk_municipal_id']])
        ->all();
    $totalCount = count($account_details);

//var_dump($totalCount);die;
    $dataProvider1 = new SqlDataProvider([
        'db' => Yii::$app->db,
        'sql' => 'SELECT chori_bachat.id,chori_bachat.fk_economic_year,chori_bachat.fk_caste,chori_bachat.fk_apangata,
        chori_bachat.dob,chori_bachat.created_date,chori_bachat.mobile_no,chori_bachat.tole_name,
        chori_bachat.father_name,chori_bachat.fk_per_district,chori_bachat.fk_ward,chori_bachat.fk_per_municipal,
        chori_bachat.name,chori_account_details.id as account_id,payment_chori.id as pid,payment_chori.amount,
        bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name
        FROM chori_bachat 
        LEFT JOIN payment_chori on payment_chori.fk_chori_bachat=chori_bachat.id
        LEFT JOIN bank_details on bank_details.id=chori_bachat.fk_bank_details
        LEFT JOIN chori_account_details on chori_account_details.fk_chori_bachat=chori_bachat.id
        where chori_bachat.fk_per_municipal='.$user_details['fk_municipal_id'],
        'totalCount' => $totalCount,
        'sort' =>false,
        'pagination' => [
            'pageSize' => 10,
        ],
    ]);





?>




  
    <?= GridView::widget([
        'dataProvider' => $dataProvider1,
        
        'toolbar'=>['{export},{toggleData}'],
        'exportConfig' => [
            
            //GridView::HTML => ['label' => 'HTML'],
            // GridView::CSV => ['label' => 'CSV'],
            // GridView::TEXT  => ['label' => 'Text'],
            GridView::EXCEL => ['label' => 'Excel','filename'=>'Chhori'],
            GridView::PDF => ['label' => 'PDF','filename'=>'Chhori'],
            // GridView::JSON => ['label' => 'JSON'],
        ],
        'pjax' => true,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'floatHeader' => true,
        'showPageSummary' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            ['attribute'=>'name',
                'label'=>'नाम'
            ],
            ['attribute'=>'dob',
                'label'=>'जन्म मिति',
                'value'=>function($data){
                    $eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                    $nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
                    return(str_replace($eng_date, $nepali_date, $data['dob']));}
            ],
            ['attribute'=>'fk_caste',
                'label'=>'जाति',
                'value'=>function($data){
                    $jaati=\app\models\Caste::find()->where(['id'=>$data['fk_caste']])->one();
                    return($jaati['name']);
                }
            ],
            ['attribute'=>'fk_apangata',
                'label'=>'अशक्तता',
                'value'=>function($data){
                    if($data['fk_apangata']){
                    $asaktata=\app\models\Apangata::find()->where(['id'=>$data['fk_apangata']])->one();
                    return($asaktata['name'] );}
                    else{
                        return '';
                    }
                }

            ],
            ['attribute'=>'created_date',
                'label'=>'दर्ता मिति',
                'value'=>function($data){
                    $eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                    $nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
                    return(str_replace($eng_date, $nepali_date, $data['created_date']));}
            ],
            ['attribute'=>'economic_year',
                'label'=>'आर्थिक बर्ष',
                'value'=>function($data){
                    $year=\app\models\EconomicYear::find()->where(['id'=>$data['fk_economic_year']])->one();
                    $eyear=\app\models\Year::find()->where(['id'=>$year['economic_year']])->one();
                    $eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                    $nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
                    return(str_replace($eng_date, $nepali_date, $eyear['economic_year']));
                   
                }

            ],
            ['attribute'=>'bank_name',
                'label'=>'बैंक'
            ],
            ['attribute'=>'account_no',
                'label'=>'खाता न'
            ],
            ['attribute'=>'amount',
            'pageSummary' => true,
                'label'=>'रकम रु.',
                'value'=>function($data){
                    $other=\app\models\OtherMonthPayment::find()->where(['fk_payment_chori'=>$data['pid']])->andWhere(['fk_municipal'=>$data['fk_per_municipal']])->Sum('amount'); 
                    return($data['amount']+$other);
                }
                
            ],


        ],
    ]); ?>    
    
    
  



