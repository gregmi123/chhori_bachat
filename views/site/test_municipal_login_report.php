<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\sidenav\SideNav;
use app\assets\AppAsset;
use app\controllers\Helper;
use kartik\mpdf\Pdf;

AppAsset::register($this);
use kartik\icons\Icon;
Icon::map($this);

$eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
$nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');

$user_id=yii::$app->user->id;
$user_details=\app\models\Users::findone(['id'=>$user_id]);

$province=\yii\helpers\Arrayhelper::map(\app\models\Province::find()->where(['id'=>$user_details['fk_province_id']])->all(),'id','province_nepali');
$municipal_login=\yii\helpers\Arrayhelper::map(\app\models\Municipals::find()->where(['id'=>$user_details['fk_municipal_id']])->all(),'id','municipal_nepali');
$municipal_id=\app\models\Municipals::find()->where(['id'=>$user_details['fk_municipal_id']])->one();
$year=\yii\helpers\Arrayhelper::map(\app\models\EconomicYear::find()->where(['fk_province_id'=>$user_details['fk_province_id']])->all(),'id','economic_year');
$district_login=\yii\helpers\Arrayhelper::map(\app\models\District::find()->where(['id'=>$municipal_id['fk_district']])->all(),'id','district_nepali');
$ward_list=\yii\helpers\Arrayhelper::map(\app\models\Ward::find()->where(['fk_user_id'=>$user_id])->all(),'id','ward_name');

$bank=\yii\helpers\Arrayhelper::map(\app\models\BankDetails::find()->where(['fk_municipal_id'=>$user_details['fk_municipal_id']])->all(),'id','bank_name');
$caste=\yii\helpers\Arrayhelper::map(\app\models\Caste::find()->all(),'id','name');
$apangata=\yii\helpers\Arrayhelper::map(\app\models\Apangata::find()->all(),'id','name');



$municipals_name=\app\models\Municipals::find()->where(['id'=>$user_details['fk_municipal_id']])->one();
$district_name=\app\models\District::find()->where(['id'=>$municipals_name['fk_district']])->one();
$this->title = 'छोरी बचत खाता';
$this->params['breadcrumbs'][] = ['label' =>'रिपोर्ट'];


?>

<style>
    
    th,td{
        text-align:center;
    } 


#find{
    
    color:white;
    margin-top:1.7em;
    
    

}
#find1{
    
    color:white;
    margin-top:1.7em;
    float:right;
}
#find2{
    
    color:white;
    margin-top:1.7em;
    float:right;
}


</style>



