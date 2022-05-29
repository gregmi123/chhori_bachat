<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\ChoriBachat;
use app\models\OtherMonthPayment;
$helper = new app\controllers\Helper();
use app\models\District;
use app\models\Ward;
use app\models\Municipals;

$selectmonth=$_GET['month'];
$selectyear=$_GET['year'];
/* @var $this yii\web\View */
/* @var $model app\models\PaymentChori */
/* @var $form yii\widgets\ActiveForm */
$user_id = yii::$app->user->id;
$user_details = app\models\Users::findOne(['id' => $user_id]);
$money=\app\models\MoneySet::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->one();
$chori_name = yii\helpers\ArrayHelper::map(\app\models\ChoriBachat::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['status' => 5])->all(), 'id', 'name');
//var_dump($chori_name);die;
$month =\app\models\Month::find()->andWhere(['id'=>$selectmonth])->one();
$month1=\app\models\Month::find()->where(['id'=>$add_month])->one();
//var_dump($bank_name);die;
$add_months = yii\helpers\ArrayHelper::map(\app\models\Month::find()->where(['id'=>$add_month])->all(), 'id', 'month_name');
$year = \app\models\EconomicYear::find()->andWhere(['status' => 1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
$economic_year=\app\models\Year::find()->where(['id'=>$year['economic_year']])->one();
$bank=\app\models\BankDetails::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->one();
// var_dump($models);die;
$province=\app\models\Province::find()->Where(['id' => $user_details->fk_province_id])->one();

$eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
$nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');

if($add_month){
    $total_month_number=($add_month-$selectmonth)+1;
    }
    else{
        $total_month_number=1;
    }

    if(isset($_GET['page'])){
        $page=$_GET['page'];
    }
    else{
        $page=1;
    }
    if(isset($_GET['per-page'])){
    $per_page=$_GET['per-page'];
    }
    else{
        $per_page=20;
    }

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'मासिक जम्माको लागी बैंकलाइ अनुरोध','url'=>['payment-chori/depositview']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
#find{
    background-color:red;
    color:white;
    margin-top:1.7em;
    margin-left:3em;

}
th,td{
    text-align:center;
    width:auto;
}
#extra_month{
    margin-top:1em;
}
</style>
<br>
<button class="btn btn-success" style="float:right;" onclick="printDiv()">Print</button>
<!-- <button class="btn btn-primary" style="float:left;">Update</button> -->
<?php 
                    $update=\app\models\OtherMonthPayment::find()
                    ->where(['fk_user_id' => $user_id])
                    ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                    ->andWhere(['fk_province_id'=>$user_details['fk_province_id']])
                    ->andWhere(['fk_year' => $selectyear])
                    ->andWhere(['fk_month'=>$selectmonth])
                    ->one();
                    // var_dump($update);die;
