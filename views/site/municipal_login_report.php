<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;

$eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
$nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');

$user_id=yii::$app->user->id;
$user_details=\app\models\Users::findone(['id'=>$user_id]);

$province=\yii\helpers\Arrayhelper::map(\app\models\Province::find()->where(['id'=>$user_details['fk_province_id']])->all(),'id','province_nepali');
$municipal_login=\yii\helpers\Arrayhelper::map(\app\models\Municipals::find()->where(['id'=>$user_details['fk_municipal_id']])->all(),'id','municipal_nepali');
$municipal_id=\app\models\Municipals::find()->where(['id'=>$user_details['fk_municipal_id']])->one();
$year=\yii\helpers\Arrayhelper::map(\app\models\EconomicYear::find()->where(['fk_province_id'=>$user_details['fk_province_id']])->all(),'id','economic_year');
$district_login=\yii\helpers\Arrayhelper::map(\app\models\District::find()->where(['id'=>$municipal_id['fk_district']])->all(),'id','district_nepali');


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
    
table td {
    
    white-space: nowrap;
}
table th, table thead tr {
    background: #ccc;
    font-weight: bold;

    
}
#find{
    
    color:white;
    margin-top:1.7em;
    

}
</style>


<div class="container-fluid">
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
    </div>
    <div class="col-md-12">
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
                                    'options' => ['placeholder' => 'सबै','id' => 'age_from','onchange'=>'age()'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
    </div>
    <div class="col-sm-2" id="age_to_date" style="<?=$model->age_from ==20 ?'display:none;':'display:block;'?>">
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
    <?= Html::submitButton('खोज्नुहोस', ['name' => 'btn1','class'=>'btn btn-success','id'=>'find']) ?>
    </div>
    
    </div>
<div class="col-md-12">
    <br>
<?php $rows=count($account_details); ?>
<h5 ><span style="font-weight:bold;">पङ्क्तिहरुको संख्या:</span> <?= $rows ?></h5>
<table class="table table-bordered" id="municipal_login_table">
    <th>सी.न.</th>
    <th>नाम  </th>
    <!-- <th>ठेगाना </th> -->
    <!-- <th>बुवाको नाम  </th> -->
    <!-- <th>मोबाइल न.   </th> -->
    <th>जन्म मिति</th>
    <th>जाति</th>
    <th>अशक्तता</th>
    <!-- <th>स्थानिय तह </th> -->
    <th>दर्ता मिति   </th> 
    <th>आर्थिक बर्ष</th>
    <th>बैंक </th>
    <th> खाता न. </th>
    <th style="width:100px;"> रकम रु.</th>

    <?php
    $a=1; 
    $sum=0;
    foreach($account_details as $bachat){ 
        $district=\app\models\District::find()->where(['id'=>$bachat['fk_per_district']])->one();
        $ward=\app\models\Ward::find()->where(['fk_municipal_id' => $bachat['fk_per_municipal']])->where(['id'=>$bachat['fk_ward']])->one();
        $municipals=\app\models\Municipals::find()->where(['id'=>$bachat['fk_per_municipal']])->one();
        $date1 = str_replace($eng_date, $nepali_date, $bachat['dob']);
        $date2 = str_replace($eng_date, $nepali_date,$bachat['created_date']);
        $mobile = str_replace($eng_date, $nepali_date,$bachat['mobile_no']);
        $jaati=\app\models\Caste::find()->where(['id'=>$bachat['fk_caste']])->one();
        $asaktata=\app\models\Apangata::find()->where(['id'=>$bachat['fk_apangata']])->one();
        $year=\app\models\EconomicYear::find()->where(['id'=>$bachat['fk_economic_year']])->one();
        $eyear=\app\models\Year::find()->where(['id'=>$year['economic_year']])->one();
        $date3=str_replace($eng_date, $nepali_date,$eyear['economic_year']); ?>
    <tr>
    <td><?= $a++ ?></td>
    <td><?= $bachat['name'] ?></td>
    <td><?= $date1 ?></td>
    <!-- <td><?= $district['district_nepali'] ?>-<?= $bachat['tole_name'] ?>-<?= $ward['ward_name'] ?> </td> -->
    <!-- <td><?= $bachat['father_name'] ?></td> -->
    <!-- <td><?= $date1?></td> -->
    <!-- <td><?= $mobile ?></td> -->
    <td><?= $jaati['name'] ?></td>
    <td><?= $asaktata['name'] ?></td>
    <!-- <td><?= $municipals['municipal_nepali'] ?></td> -->
    <td><?= $date2?></td>
    <td><?= $date3 ?></td>
    <td><?= $bachat['bank_name'] ?></td>
    <td><?= $bachat['account_no'] ?></td>
    <?php $other=\app\models\OtherMonthPayment::find()->where(['fk_payment_chori'=>$bachat['pid']])->andWhere(['fk_municipal'=>$bachat['fk_per_municipal']])->Sum('amount'); ?>
     <td><?= $bachat['amount']+$other ?></td>   
</tr>
<?php $sum=$sum+($bachat['amount']+$other); ?>
    <?php } ?>
    
    
    <tr>
    <td colspan="9">कुल</td>
    <td><?= $sum ?></td>
</tr>
    </table>
    
    <?php ActiveForm::end(); ?>
    
    </div>
</div>
<script>
    function age(){
        var age_from=document.getElementById("age_from").value;
        var age_to_date=document.getElementById("age_to_date");
        if(age_from==20){
            $(age_to_date).hide();
        }else{
            $(age_to_date).show();
        }
    }

    
</script>

<?php
$js = '$("#nepali-datepicker").nepaliDatePicker({ndpYear:true,ndpMonth:true,ndpYearCount:20});$("#nepali-datepicker1").nepaliDatePicker({ndpYear:true,ndpMonth:true,ndpYearCount:20});$("#nepali-datepicker2").nepaliDatePicker();$("#nepali-datepicker3").nepaliDatePicker();$("#nepali-datepicker4").nepaliDatePicker();$("#nepaliDate3").nepaliDatePicker();';
$this->registerJs($js, 5);
