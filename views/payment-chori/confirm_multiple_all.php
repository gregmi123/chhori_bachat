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

$this->registerJs($this->render('verification.js'), 5);

$selectmonth=$_GET['month'];
$selectyear=$_GET['year'];
/* @var $this yii\web\View */
/* @var $model app\models\PaymentChori */
/* @var $form yii\widgets\ActiveForm */
$user_id = yii::$app->user->id;
$user_details = app\models\Users::findOne(['id' => $user_id]);
$money=\app\models\MoneySet::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['status'=>1])->one();
$chori_name = yii\helpers\ArrayHelper::map(\app\models\ChoriBachat::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['status' => 5])->all(), 'id', 'name');
//var_dump($chori_name);die;
$month =\app\models\Month::find()->where(['id'=>$selectmonth])->one();
$month1=\app\models\Month::find()->where(['id'=>$multi_month])->one();
//var_dump($bank_name);die;
$add_months = yii\helpers\ArrayHelper::map(\app\models\Month::find()->where(['id'=>$multi_month])->all(), 'id', 'month_name');
$year = \app\models\EconomicYear::find()->andWhere(['status' => 1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
$economic_year=\app\models\Year::find()->where(['id'=>$year['economic_year']])->one();
$bank=\app\models\BankDetails::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->one();
$bank_drop=yii\helpers\ArrayHelper::map(\app\models\BankDetails::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->all(),'id','bank_name');
//var_dump($economic_year);die;
$province=\app\models\Province::find()->Where(['id' => $user_details->fk_province_id])->one();




$eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
$nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');

if($multi_month){
$total_month_number=($multi_month-$selectmonth)+1;
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
    $per_page=10;
}

$this->title = 'छोरी मासिक रकम ';
$this->params['breadcrumbs'][] = ['label' => 'भुक्तानी','url'=>['payment-chori/multifind']];
$this->params['breadcrumbs'][] = ['label' => 'छोरी मासिक रकम','url'=>['payment-chori/multiple',
    'month'=>$selectmonth,
    'multi_month'=>$multi_month,
    'year'=>$selectyear,
    ]];
?>
<?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="col-md-12" style="width:94.5%;margin-left:3.9em;">
    <br>
    <?php 
        $a=1; 
        $start=0;
        $start=(($page-1)*$per_page)+1; 
    ?>
    <!-- <span style="font-weight:bold;">छोरीहरुको विवरण: </span>
    <div class="" style="float:right;margin-right:1em;">
    <?= Html::Button('<i class="glyphicon glyphicon-resize-full"></i> All', ['name' => 'all1','class'=>'btn btn-default','id'=>'all','onclick'=>'page('.$selectmonth.','.$multi_month.','.$selectyear.')']) ?>
    <?= Html::a('<i class="glyphicon glyphicon-resize-small"></i> Page', ['/payment-chori/confirm','month'=>$selectmonth,'multi_month'=>$multi_month,'year'=>$selectyear], ['name'=>'all2','id'=>'all2','class'=>'btn btn-default']) ?>
    </div>
    <hr style="border: 1px solid black;">
    <table class="table table-bordered">
    <th style="width:20px;">सी.न.</th>
    <th>नाम  </th>
    <th>ठेगाना </th>
    <th>बुवाको नाम  </th>
    <th>जन्म मिति    </th>
    <th>मोबाइल न.   </th>
    <th>नगरपालिका   </th>
    <th>दर्ता मिति   </th> 

    <?php
    $a=1; 
   
    foreach($models as $bachat){ 
        $district=District::find()->where(['id'=>$bachat['fk_per_district']])->one();
        $ward=Ward::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->where(['id'=>$bachat['fk_ward']])->one();
        $municipals=Municipals::find()->where(['id'=>$bachat['fk_per_municipal']])->one();
        $date1 = str_replace($eng_date, $nepali_date, $bachat['dob']);
        $date2 = str_replace($eng_date, $nepali_date,$bachat['created_date']);
        $mobile = str_replace($eng_date, $nepali_date,$bachat['mobile_no']);?>
    <tr>
    <td><?= $a++ ?></td>
    <td><?= $bachat['name'] ?></td>
    <td><?= $district['district_nepali'] ?>-<?= $bachat['tole_name'] ?>-<?= $ward['ward_name'] ?> </td>
    <td><?= $bachat['father_name'] ?></td>
    <td><?= $date1?></td>
    <td><?= $mobile ?></td>
    <td><?= $municipals['municipal_nepali'] ?></td>
    <td><?= $date2?></td>
    </tr>

    <?php } ?>
    </table> -->

    </div>
 

<div class="payment-chori-form"> 
        <br>
        <div class="col-md-12" style="width:92%;margin-left:5em;">
        <div class="" style="float:right;margin-right:1em;">
        <?= Html::Button('<i class="glyphicon glyphicon-resize-full"></i> All', ['name' => 'all1','class'=>'btn btn-default','id'=>'all','onclick'=>'page('.$selectmonth.','.$multi_month.','.$selectyear.')']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-resize-small"></i> Page', ['/payment-chori/confirm','month'=>$selectmonth,'multi_month'=>$multi_month,'year'=>$selectyear], ['name'=>'all2','id'=>'all2','class'=>'btn btn-default']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'fk_economic_year')->hiddenInput(['maxlength' => true, 'readonly' => true, 'value' => $economic_year['economic_year']])->label(false) ?>
            <span style="font-weight:bold;">आर्थिक वर्ष: </span><?= 
            str_replace($eng_date, $nepali_date, $economic_year['economic_year']);
            ?>
            </div>
            <div class="col-sm-3">
            <?= $form->field($model, 'fk_month')->hiddenInput(['maxlength' => true, 'readonly' => true, 'value' => $month['id']])->label(false) ?>
            <span style="font-weight:bold;">महिना: </span><?= $month['month_name']?>
            </div>
            <?php if(!($multi_month==0)){ ?>
            <div class="col-sm-3">
            <?= $form->field($model, 'add_month')->hiddenInput(['maxlength' => true, 'readonly' => true, 'value' => $month1['id']])->label(false) ?>
            <span style="font-weight:bold;">थप महिना: </span><?= $month1['month_name']?>
            </div>
            <?php } ?>
            </div>
            <hr>
            <hr style="border: 1px solid black;width:92%;margin-left:5em;">



    <div class="contain" id="target" style="width:92%;margin-left:5em;">
         
        <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width:20px;">सी.न.</th>
                    <th>छोरीको ID</th>
                    <th>नाम</th>
                    <th>बैंकको नाम </th>
                    <th> खाता न. </th>
                    <th style="width:200px;"> रकम रु.</th>
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
            <!-- <?= $form->field($model, 'id')->hiddenInput()->label(false) ?> -->
            <div class="container-items">
            
                <?php
                $totalpay=null;
                $nextpay=null;
                foreach ($multipleChhori as $i => $chhori):
                    $count = 1;
                    $total=0;
                    $count_month=1;
                    $count_insert=1;
                  
                    foreach ($models as $j => $opened) {
                        $date=explode('-',$opened['dob']);
                        if($date[1]==12){
                            $update_year=$date[0]+1;
                            $update_month=01;
                            $new_date=$update_year.'-'.$update_month.'-'.$date[2];
                        }else{
                            $update_year=$date[0];
                            $update_month=$date[1]+1;
                            $new_date=$update_year.'-'.$update_month.'-'.$date[2];
                        }
                        //var_dump($final_date);die;
                        ?>
                
                            <?= $form->field($chhori, "[{$j}]verified")->hiddenInput(['maxlength' => true, 'value' =>$new_date])->label(false) ?>
                            <?= $form->field($chhori, "[{$j}]fk_payment_chori")->hiddenInput(['maxlength' => true, 'value' => $opened['pid']])->label(false) ?>
                            <?= $form->field($chhori, "[{$j}]fk_chori_bachat")->hiddenInput(['maxlength' => true, 'value' => $opened['fk_chori_bachat']])->label(false) ?>
                            <?php 
                                if($multi_month){
                                $totalpay= OtherMonthPayment::find()
                                ->where(['fk_user_id' => $user_id])
                                ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                                ->andWhere(['fk_month' => $multi_month])
                                ->andWhere(['fk_year' => $selectyear])
                                ->andWhere(['fk_payment_chori' => $opened['pid']])
                                ->one();
                                $totalpay_sum= OtherMonthPayment::find()
                                ->where(['fk_user_id' => $user_id])
                                ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                                ->andFilterWhere(['between','fk_month',"$selectmonth","$multi_month"])
                                ->andWhere(['fk_year' => $selectyear])
                                ->andWhere(['fk_payment_chori' => $opened['pid']])
                                ->Sum('amount');
                                $nextpay=null;
                                $check=\app\models\OtherMonthPayment::find()
                                ->where(['fk_user_id' => $user_id])
                                ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                                ->andWhere(['fk_year' => $selectyear])
                                ->andWhere(['fk_payment_chori' => $opened['pid']])
                                ->andFilterWhere(['between','fk_month',"$selectmonth","$multi_month"])
                                ->all();
                                
                                if($count_month==1){
                                foreach($check as $test){
                                $check_month=\app\models\Month::find()->where(['id'=>$test['fk_month']])->one();?>
                                <h4 style="font-weight:bold;color:red;display:inline;"><?=$check_month['month_name']?>,</h4>
                                <?php } ?>
                                <?php if($check){ ?>
                                <h4 style="font-weight:bold;color:red;display:inline;">महिना सम्म जम्मा भैसकेको छ | </h4>

                                <?php
                                }
                                $count_month=0;
                                }
                            }
                                else{
                                    $totalpay=null;
                                    $nextpay= OtherMonthPayment::find()
                                    ->where(['fk_user_id' => $user_id])
                                    ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                                    ->andWhere(['fk_month' => $selectmonth])
                                    ->andWhere(['fk_year' => $selectyear])
                                    ->andWhere(['fk_payment_chori' => $opened['pid']])
                                    ->one();
                                    $nextpay_sum= OtherMonthPayment::find()
                                    ->where(['fk_user_id' => $user_id])
                                    ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                                    ->andWhere(['fk_month' => $selectmonth])
                                    ->andWhere(['fk_year' => $selectyear])
                                    ->andWhere(['fk_payment_chori' => $opened['pid']])
                                    ->sum('amount');
                                }
                                
                              
                            $paydrop=yii\helpers\ArrayHelper::map(
                                OtherMonthPayment::find()
                                ->andWhere(['fk_user_id' => $user_id])
                                ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                                ->andWhere(['fk_month' => $selectmonth])
                                ->andWhere(['fk_year' => $selectyear])
                                ->andWhere(['fk_payment_chori' => $opened['pid']])
                                ->all(),'id','amount');
                                
                                if($totalpay){
                                    
                                    ?>
                                <tr>
    
                                    <td>
                                        <?= $count++; ?>
                                    </td>
                                    <td>
                                    <?= $form->field($model, "chhori_id")->hiddenInput(['maxlength' => true, 'readonly' => true])->label(false) ?>
                                        <?= $opened['unique_id']?>
                                    </td>
                                    <td>
                                        <?= $form->field($chhori, "[{$j}]chhori_name")->hiddenInput(['maxlength' => true, 'readonly' => true, 'value' => $opened['name']])->label(false) ?>
                                        <?= $opened['name']?>
                                    </td>
                                    <td>
                                        <?= $form->field($chhori, "[{$j}]banks_name")->hiddenInput(['maxlength' => true, 'readonly' => true, 'value' => $opened['bank_name']])->label(false) ?>
                                        <?= $opened['bank_name']?>
                                    </td>
                                    <td>
                                        <?= $form->field($chhori, "[{$j}]chhori_account")->hiddenInput(['maxlength' => true, 'readonly' => true, 'value' => $opened['account_no']])->label(false) ?>
                                        <?= $opened['account_no']?>
                                    </td>
                                    <td>
                                        <?= $form->field($chhori, "[{$j}]amount")->hiddenInput(['maxlength' => true,'readonly' => true,  'value' =>$total_month_number*$totalpay['amount']])->label(false) ?>
                                        <span style="color:green;"><?= $totalpay_sum ?></span>
                                    </td>
                                </tr>
                                <?php $total=$total+($totalpay_sum) ?>
                                <?php }
                                else if($nextpay){
                                    $check=\app\models\OtherMonthPayment::find()
                                    ->where(['fk_user_id' => $user_id])
                                    ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                                    ->andWhere(['fk_month' => $selectmonth])
                                    ->andWhere(['fk_year' => $selectyear])
                                    ->andWhere(['fk_payment_chori' => $opened['pid']])
                                    ->all();
                                    if($count_month==1){
                                        foreach($check as $test){
                                        $check_month=\app\models\Month::find()->where(['id'=>$test['fk_month']])->one();?>
                                    
                                        <h4 style="font-weight:bold;color:red;"><?=$check_month['month_name'] ?>,
                                        <?php }
                                        if($check){?>
        
                                        महिनाको जम्मा भैसकेको छ |</h4>
                                    <?php } 
                                       
                                        $count_month=0;
                                        }
                                ?>
                            <tr>

                                <td>
                                    <?= $count++; ?>
                                </td>
                                <td>
                                    <?= $form->field($model, "chhori_id")->hiddenInput(['maxlength' => true, 'readonly' => true])->label(false) ?>
                                        <?= $opened['unique_id']?>
                                    </td>
                                <td>
                                    <?= $form->field($chhori, "[{$j}]chhori_name")->hiddenInput(['maxlength' => true, 'readonly' => true, 'value' => $opened['name']])->label(false) ?>
                                    <?= $opened['name']?>
                                </td>
                                <td>
                                    <?= $form->field($chhori, "[{$j}]banks_name")->hiddenInput(['maxlength' => true, 'readonly' => true, 'value' => $opened['bank_name']])->label(false) ?>
                                    <?= $opened['bank_name']?>
                                </td>
                                <td>
                                    <?= $form->field($chhori, "[{$j}]chhori_account")->hiddenInput(['maxlength' => true, 'readonly' => true, 'value' => $opened['account_no']])->label(false) ?>
                                    <?= $opened['account_no']?>
                                </td>
                                <td>
                                    <?= $form->field($chhori, "[{$j}]amount")->hiddenInput(['maxlength' => true,'readonly' => true,  'value' => $nextpay['amount']])->label(false) ?>
                                    <span style="color:green;"><?= (int)$nextpay_sum ?></span>
                                </td>

                            </tr>
                            <?php $total=$total+($nextpay_sum) ?>
                            <?php } else{ 
                                $acc_date=explode('-',$new_date);
                                $final_check_date=explode('-',$final_date);
                                //  var_dump($final_check_date);die;
                                if($final_check_date[0]==$acc_date[0]){
                                    if($final_check_date[1]>=$acc_date[1]){
                                
                                ?>        
                                        
                                   
                                
                                

                                <tr>

                            <td>
                            <?= $start++; ?>
                            </td>
                            <td>
                            <?= $form->field($model, "chhori_id")->hiddenInput(['maxlength' => true, 'readonly' => true])->label(false) ?>
                                <?= $opened['unique_id']?>
                            </td>
                            <td>
                                    <?= $form->field($chhori, "[{$j}]chhori_name")->hiddenInput(['maxlength' => true, 'readonly' => true, 'value' => $opened['name']])->label(false) ?>
                                    <?= $opened['name']." ".$opened['middle_name']." ".$opened['last_name']?>
                                </td>
                                <td>
                                    <?= $form->field($chhori, "[{$j}]banks_name")->hiddenInput(['maxlength' => true, 'readonly' => true, 'value' => $opened['bank_name']])->label(false) ?>
                                    <?= $opened['bank_name']?>
                                </td>
                                <td>
                                    <?= $form->field($chhori, "[{$j}]chhori_account")->hiddenInput(['maxlength' => true, 'readonly' => true, 'value' => $opened['account_no']])->label(false) ?>
                                    <?= $opened['account_no']?>
                                </td>
                                <?php 
                                if($multi_month){
                                    $calculated_month=0;
                                    $verified_year=explode('-',$new_date);
                                    $insert_year=explode('-',$final_date);
                                   //var_dump((int)$multi_month);die;
                                    if(((int)$verified_year[0]==(int)$insert_year[0] && ((int)$verified_year[1]-3)>=$selectmonth && ((int)$verified_year[1]-3)<= $multi_month)){
                                       // var_dump((int)$verified_year[1]);die;
                                            $verified_year_month=$verified_year[1]-3;
                                            //var_dump("hello");die;
                                            $calculated_month=(int)$multi_month-(int)$verified_year_month+1;
                                        }
                                        else if($multi_month>=10){
                                         if(((int)$verified_year[0]==(int)$insert_year[0] &&  $verified_year[1]<=3)){
                                            
                                            $verified_year_month=$verified_year[1]+9;
                                            $calculated_month=(int)$multi_month-(int)$verified_year_month+1;
                                        }
                                        else{
                                            $calculated_month=$total_month_number;
                                        }
                                    }
                                    else{
                                    $calculated_month=$total_month_number;
                                    }
                                        // else if(((int)$verified_year[0]==((int)$insert_year[0]-1) &&  $multi_month<=3)){
                                        //     $verified_year_month=$verified_year[1]-3;
                                        // }
                                        
                                        //var_dump($calculated_month);die;
                                ?>
                            <td>
                            <?= $form->field($chhori, "[{$j}]amount")->hiddenInput(['maxlength' => true,'value' =>$money['previous_payment']])->label(false); ?>
                            <?= $form->field($chhori,"[{$j}]multi_pay" )->hiddenInput(['maxlength' => true,'value' =>(int)$total_month_number*(int)$money['previous_payment']])->label(false) ?>
                            <span style="color:red;"><?= (int)$calculated_month*(int)$money['previous_payment'] ?></span> 
                        </td>
                        <?php }
                            
                    
                    
                    else { ?>
                            <td>
                            <?= $form->field($chhori, "[{$j}]amount")->hiddenInput(['maxlength' => true,'value' =>$money['previous_payment']])->label(false); ?>
                            <?= $form->field($chhori,"[{$j}]multi_pay" )->hiddenInput(['maxlength' => true,'value' =>(int)$total_month_number*(int)$money['previous_payment']])->label(false) ?>
                            <span style="color:red;"><?= (int)$total_month_number*(int)$money['previous_payment'] ?></span> 
                        </td>
                        <?php } ?>

                            </tr>
                            <?php
                            
                             $total=$total+((int)$calculated_month*(int)$money['previous_payment']);
                        }else{
                            continue;
                        } }
                            
                            else if($final_check_date[0]>$acc_date[0]) { ?>
                                <tr>

                            <td>
                            <?= $start++; ?>
                            </td>
                            <td>
                            <?= $form->field($model, "chhori_id")->hiddenInput(['maxlength' => true, 'readonly' => true])->label(false) ?>
                                <?= $opened['unique_id']?>
                            </td>
                            <td>
                                    <?= $form->field($chhori, "[{$j}]chhori_name")->hiddenInput(['maxlength' => true, 'readonly' => true, 'value' => $opened['name']])->label(false) ?>
                                    <?= $opened['name']." ".$opened['middle_name']." ".$opened['last_name']?>
                                </td>
                                <td>
                                    <?= $form->field($chhori, "[{$j}]banks_name")->hiddenInput(['maxlength' => true, 'readonly' => true, 'value' => $opened['bank_name']])->label(false) ?>
                                    <?= $opened['bank_name']?>
                                </td>
                                <td>
                                    <?= $form->field($chhori, "[{$j}]chhori_account")->hiddenInput(['maxlength' => true, 'readonly' => true, 'value' => $opened['account_no']])->label(false) ?>
                                    <?= $opened['account_no']?>
                                </td>
                                <?php 
                                if($multi_month){
                                    $calculated_month=0;
                                    $verified_year=explode('-',$new_date);
                                    $insert_year=explode('-',$final_date);
                                   //var_dump((int)$multi_month);die;
                                    if(((int)$verified_year[0]==(int)$insert_year[0] && ((int)$verified_year[1]-3)>=$selectmonth && ((int)$verified_year[1]-3)<= $multi_month)){
                                       // var_dump((int)$verified_year[1]);die;
                                            $verified_year_month=$verified_year[1]-3;
                                            //var_dump("hello");die;
                                            $calculated_month=(int)$multi_month-(int)$verified_year_month+1;
                                        }
                                        else if($multi_month>=10){
                                         if(((int)$verified_year[0]==(int)$insert_year[0] &&  $verified_year[1]<=3)){
                                            
                                            $verified_year_month=$verified_year[1]+9;
                                            $calculated_month=(int)$multi_month-(int)$verified_year_month+1;
                                        }
                                        else{
                                            $calculated_month=$total_month_number;
                                        }
                                    }
                                    else{
                                    $calculated_month=$total_month_number;
                                    }
                                        // else if(((int)$verified_year[0]==((int)$insert_year[0]-1) &&  $multi_month<=3)){
                                        //     $verified_year_month=$verified_year[1]-3;
                                        // }
                                        
                                        //var_dump($calculated_month);die;
                                ?>
                            <td>
                            <?= $form->field($chhori, "[{$j}]amount")->hiddenInput(['maxlength' => true,'value' =>$money['previous_payment']])->label(false); ?>
                            <?= $form->field($chhori,"[{$j}]multi_pay" )->hiddenInput(['maxlength' => true,'value' =>(int)$total_month_number*(int)$money['previous_payment']])->label(false) ?>
                            <span style="color:red;"><?= (int)$calculated_month*(int)$money['previous_payment'] ?></span> 
                        </td>
                        <?php }
                            
                    
                    
                    else { ?>
                            <td>
                            <?= $form->field($chhori, "[{$j}]amount")->hiddenInput(['maxlength' => true,'value' =>$money['previous_payment']])->label(false); ?>
                            <?= $form->field($chhori,"[{$j}]multi_pay" )->hiddenInput(['maxlength' => true,'value' =>(int)$total_month_number*(int)$money['previous_payment']])->label(false) ?>
                            <span style="color:red;"><?= (int)$total_month_number*(int)$money['previous_payment'] ?></span> 
                        </td>
                        <?php } ?>

                    </tr>
                    <?php $total=$total+((int)$calculated_month*(int)$money['previous_payment']) ?>
                            <?php } ?>
                            
                            
                            <?php } ?>
                            <?php } ?>
                            <tr>
                            <td colspan="5" style="text-align:center;font-weight:bold;"><span style="margin-left:50em;">कुल</span></td>
                            <td style="font-weight:bold;"><?= $total ?></td>
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
        </div>
        </div>
        <?php 
        $other_month=OtherMonthPayment::find()
        ->where(['fk_user_id' => $user_id])
        ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
        ->andWhere(['fk_month' => $selectmonth])
        ->andWhere(['fk_year' => $selectyear])
        ->one();
        ?>
        <?php ActiveForm::end(); ?>

    