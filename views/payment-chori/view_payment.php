<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\ChoriBachat;
use app\models\OtherMonthPayment;
use app\models\ChoriAccountDetails;
use app\models\PaymentChori;
use app\models\EconomicYear;
use app\models\Month;
use app\models\Municipals;
use app\models\District;
use app\models\Ward;
use app\models\BankDetails;

$user_id = yii::$app->user->id;
$user_details = app\models\Users::findOne(['id' => $user_id]);
$active_year=\app\models\EconomicYear::find()->where(['fk_province_id' => $user_details->fk_province_id])->andWhere(['status'=>1])->one();
$chori_acc_details=ChoriAccountDetails::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['id'=>$id])->one();
$chori_bachat=ChoriBachat::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['id'=>$chori_acc_details['fk_chori_bachat']])->one();
$payment_chori=PaymentChori::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal' => $user_details->fk_municipal_id])->andWhere(['fk_chori_bachat'=>$chori_bachat['id']])->one();

$other_payment_chori=OtherMonthPayment::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal' => $user_details->fk_municipal_id])->andWhere(['fk_payment_chori'=>$payment_chori['id']])->OrderBy(['id'=>SORT_DESC])->all();

$year=EconomicYear::find()->andwhere(['id'=>$payment_chori['fk_economic_year']])->one();
$economic_yr=\app\models\Year::find()->where(['id'=>$year['economic_year']])->one();
$month=Month::find()->where(['id'=>$payment_chori['fk_month']])->one();
$municipals=Municipals::find()->where(['id'=>$chori_bachat['fk_per_municipal']])->one();
$district=District::find()->where(['id'=>$chori_bachat['fk_per_district']])->one();
$ward=Ward::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->where(['id'=>$chori_bachat['fk_ward']])->one();
$bank=BankDetails::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->where(['id'=>$chori_acc_details['bank_name']])->one();

$withdraw=\app\models\Withdraw::find()->where(['fk_account'=>$id])->andWhere(['fk_user_id' => $user_id])->andWhere(['fk_municipal' => $user_details->fk_municipal_id])->one();
$year_last=EconomicYear::find()->andwhere(['economic_year'=>$withdraw['fk_economic_year']])->one();
$economic_yr_last=\app\models\Year::find()->where(['id'=>$year_last['economic_year']])->one();
// var_dump($withdraw);die;
$month_last=Month::find()->where(['id'=>$withdraw['fk_month']])->one();
$eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
$nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');

$this->params['breadcrumbs'][]=['label'=>'खाताह खोलिसकेको विवरण','url'=>['chori-account-details/index']];
$this->params['breadcrumbs'][]=['label'=>$chori_bachat['name']];
?>

<style>
#find{
    background-color:red;
    color:white;
    margin-top:1.7em;
    margin-left:3em;

}
button{
    float:right;
}
th,td{
    text-align:center;
}
#first_tr{
    vertical-align: bottom;
}
#target{
    overflow-y:scroll;
    height:600px;
}
</style>
<br>
<button class="btn btn-success" onclick="printDiv()">Print</button>  
<div class="payment-chori-form" id="printdiv">
<br>
<div class="chori-bachat-view1">
<div class="row">
    <div class="col-sm-4">
    <h4><span style="font-weight:bold;">नाम:</span> <?= $chori_bachat['name']." ".$chori_bachat['middle_name']." ".$chori_bachat['last_name']; ?> </h4>
    <h4><span style="font-weight:bold;">ठेगाना:</span> <?= $district['district_nepali'] ?>-<?= $chori_bachat['tole_name'] ?>-<?= $ward['ward_name'] ?> </h4>
    <h4><span style="font-weight:bold;">बुवाको नाम:</span> <?= $chori_bachat['father_name'] ?> </h4>
    <h4><span style="font-weight:bold;">बैंक:</span> <?= $bank['bank_name'] ?> </h4>
    <h4><span style="font-weight:bold;">खाता न.:</span> <?= $chori_acc_details['account_no'] ?> </h4>
    </div>
    
    <div class="col-sm-6">
    <?php
    $date1 = str_replace($eng_date, $nepali_date, $chori_bachat['dob']);
    $date2 = str_replace($eng_date, $nepali_date,$chori_bachat['verified_date']);
    $mobile = str_replace($eng_date, $nepali_date,$chori_bachat['mobile_no']);
    ?>
    <h4><span style="font-weight:bold;">जन्म मिति :</span> <?= $date1 ?> </h4>
    <h4><span style="font-weight:bold;">मोबाइल न.:</span> <?= $mobile ?> </h4>
    <h4><span style="font-weight:bold;">नगरपालिका:</span> <?= $municipals['municipal_nepali'] ?> </h4>
    <h4><span style="font-weight:bold;">दर्ता मिति:</span> <?= $date2 ?> </h4> 
    <h4><span style="font-weight:bold;">छोरीको ID:</span> <?= $chori_acc_details['chori_unique_id'] ?> </h4>
    </div>
    </div>
    <hr style="border: 1px solid black;border-bottom:0px;" id="hline">
