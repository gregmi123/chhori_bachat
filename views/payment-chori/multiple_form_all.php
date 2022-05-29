<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\ChoriBachat;
use app\models\OtherMonthPayment;
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
$selectmonth=$_GET['month'];
$selectyear=$_GET['year'];
/* @var $this yii\web\View */
/* @var $model app\models\PaymentChori */
/* @var $form yii\widgets\ActiveForm */
$user_id = yii::$app->user->id;
$user_details = app\models\Users::findOne(['id' => $user_id]);
$money=\app\models\MoneySet::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['status'=>1])->one();
$chori_name = yii\helpers\ArrayHelper::map(\app\models\ChoriBachat::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['status' => 1])->all(), 'id', 'name');
//var_dump($chori_name);die;
$month =\app\models\Month::find()->where(['id'=>$selectmonth])->one();
$upto_month=\app\models\Month::find()->where(['id'=>$multi_month])->one();
$add_months = yii\helpers\ArrayHelper::map(\app\models\Month::find()->all(), 'id', 'month_name');
//var_dump($bank_name);die;
$year = \app\models\EconomicYear::find()->andWhere(['status' => 1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
$economic_year=\app\models\Year::find()->where(['id'=>$year['economic_year']])->one();
$eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
$nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
//var_dump($economic_year);die;

if($multi_month){
    $total_month_number=($multi_month-$selectmonth)+1;
    }
    else{
        $total_month_number=1;
    }
?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>सी.न.</th>
                    <th>छोरीको ID</th>
                    <th>नाम</th>
                    <th>बैंकको नाम </th>
                    <th> खाता न. </th>
                    <th> रकम रु.</th>
                    <th>टिप्पणी</th>
                </tr>
            </thead>

            
            <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
            <div class="container-items">
                <?php
                foreach ($multipleChhori as $i => $chhori):
                    $count = 1;
                    $total=0;
                    $count_month=1;
                    $count_insert=1;
                    $comma_count=1;
                    $totalpay_sum=0;
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
                        //var_dump($opened);die;
                        //var_dump($opened->id);die;
                        ?>
                
                            
                            <?= $form->field($chhori, "[{$j}]fk_payment_chori")->hiddenInput(['maxlength' => true, 'value' => $opened['pid']])->label(false) ?>
                            <?php 
                            if(!($multi_month==0)){
                            $totalpay= OtherMonthPayment::find()
                            ->where(['fk_user_id' => $user_id])
                            ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                            ->andFilterWhere(['between','fk_month',"$selectmonth","$multi_month"])
                            ->andWhere(['fk_year' => $selectyear])
                            ->andWhere(['fk_payment_chori' => $opened['pid']]);
                            
                            $totalpay_sum=$totalpay->Sum('amount');
                            // var_dump($totalpay_sum);die;
                            $totalpay_all=$totalpay->all();
                            $totalpay_count=$totalpay->all();
                            $description_value=0;
                            foreach($totalpay_count as $tpc){
                                if(!($tpc['amount']==0)){
                                    $description_value=$description_value+1;
                                }
                            }
                            $compare=$multi_month-$selectmonth+1;
                            //var_dump($compare);die;
                            if($count_month==1){
                                foreach($totalpay_all as $test){
                                $comma=count($totalpay_all);

                                if(($comma_count==$comma)){
                                $check_month=\app\models\Month::find()->where(['id'=>$test['fk_month']])->one();?>
                                <h4 style="font-weight:bold;color:red;display:inline;"><?=$check_month['month_name']?></h4>
                                
                                <?php  } else{ 
                                    $comma_count=$comma_count+1;
                                $check_month=\app\models\Month::find()->where(['id'=>$test['fk_month']])->one();?>
                                <h4 style="font-weight:bold;color:red;display:inline;"><?=$check_month['month_name']?>,</h4>
                                <?php } } 
                                // var_dump($comma);die;
                                ?>
                                
                                <?php if($totalpay_all){ ?>
                                <h4 style="font-weight:bold;color:red;display:inline;">महिना सम्म जम्मा भैसकेको छ | </h4>

                                <?php
                                }
                                $count_month=0;
                                }
                            }else{
                                $compare=1;
                            $totalpay= OtherMonthPayment::find()
                                    ->where(['fk_user_id' => $user_id])
                                    ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                                    ->andWhere(['fk_month' => $selectmonth])
                                    ->andWhere(['fk_year' => $selectyear])
                                    ->andWhere(['fk_payment_chori' => $opened['pid']]);
                            
                            $totalpay_sum=$totalpay->Sum('amount');
                            //var_dump($totalpay_sum);die;
                            $totalpay_all=$totalpay->all();
                            $totalpay_count=(int)$totalpay_sum/(int)$money['previous_payment'];
                            $description_value=(int)$multi_month-(int)$totalpay_count;
                            if($count_month==1){
                                foreach($totalpay_all as $test){
                                $check_month=\app\models\Month::find()->where(['id'=>$test['fk_month']])->one();?>
                                <h4 style="font-weight:bold;color:red;display:inline;"><?=$check_month['month_name']?></h4>
                                <?php } ?>
                                <?php if($totalpay_all){ ?>
                                <h4 style="font-weight:bold;color:red;display:inline;">महिना सम्म जम्मा भैसकेको छ | </h4>

                                <?php
                                }
                                $count_month=0;
                                }
                                    
                            }
                            if($totalpay_sum){
                            ?>
                            <tr>

                            <td>
                            <?= $count++?>
                            </td>
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
                                    <span style="color:green;"><?= (int)$totalpay_sum ?></span> 
                            </td>
                            <!-- <php if($compare==1){ ?>
                                <td> पहिले खुलिसकेको  खाता  </td>
                            <php } else { ?>    
                            <php if($compare==$description_value){ ?>
                                <td> पहिले खुलिसकेको  खाता  </td>
                            <php } else {  -->
                                
                            <?php
                            $verified_year1=explode('-',$opened['dob']);
                            if((int)$verified_year1[1]>3){
                                $verified_year1[1]=(int)$verified_year1[1]-3;
                            }else{
                                $verified_year1[1]=(int)$verified_year1[1]+9;
                            }
                            $description_month=\app\models\Month::find()->where(['id'=>$verified_year1[1]])->one();
                             ?>
                                    <td><span style="color:blue;"><?= str_replace($eng_date, $nepali_date, $verified_year1[0])?></span> को <span style="color:blue;"><?= $description_month['month_name']?></span> मा जन्म भएको  </td>
                            <?php
                            
                            // } } 
                            $total=$total+(int)$totalpay_sum;
                            }else { 
                                $acc_date=explode('-',$new_date);
                                $final_check_date=explode('-',$final_date[0]);
                                // var_dump($final_check_date[1]);die;
                                if($final_check_date[0]==$acc_date[0]){
                                    if($final_check_date[1]>=$acc_date[1]){
                                ?>

                            <tr>

                            <td>
                            <?= $count++?>
                            </td>
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

                            <?php 
                                if(!($multi_month==0)){
                                    $calculated_month=0;
                                    $verified_year=explode('-',$new_date);
                                    $insert_year=explode('-',$final_date[0]);
                                   //var_dump($insert_year);die;
                                    if(((int)$verified_year[0]==(int)$insert_year[0] && ((int)$verified_year[1]-3)>=$selectmonth && ((int)$verified_year[1]-3)<= $multi_month)){
                                       // var_dump((int)$verified_year[1]);die;
                                            $verified_year_month=$verified_year[1]-3;
                                            $calculated_month=(int)$multi_month-(int)$verified_year_month+1;
                                            $description_value=(int)$multi_month-(int)$calculated_month;

                                        }
                                        else if($multi_month>=10){
                                         if(((int)$verified_year[0]==(int)$insert_year[0] &&  $verified_year[1]<=3)){
                                            
                                            $verified_year_month=$verified_year[1]+9;
                                            $calculated_month=(int)$multi_month-(int)$verified_year_month+1;
                                            $description_value=(int)$verified_year_month;
                                        }
                                        else{
                                            $calculated_month=$total_month_number;
                                            $description_value=null;
                                        }
                                    }
                                    else{
                                    $calculated_month=$total_month_number;
                                    $description_value=null;
                                    }
                                        // else if(((int)$verified_year[0]==((int)$insert_year[0]-1) &&  $multi_month<=3)){
                                        //     $verified_year_month=$verified_year[1]-3;
                                        // }
                                        
                                        //var_dump($calculated_month);die;
                                ?>
                                    <td>
                                    
                                    <span style="color:red;"><?= (int)$calculated_month*(int)$money['previous_payment'] ?></span> 
                                </td>
                                <?php 
                           
                           $verified_year1=explode('-',$opened['dob']);
                           if((int)$verified_year1[1]>3){
                               $verified_year1[1]=(int)$verified_year1[1]-3;
                           }else{
                               $verified_year1[1]=(int)$verified_year1[1]+9;
                           }
                           $description_month=\app\models\Month::find()->where(['id'=>$verified_year1[1]])->one(); ?> 
                           <td><span style="color:blue;"><?= str_replace($eng_date, $nepali_date, $verified_year1[0])?></span> को <span style="color:blue;"><?= $description_month['month_name']?></span> मा जन्म भएको  </td>
                               <?php 
                               $total=$total+((int)$calculated_month*(int)$money['previous_payment']);
                           }
                                    
                            
                            
                            else { 
                                $description_month=\app\models\Month::find()->where(['id'=>$selectmonth])->one();
                                ?>
                                    <td>
                                    
                                    <span style="color:red;"><?= (int)$total_month_number*(int)$money['previous_payment'] ?></span> 
                                </td>
                                
                                     
                                    <td> पहिले खुलिसकेको  खाता  </td>  
                                <?php
                                $total=$total+((int)$total_month_number*(int)$money['previous_payment']);
                                } ?>


                           

                            </tr>
                            <?php } } else if($final_check_date[0]>$acc_date[0]){ ?>

                        <tr>

                        <td>
                        <?= $count++?>
                        </td>
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

                        <?php 
                        if(!($multi_month==0)){
                            $calculated_month=0;
                            $verified_year=explode('-',$new_date);
                            $insert_year=explode('-',$final_date[0]);
                            if(((int)$verified_year[0]==(int)$insert_year[0] && ((int)$verified_year[1]-3)>=$selectmonth && ((int)$verified_year[1]-3)<= $multi_month)){
                            // var_dump((int)$verified_year[1]);die;
                                    $verified_year_month=$verified_year[1]-3;
                                    $calculated_month=(int)$multi_month-(int)$verified_year_month+1;
                                    $description_value=(int)$multi_month-(int)$calculated_month;

                                }
                                else if($multi_month>=10){
                                if(((int)$verified_year[0]==(int)$insert_year[0] &&  $verified_year[1]<=3)){
                                    
                                    $verified_year_month=$verified_year[1]+9;
                                    $calculated_month=(int)$multi_month-(int)$verified_year_month+1;
                                    $description_value=(int)$verified_year_month;
                                }
                                else{
                                    $calculated_month=$total_month_number;
                                    $description_value=null;
                                }
                            }
                            else{
                            $calculated_month=$total_month_number;
                            $description_value=null;
                            }
                                // else if(((int)$verified_year[0]==((int)$insert_year[0]-1) &&  $multi_month<=3)){
                                //     $verified_year_month=$verified_year[1]-3;
                                // }
                                
                                //var_dump($calculated_month);die;
                        ?>
                            <td>
                            
                            <span style="color:red;"><?= (int)$calculated_month*(int)$money['previous_payment'] ?></span> 
                        </td>
                        <?php 

                        $verified_year1=explode('-',$opened['dob']);
                        if((int)$verified_year1[1]>3){
                        $verified_year1[1]=(int)$verified_year1[1]-3;
                        }else{
                        $verified_year1[1]=(int)$verified_year1[1]+9;
                        }
                        $description_month=\app\models\Month::find()->where(['id'=>$verified_year1[1]])->one(); ?> 
                        <td><span style="color:blue;"><?= str_replace($eng_date, $nepali_date, $verified_year1[0])?></span> को <span style="color:blue;"><?= $description_month['month_name']?></span> मा जन्म भएको  </td>
                        <?php 
                        $total=$total+((int)$calculated_month*(int)$money['previous_payment']);
                        }
                            


                        else { 

                        $description_month=\app\models\Month::find()->where(['id'=>$selectmonth])->one();
                        ?>
                            <td>
                            
                            <span style="color:red;"><?= (int)$total_month_number*(int)$money['previous_payment'] ?></span> 
                        </td>

                            
                        <?php 

                        $verified_year1=explode('-',$opened['dob']);
                        if((int)$verified_year1[1]>3){
                        $verified_year1[1]=(int)$verified_year1[1]-3;
                        }else{
                        $verified_year1[1]=(int)$verified_year1[1]+9;
                        }
                        $description_month=\app\models\Month::find()->where(['id'=>$verified_year1[1]])->one(); ?>
                        <td><span style="color:blue;"><?= str_replace($eng_date, $nepali_date, $verified_year1[0])?></span> को <span style="color:blue;"><?= $description_month['month_name']?></span> मा जन्म भएको  </td> 
                        <?php
                        $total=$total+((int)$total_month_number*(int)$money['previous_payment']);
                        } ?>




                        </tr>
                            
                        <?php } ?>
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
                    <?php } }?>
                <?php endforeach; ?>
</div>
                
                <tr>
                <td colspan="4" style="text-align:center;font-weight:bold;"><span style="margin-left:50em;">कुल</span></td>
                <td style="font-weight:bold;"><?= $total ?></td>
                </tr>

            

        </table>
        <?php ActiveForm::end(); ?>