<?php $form = ActiveForm::begin(); ?>  
<br>
<div class="col-md-12">
    <div class="col-sm-2">
    <?=$form->field($model,'from_date', ['inputOptions' => ['id' => 'nepali-datepicker', 'class' => 'form-control']]) ?>
    </div>
    <div class="col-sm-2">
    <?=$form->field($model,'to_date', ['inputOptions' => ['id' => 'nepali-datepicker1', 'class' => 'form-control']]) ?>
    </div>
    <div class="col-sm-2">
    
    <?= $form->field($model, 'province_search')->widget(Select2::classname(), [
                                    'data' => $province,
                                    'language' => 'en',
                                    'options' => ['id' => 'province'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
    </div>
    <div class="col-sm-2">
        <?= $form->field($model, 'district_search')->widget(Select2::classname(), [
                                    'data' => $district_login,
                                    'language' => 'en',
                                    'options' => ['id' => 'district'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
    </div>
    <div class="col-sm-2">
    <?= $form->field($model, 'local_level')->widget(Select2::classname(), [
                                    'data' => $municipal_login,
                                    'language' => 'en',
                                    'options' => ['id' => 'municipal'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
    </div>
    <div class="col-sm-2">
    <?= $form->field($model, 'ward_search')->widget(Select2::classname(), [
                                    'data' => $ward_list,
                                    'language' => 'en',
                                    'options' => ['id' => 'ward','placeholder' => 'सबै'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
    </div>
    </div>
    <div class="col-md-12">
    <div class="col-sm-2">
    
    <?= $form->field($model, 'caste_search')->widget(Select2::classname(), [
                                    'data' => $caste,
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'सबै','id' => 'caste'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
    </div>
    <!-- <div class="col-sm-2">
    
    <= $form->field($model, 'bank_search')->widget(Select2::classname(), [
                                    'data' => $bank,
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'सबै','id' => 'bank'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
    </div> -->

    
    <div class="col-sm-2">
    
    <?= $form->field($model, 'apangata_search')->widget(Select2::classname(), [
                                    'data' => $apangata,
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'सबै','id' => 'apangata'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
    </div>
    <div class="col-sm-2">
    <?= $form->field($model, 'age_from')->widget(Select2::classname(), [
                                    'data' =>[0=>'0',1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10',11=>'11',12=>'12',13=>'13',14=>'14',15=>'15',16=>'16',17=>'17',18=>'18',19=>'19'],
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'सबै','id' => 'age_from'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ]);
                                ?>
    </div>
    <div class="col-sm-2" id="age_to_date">
    <?= $form->field($model, 'age_to')->widget(Select2::classname(), [
                                    'data' =>[1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10',11=>'11',12=>'12',13=>'13',14=>'14',15=>'15',16=>'16',17=>'17',18=>'18',19=>'19',20=>'20'],
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'सबै','id' => 'age_to'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
    </div>
    <!-- <div class="col-sm-2">
    
    <?= $form->field($model, 'year_search')->widget(Select2::classname(), [
                                    'data' => $year,
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'छान्नुहोस्','id' => 'year'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
    </div> -->
    <div class="col-sm-2">
    <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Search', ['name' => 'btn1','class'=>'btn btn-success','id'=>'find']) ?>
    </div>
    <div class="col-sm-3">
    <?= Html::a('<i class="glyphicon glyphicon-refresh"></i> Refresh', ['/site/municipal-login-report'], ['name'=>'btn2','id'=>'find1','class'=>'btn btn-primary']) ?>
    </div>
    <div class="col-sm-1">
    <span><?= Html::button('<i class="glyphicon glyphicon-print"></i> Print',['name'=>'btn3','id'=>'find2','class'=>'btn btn-primary','onclick'=>'printDiv()']) ?></span>
    </div>
    </div>
 
<div class="col-md-12 fluid">
    <br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        
        'toolbar'=>['{export},{toggleData}'],
        'exportConfig' => [
            
            //GridView::HTML => ['label' => 'HTML'],
            // GridView::CSV => ['label' => 'CSV'],
            // GridView::TEXT  => ['label' => 'Text'],
            GridView::EXCEL => ['label' => 'Excel','filename'=>'Chhori'],
            GridView::PDF => ['label' => 'PDF','filename'=>'Chhori',
                'config'=>[
                    'mode'=>Pdf::MODE_UTF8,
                    'format' => Pdf::FORMAT_A4,
                    
                ]],
            // GridView::JSON => ['label' => 'JSON'],
        ],
        
        
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'floatHeader' => false,
        'showPageSummary' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
            'header'=>'क्र.स.',
            ],

            //'id',
            ['attribute'=>'name',
                'label'=>'नाम',
                'value'=>function($data){
                    return $data['name']." ".$data['middle_name']." ".$data['last_name'];
                }
            ],
            ['attribute'=>'dob',
                'label'=>'जन्म मिति',
                'value'=>function($data){
                    $eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                    $nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
                    return(str_replace($eng_date, $nepali_date, $data['dob']));}
            ],
            ['attribute'=>'age',
                'label'=>'उमेर',
                'value'=>function($data){
                    $eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                    $nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');

                    $helper=new Helper();
                    $nep_date=$helper->actionNepaliDate();
                    $nep_date1=explode('-',$nep_date);
                    $dob=explode('-',$data['dob']);
                    // var_dump($data['dob']);die;
                    if((int)$nep_date1[0]>(int)$dob[0]){
                        if((int)$nep_date1[1]>(int)$dob[1]){
                            $age=(int)$nep_date1[0]-(int)$dob[0];
                        }else if((int)$nep_date1[1]==(int)$dob[1]){
                            if((int)$nep_date1[2]>=(int)$dob[2]){
                                $age=(int)$nep_date1[0]-(int)$dob[0];
                            }else{
                                $age=((int)$nep_date1[0]-(int)$dob[0])-(int)1;
                            }
                        }else{
                            
                            $age=((int)$nep_date1[0]-(int)$dob[0])-(int)1;
                        }}
                        else{
                            $age=0;
                        }

                    return(str_replace($eng_date, $nepali_date,$age));}
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
                    $economic_year=\app\models\EconomicYear::findOne(['id'=>$data['fk_economic_year']]);
                    $eyear=\app\models\Year::find()->where(['id'=>$economic_year['economic_year']])->one();
                    $eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                    $nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
                    return(str_replace($eng_date, $nepali_date, $eyear['economic_year']));
                   
                }

            ],
            ['attribute'=>'fk_ward',
                'label'=>'वडा',
                'value'=>function($data){
                    $ward=\app\models\Ward::findone(['id'=>$data['fk_ward']]);
                    $eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                    $nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
                    return(str_replace($eng_date, $nepali_date, $ward['ward_name']));}
            ],
            ['attribute'=>'bank_name',
                'label'=>'बैंक',
                'value'=>function($data){
                    if($data['bank_name']){
                    if($data['bank_name']){
                        return($data['bank_name']);
                    }else{
                        return '';
                    }
                }else{
                    $chhori_account=\app\models\ChoriAccountDetails::findOne(['fk_chori_bachat'=>$data['id']]);
                    $bank_name=\app\models\BankDetails::findOne(['id'=>$chhori_account['bank_name']]);
                    return $bank_name['bank_name'];
                }
                }
                
            ],
            ['attribute'=>'account_no',
                'label'=>'खाता न',
                'value'=>function($data){
                    if($data['account_no']){
                        return($data['account_no']);
                    }else{
                        return '';
                    }
                }
            ],
            ['attribute'=>'amount',
            'pageSummary' => true,
                'label'=>'रकम रु.',
                'value'=>function($data){
                    
                    $other=\app\models\OtherMonthPayment::find()->where(['fk_payment_chori'=>$data['pid']])->andWhere(['fk_municipal'=>$data['fk_per_municipal']])->Sum('amount'); 
                    // var_dump($other);die;
                    return($data['amount']+$other);
                }
                
            ],


        ],
    ]); ?>  
    </div>
  
    <?php ActiveForm::end(); ?>
    
    
<script>
      function printDiv()
    {

        var divToPrint = document.getElementById('w1-container');

        var newWin = window.open('', 'Print-Window');

        newWin.document.open();

        newWin.document.write('<html><head><style>table,td,th{border: 1px solid #ddd;}table{border-collapse: collapse;width: 100%;} </style></head><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

        newWin.print();
        
        newWin.document.close();

        newWin.close();

    }

   </script>


<?php
$js = '$("#nepali-datepicker").nepaliDatePicker({ndpYear:true,ndpMonth:true,ndpYearCount:20});$("#nepali-datepicker1").nepaliDatePicker({ndpYear:true,ndpMonth:true,ndpYearCount:20});$("#nepali-datepicker2").nepaliDatePicker();$("#nepali-datepicker3").nepaliDatePicker();$("#nepali-datepicker4").nepaliDatePicker();$("#nepaliDate3").nepaliDatePicker();';
$this->registerJs($js, 5);