if($update){?>
<?= Html::a('Update',['check-update','month'=>$selectmonth,'year'=>$selectyear,'add_month'=>$add_month],['style'=>'float:left;','class'=>'btn btn-primary']) ?>
<?php } ?>
<div id="printdiv">
<?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?> 
  <div class="row-no-gutters">
    <div class="col-md-12">
        
        <p style="text-align: center;font-family: sans-serif;font-size: 19px;line-height: 29px;padding-top:2em; ">
        <?php
                    $municipalModel = new app\models\ChoriBachat();
                    echo $municipalModel->getMunicipal($user_details['fk_municipal_id']);
                    ?><br><!-- comment -->
                    नगर/गाँउ कार्यपालिका को कार्यालय <br>
                    <?php
                    $districtModel = new app\models\ChoriBachat();
                    echo $districtModel->getDistrict($user_details['fk_district_id']);
                    ?>
        </p>
    </div>
    <div class="row">
        <div class="col-md-12">
        <div class="col-md-12">
                <p style="float:right;font-size: 19px;">
                    मिति :<?= 
                    str_replace($eng_date, $nepali_date, $helper->actionNepaliDate());
                    ?>
                </p>
            </div>
            <br><br>
            <div class="col-md-8">
                <p style=" margin-left: 13%;font-family: sans-serif;font-size: 19px;">
                    श्री प्रबन्धक ज्ज्यु ,<br>
                    <?php 
                    $cheque=0;
                    if($add_month){
                    $check=\app\models\OtherMonthPayment::find()
                    ->where(['fk_user_id' => $user_id])
                    ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                    ->andWhere(['fk_year' => $selectyear])
                    ->andFilterWhere(['between','fk_month',"$selectmonth","$add_month"])
                    ->all();}
                    else{
                        $check=\app\models\OtherMonthPayment::find()
                    ->where(['fk_user_id' => $user_id])
                    ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                    ->andWhere(['fk_year' => $selectyear])
                    ->andWhere(['fk_month'=>$selectmonth])
                    ->all();
                    }
                    if($add_month){
                        $total_amount1=OtherMonthPayment::find()
                        ->andWhere(['fk_user_id' => $user_id])
                        ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                        ->andWhere(['fk_year' => $selectyear])
                        ->andFilterWhere(['between','fk_month',"$selectmonth","$add_month"])
                        ->Sum('amount');
                        }
                        else{
                            
                        $total_amount1=OtherMonthPayment::find()
                        ->andWhere(['fk_user_id' => $user_id])
                        ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                        ->andWhere(['fk_year' => $selectyear])
                        ->andWhere(['fk_month'=>$selectmonth])
                        ->Sum('amount');
                        }
                        if($check){
                    foreach($check as $test){
                        $date_bank = str_replace($eng_date, $nepali_date, $test['created_date']);
                        $check_bank=\app\models\BankDetails::find()->where(['id'=>$test['fk_bank']])->one();
                        // echo ($test['cheque_no'].",");
                        }
                        // echo((int)$total_amount1);
                        $bank=$check_bank['bank_name'].',';
                        $cheque=$test['cheque_no'];
                        echo $bank ;
                    }
                    
                    ?> 
                    <br>
                    <?= $province['province_nepali'] ?>,
                    
                </p> 
            </div>
        </div>
    </div><br><!-- comment -->
    <div class="row-no-gutters">
        <div class="col-md-12">
            <h4 style="text-align: center;font-weight: bold;font-size: 18px;">
                बिषय : जम्मा गरी पाउँ भन्ने बारे। 
            </h4>
        </div>
        <div class="col-md-12">
            <div class="col-md-11">
                <h4 style="text-align: justify;padding-left: 8%; " >
                प्रस्तुत बिषयमा कर्णाली प्रदेश सरकारको <span style="font-weight: bold;">बैंक खाता छोरीको, सुरक्षा जीवन भरिको </span> कार्यक्रम अन्तर्गत देहाएको 
                    छोरीहरुको खातामा दिएको कुल रकम जम्मा गरिदिन अनुरोध छ | निजहरुको खातामा जम्मा गरी खाता नम्बर सहितको जानकारी यस कार्यालयमा पठाईदिनु हुन अनुरोध छ।  
                 <br><br>
                 
                </h4>
                
            </div>
        </div>
    </div>
    <div class="multiple" id="multiple_report">
    <div class="">
    <br>
    <span style="font-weight:bold;">छोरीहरुको विवरण: </span>
    <div class="" style="float:right;margin-right:1em;">
    <?= Html::Button('<i class="glyphicon glyphicon-resize-full"></i> All', ['name' => 'all1','class'=>'btn btn-default','id'=>'all','onclick'=>'page('.$selectmonth.','.$add_month.','.$selectyear.')']) ?>
    <?= Html::a('<i class="glyphicon glyphicon-resize-small"></i> Page', ['/payment-chori/confirm','month'=>$selectmonth,'add_month'=>$add_month,'year'=>$selectyear], ['name'=>'all2','id'=>'all2','class'=>'btn btn-default']) ?>
    </div>
    <hr style="border: 1px solid black;border-bottom:0px;">
    <table class="table table-bordered">
    <th>सी.न.</th>
    <th>छोरीको ID</th>
    <th>नाम  </th>
    <th>ठेगाना </th>
    <th>बुवाको नाम  </th>
    <th>जन्म मिति    </th>
    <th>मोबाइल न.   </th>
    <th>नगरपालिका   </th>
    <th>दर्ता मिति   </th> 

    <?php
    $a=1; 
    $start=0;
    $start=(($page-1)*$per_page)+1; 
    foreach($models as $bachat){ 
        if($add_month){
            $other_payment=OtherMonthPayment::find()
            ->andWhere(['fk_user_id' => $user_id])
            ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
            ->andWhere(['fk_year' => $selectyear])
            ->andWhere(['fk_chori_bachat'=>$bachat['id']])
            ->andFilterWhere(['between','fk_month',"$selectmonth","$add_month"])
            ->Sum('amount');
            }else{
        $other_payment=OtherMonthPayment::find()
        ->andWhere(['fk_user_id' => $user_id])
        ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
        ->andWhere(['fk_year' => $selectyear])
        ->andWhere(['fk_month'=>$selectmonth])
        ->andWhere(['fk_chori_bachat'=>$bachat['id']])
        ->Sum('amount');
            }
        $district=District::find()->where(['id'=>$bachat['fk_per_district']])->one();
        $ward=Ward::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->where(['id'=>$bachat['fk_ward']])->one();
        $municipals=Municipals::find()->where(['id'=>$bachat['fk_per_municipal']])->one();
        $date1 = str_replace($eng_date, $nepali_date, $bachat['dob']);
        $date2 = str_replace($eng_date, $nepali_date,$bachat['created_date']);
        $mobile = str_replace($eng_date, $nepali_date,$bachat['mobile_no']);?>
      <?php if((int)$other_payment==0){ ?>  
        <tr>

        </tr>
        <?php } else { ?>
    <tr>
    <td style="width:5%;"><?= $start++ ?></td>
    <td><?= $bachat['unique_id'] ?></td>
    <td><?= $bachat['name']." ".$bachat['middle_name']." ".$bachat['last_name'] ?></td>
    <td><?= $district['district_nepali'] ?>-<?= $bachat['tole_name'] ?>-<?= $ward['ward_name'] ?> </td>
    <td><?= $bachat['father_name'] ?></td>
    <td><?= $date1?></td>
    <td><?= $mobile ?></td>
    <td><?= $municipals['municipal_nepali'] ?></td>
    <td><?= $date2?></td>
    </tr>

    <?php }  } ?>
    </table>

    </div>
  