</div>
    <div class="contain" id="target">
        <?php $form = ActiveForm::begin(); ?> 

        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>सी.न.</th>
                    <th>मिति</th>
                    <th>बर्ष</th>
                    <th>विशेष</th>
                    <th> डेबिट(रु.)</th>
                    <th> क्रेडिट(रु.)</th>
                    <th> ब्यालेन्स(रु.)</th>
                    

                    
                    
                </tr>
            </thead>

              
                <tbody id="tbody">
                <?php
                $count=1;
                if($withdraw) {
                    ?>
                    <tr>
                       <td><span><?= $count++ ?></span></td>
                       <?php
                       $new_date4 = str_replace($eng_date, $nepali_date, $economic_yr_last['economic_year']);
                       $new_date3 = str_replace($eng_date, $nepali_date, $withdraw['created_date']);
                       ?>
                       <td><span><?= $new_date3 ?></span></td>
                       <td><span><?= $new_date4 ?></span></td>
                       <td><span><?= $month_last['month_name'] ?> महिनाको भुक्तानी रकम</span></td>
                       <td><span></span></td>
                       <?php if($withdraw['amount']){ ?>
                       <td><span><?= $withdraw['amount']?></span></td>
                       <td><span ><?= $withdraw['amount']?></span></td>
                       <?php } else{ ?>
                        <td>0</td>
                        <td>0</td>
                        <?php } ?>
                       </tr>
                       <?php } ?>
                   
                    
                
                        
                       <?php 
                       $deposit=0;
                       $sum=0;
                       $last=0;
                       foreach($other_payment_chori as $opc) {
                        $year = \app\models\EconomicYear::find()->where(['id'=>$opc['fk_year']])->one();
                        $economic_yr1=\app\models\Year::find()->where(['id'=>$year['economic_year']])->one();
                        $month1=Month::find()->where(['id'=>$opc['fk_month']])->one();
                        $deposit=$deposit+$opc['amount'];
                       ?>
                        <tr>
                        <?php
                       $new_date3 = str_replace($eng_date, $nepali_date, $opc['created_date']);
                       $new_date4 = str_replace($eng_date, $nepali_date, $economic_yr1['economic_year']);
                       ?>
                       <?php $last=$count++ ?>
                       <td><span><?= $last?></span></td>
                       <td><span><?= $new_date3 ?></span></td>
                       <td><span><?= $new_date4 ?></span></td>
                       <td><span><?= $month1['month_name'] ?> महिनाको भुक्तानी रकम</span></td>
                       <td><sp><?= (int)$opc['amount'] ?></span></td>
                       <td><span>-  -  -</span></td>
                       <td><sp><?= (int)$opc['amount'] ?></sp></td>
                      

                       <?php } ?>
                    </tr>
                    
                    <?php if($payment_chori){?>   
                       <tr id="first_tr">
                       <td><span><?=$count++?></span></td>
                       <?php
                       $year_pay = \app\models\EconomicYear::find()->where(['id'=>$payment_chori['fk_economic_year']])->one();
                       $economic_yr2=\app\models\Year::find()->where(['id'=>$year_pay['economic_year']])->one();
                       $new_date1 = str_replace($eng_date, $nepali_date, $economic_yr2['economic_year']);
                       $new_date2 = str_replace($eng_date, $nepali_date, $payment_chori['created_date']);
                       ?>
                       <td><span><?= $new_date2 ?></span></td>
                       <td><span><?= $new_date1 ?></span></td>
                       <td><span><?= $month['month_name'] ?> महिनाको भुक्तानी रकम</span></td>
                       <td><span ><?= $payment_chori['amount'] ?> / (Initial)</span></td>
                       <td><span>-  -  -</span></td>
                       <td><span ><?= $payment_chori['amount'] ?> / (Initial)</span></td>
                       
                       </tr>  
                   <?php } ?>

                   <?php $sum=$deposit+$payment_chori['amount'];?>
                    <tr>
                    <td colspan="4" style="text-align:center;"><span>कुल </span></td>
                    <td><span id="amt"><?= $sum ?></span></td>
                    <?php if($withdraw['amount']){ ?>
                       <td><span><?= $withdraw['amount']?></span></td>
                       <?php } else{ ?>
                        <td>0</td>
                        <?php } ?>
                    
                   
                    <td><span id="amt"><?= $sum- $withdraw['amount']?></span></td>
                    </tr>
                        </tbody>
        </table>
        <?php ActiveForm::end(); ?>


    </div>
    <!--Html::Button('Print', ['class' => 'btn btn-success','onclick'=>'printDiv()'])?> -->
    
</div>

    
<script>
      function printDiv()
    {

        var divToPrint = document.getElementById('printdiv');

        var newWin = window.open('', 'Print-Window');

        newWin.document.open();

        newWin.document.write('<html><head><style>#target{padding:0px 25px 0px 25px;}#hline{display:none;}table{width: 100%;margin-left:0px;border: 1px solid black;border-collapse: collapse;} th,td{border: 1px solid black;border-collapse: collapse;} td{text-align:center;}.table.table-bordered td{text-align:center;}.chori-bachat-view1 .col-sm-4{margin-left:2.5em;}.chori-bachat-view1 .col-sm-6{margin:0 0 0 30em;position:relative;top:-210px;}.contain .table{position:relative;top:-160px;}</style></head><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

        newWin.document.close();

        setTimeout(function () {
            newWin.close();
        }, 10);

    }

   </script>