<div class="payment-chori-form" >

    
        <br>
        <div class="col-sm-12" style="display:flex;">
        <div class="col-sm-3" id="year" >
        <?= $form->field($model, 'fk_economic_year')->hiddenInput(['maxlength' => true, 'readonly' => true, 'value' => $economic_year['economic_year']])->label(false) ?>
            <span style="font-weight:bold;">आर्थिक वर्ष: </span><?= 
            str_replace($eng_date, $nepali_date, $economic_year['economic_year'])?>
        
            </div>
            <div class="col-sm-4" id="month">
            <?= $form->field($model, 'fk_month')->hiddenInput(['maxlength' => true, 'readonly' => true, 'value' => $month['month_name']])->label(false) ?>
            <span style="font-weight:bold;">महिना: </span><?= $month['month_name']?>
            </div>
            <div class="col-sm-3" id="extra_month">
            <span style="font-weight:bold;">थप महिना: </span><?= $month1['month_name']?>
            </div>
            <br><br>
            <hr style="border: 1px solid black;border-bottom:0px;">
            </div>
            
            
    
        
        
  

   

    <div class="contain" id="target">
        
        <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
        <table class="table table-bordered" id="second_table">
            <thead>
                <tr>
                    <th>सी.न.</th>
                    <th>छोरीको ID</th>
                    <th>नाम</th>
                    <th>बैंकको नाम </th>
                    <th> खाता न. </th>
                    <th> रकम रु.</th>
                </tr>
            </thead>

            <?php
            DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $multipleChhori[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'fk_year',
                    'fk_month',
                    'amount',
                ],
            ]);
            ?>
            <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
            <div class="container-items">
                <?php
                foreach ($multipleChhori as $i => $chhori):
                    $count = 1;
                    $total=0;
                    $total_amount=0;
                    $count_month=1;
                    $comma_count=1;
                    $start=0;
                    $start=(($page-1)*$per_page)+1; 
                    foreach ($models as $j => $opened) {
                        //var_dump($opened->id);die;
                        ?>
               
                            
                            <?= $form->field($chhori, "[{$j}]fk_payment_chori")->hiddenInput(['maxlength' => true, 'value' => $opened['pid']])->label(false) ?>
                            <?php
                            if($add_month){
                            $nextpay= OtherMonthPayment::find()
                                ->andWhere(['fk_user_id' => $user_id])
                                ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                                ->andWhere(['fk_year' => $selectyear])
                                ->andFilterWhere(['between','fk_month',"$selectmonth","$add_month"])
                                ->andWhere(['fk_payment_chori' => $opened['pid']])
                                ->all();
                            $total_amount=OtherMonthPayment::find()
                            ->andWhere(['fk_user_id' => $user_id])
                            ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                            ->andWhere(['fk_year' => $selectyear])
                            ->andFilterWhere(['between','fk_month',"$selectmonth","$add_month"])
                            ->andWhere(['fk_payment_chori' => $opened['pid']])
                            ->Sum('amount');
                            }
                            else{
                                $nextpay= OtherMonthPayment::find()
                                ->andWhere(['fk_user_id' => $user_id])
                                ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                                ->andWhere(['fk_year' => $selectyear])
                                ->andWhere(['fk_month'=>$selectmonth])
                                ->andWhere(['fk_payment_chori' => $opened['pid']])
                                ->all();
                            $total_amount=OtherMonthPayment::find()
                            ->andWhere(['fk_user_id' => $user_id])
                            ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                            ->andWhere(['fk_year' => $selectyear])
                            ->andWhere(['fk_month'=>$selectmonth])
                            ->andWhere(['fk_payment_chori' => $opened['pid']])
                            ->Sum('amount');
                            }
                           
                            $paydrop=yii\helpers\ArrayHelper::map(
                                OtherMonthPayment::find()
                                ->andWhere(['fk_user_id' => $user_id])
                                ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                                ->andWhere(['fk_month' => $selectmonth])
                                ->andWhere(['fk_year' => $selectyear])
                                ->andWhere(['fk_payment_chori' => $opened['pid']])
                                ->all(),'id','amount');
                                
                                if($nextpay){
                                    if($count_month==1){?>
                                    <div class="hide1">
                                        <?php
                                        foreach($nextpay as $test){
                                            $comma=count($nextpay);

                                            if(($comma_count==$comma)){
                                                $check_month=\app\models\Month::find()->where(['id'=>$test['fk_month']])->one();?>
                                                <h4 style="font-weight:bold;color:red;display:inline;"><?=$check_month['month_name']?></h4>
                                                
                                                <?php  }
                                                else{ 
                                                    $comma_count=$comma_count+1;
                                                $check_month=\app\models\Month::find()->where(['id'=>$test['fk_month']])->one();?>
                                                <h4 style="font-weight:bold;color:red;display:inline;"><?=$check_month['month_name']?>,</h4>
                                                <?php }
                                        }
                                        ?>
                                        <h4 style="font-weight:bold;color:red;display:inline;">महिना सम्म जम्मा भैसकेको छ | के सेलेक्ट गरेको महिना ठिक्छ ?</h4>
                                        </div>
                                        <?php
                                       $count_month=0;
                                        }
                                if((int)$total_amount==0) { ?>
                                <tr>

                                </tr>
                            <?php }else{ ?>
                            <tr>
                                
                                <td style="width:5%;">
                                    <?= $start++; ?>
                                </td>
                                <td>
                                    
                                    <?= $opened['unique_id']?>
                                </td>
                                <td>
                                    
                                    <?= $opened['name']." ".$opened['middle_name']." ".$opened['last_name']?>
                                </td>
                                <td>
                                    
                                    <?= $opened['bank_name']?>
                                </td>
                                <td>
                                    
                                    <?= $opened['account_no']?>
                                </td>
                                <td>
                                    
                                    <?= (int)$total_amount ?>
                                </td>
                                    <?php } ?>
                            </tr>
                            <?php $total=$total+($total_amount) ?>
                            <?php } else{ ?>
                                <tr>

                            

                            </tr>
                            <?php } ?>
                            <?php } ?>
                            <tr>
                            <td colspan="5" style="text-align:center;"><span id="kul">कुल</span></td>
                            <td><?= $total ?></td>
                            </tr>
                        <div class="item "><!-- widgetBody -->

                            <div class="lists">
                                <?php
                                // necessary for update action.
                                if (!$model->isNewRecord) {
                                    echo Html::activeHiddenInput($model, "[{$i}]id");
                                }
                                ?>
                            </div>
                        </div>
                    
                <?php endforeach; ?>
</div>
                <?php DynamicFormWidget::end(); ?>


            

        </table>
        <?php ActiveForm::end(); ?>


    </div>
</div>
<div class="col-sm-8" style="margin-left:5.5%;">
        <?php 
        echo \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
        ]);
        ?>
        </div>
    </div>

</div>
    </div>
<script>
    function page(month,add_month,year){
        $.post('index.php?r=payment-chori/deposit-all&month='+month+'&add_month='+add_month+'&year='+year,function(data){
            document.getElementById('multiple_report').innerHTML=data;
        });
    }
    
</script>
<script>
// var target_data =document.getElementById('target');
//        target_data.hide();
    function myfun() {
        var target_data = document.getElementById('target');
        target_data.style.display = "block";
        var month = document.getElementById('month').value;
        var year = document.getElementById('economic-year').value;
        document.getElementById("find").disabled = false;
        //console.log(year);
        //alert(month);
        // console.log(month);
        $.post('index.php?r=payment-chori/chhori-list&month=' + month + '&year=' + year, function (data) {
            document.getElementById('tbody').innerHTML = data;
            //alert(data);

        });
        
    }
</script>
<script>
      function printDiv()
    {

        var divToPrint = document.getElementById('printdiv');

        var newWin = window.open('', 'Print-Window');

        newWin.document.open();

        newWin.document.write('<html><head><style>#kul{text-align:center;}\
        #multiple_report{margin-left:3em;}\
        hr{display:none;}\
        #month{margin-left:1em;}\
        #extra_month{margin-left:1em;margin-top:0em;}\
        #dynamic-form{margin-right:3em;}\
        table{width:100%;margin-left:0px;border: 1px solid black;border-collapse: collapse;}\
        th,td{border: 1px solid black;width:auto;border-collapse: collapse;}\
        td{text-align:center;}\
        .hide1{display:none;}\
        #all{display:none;}\
        #all2{display:none;}</style></head><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

        newWin.document.close();

        setTimeout(function () {
            newWin.close();
        }, 10);

    }

   </script>
<script>
// $(document).ready(function(){
//    $('#month').on('change', function(){
//       var month = $(this).val();
//       var year =$('#economic-year').val();
//       //alert(year);
//       //if(month!==""){
//           $.ajax({
//              url: 'chori_payment.php',
//              method : 'post',
//              data: {month:month, year:year},
//              success : function(data){
//                  $('#target').fadeIn(data);
//                  $('#target').val(data);
//                  alert(data);
//              }
//             
//           });
//       //}
//    });
// });
</script>
