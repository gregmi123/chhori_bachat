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
/* @var $this yii\web\View */
/* @var $model app\models\PaymentChori */
/* @var $form yii\widgets\ActiveForm */
$money=\app\models\MoneySet::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->one();
$year = \app\models\EconomicYear::find()->andWhere(['status' => 1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
$economic_year=\app\models\Year::find()->where(['id'=>$year['economic_year']])->one();
$chori_name = yii\helpers\ArrayHelper::map(\app\models\ChoriBachat::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['status' => 5])->all(), 'id', 'name');
//var_dump($chori_name);die;
// $month =\app\models\Month::find()->andWhere(['id'=>$selectmonth])->one();
// $month1=\app\models\Month::find()->where(['id'=>$add_month])->one();
//var_dump($bank_name);die;
// $add_months = yii\helpers\ArrayHelper::map(\app\models\Month::find()->where(['id'=>$add_month])->all(), 'id', 'month_name');


//var_dump($economic_year);die;
// $province=\app\models\Province::find()->Where(['id' => $user_details->fk_province_id])->one();
$eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
$nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
$bank=\app\models\BankDetails::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->one();
$province=\app\models\Province::find()->Where(['id' => $user_details->fk_province_id])->one();
?>

   
    <div class="">
    <br>
    <span style="font-weight:bold;">छोरीहरुको विवरण: </span>
    <div class="" style="float:right;">
        <?= Html::Button('<i class="glyphicon glyphicon-resize-full"></i> All', ['name' => 'all1','class'=>'btn btn-default','id'=>'all','onclick'=>'page('.$initial_id.')']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-resize-small"></i> Page', ['/payment-chori/initial-deposit','initial_id'=>$initial_id], ['name'=>'all2','id'=>'all2','class'=>'btn btn-default']) ?>
        </div>
    <hr style="border: 1px solid black;">
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

    foreach($models as $payment){ 
        $chori_bachat = \app\models\ChoriBachat::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['id' => $payment['fk_chori_bachat']])->one();
        $district=District::find()->where(['id'=>$chori_bachat['fk_per_district']])->one();
        $ward=Ward::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->where(['id'=>$chori_bachat['fk_ward']])->one();
        $municipals=Municipals::find()->where(['id'=>$chori_bachat['fk_per_municipal']])->one();
        $date1 = str_replace($eng_date, $nepali_date, $chori_bachat['dob']);
        $date2 = str_replace($eng_date, $nepali_date,$chori_bachat['created_date']);
        $mobile = str_replace($eng_date, $nepali_date,$chori_bachat['mobile_no']);?>
    <tr>
    <td><?= $a++ ?></td>
    <td><?= $chori_bachat['unique_id'] ?></td>
    <td><?= $chori_bachat['name']." ".$chori_bachat['middle_name']." ".$chori_bachat['last_name'] ?></td>
    <td><?= $district['district_nepali'] ?>-<?= $chori_bachat['tole_name'] ?>-<?= $ward['ward_name'] ?> </td>
    <td><?= $chori_bachat['father_name'] ?></td>
    <td><?= $date1?></td>
    <td><?= $mobile ?></td>
    <td><?= $municipals['municipal_nepali'] ?></td>
    <td><?= $date2?></td>
    </tr>

    <?php } ?>
    </table>
    

    </div> 

<div class="payment-chori-form" >

    
        <br>
        <div class="row">
        <div class="col-sm-3" >
        
            <span style="font-weight:bold;">आर्थिक वर्ष: </span><?= str_replace($eng_date,$nepali_date,$economic_year['economic_year'])?>
        
            </div>
            
            </div>
            <hr style="border: 1px solid black;">
    
        
        
  

   

    <div class="contain" id="target">
        
        
        <table class="table table-bordered">
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

            
           
            <div class="container-items">
                <?php
                
                    $count = 1;
                    $total=0;
                    $total_amount=0;
                    $count_month=1;
                   
                    foreach ($models as $pchori) {
                        //var_dump($opened->id);die;
                        $bachat = \app\models\ChoriBachat::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['id' => $pchori['fk_chori_bachat']])->one();
                        $chori_account=\app\models\ChoriAccountDetails::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['id' => $payment['fk_chori_account_details']])->one();
                        $bank=\app\models\BankDetails::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['id'=>$chori_account['bank_name']])->one();
                        ?>
               
                                
                                
                                
                            <tr>

                                <td>
                                    <?= $count++; ?>
                                </td>
                                <td>
                                    
                                    <?= $bachat['unique_id']?>
                                </td>
                                <td>
                                    
                                    <?= $bachat['name']." ".$bachat['middle_name']." ".$bachat['last_name']?>
                                </td>
                                <td>
                                    <?= $bank['bank_name']?>
                                </td>
                                <td>
                                    
                                    <?= $chori_account['account_no']?>
                                </td>
                                <td>
                                    
                                    <?= (int)$pchori['amount'] ?>
                                </td>

                            </tr>
                            
                            <?php $total=$total+($pchori['amount']) ?>
                            <?php }  ?>
                            <tr>
                            <td colspan="5" style="text-align:center;"><span style="text-align:center;">कुल</span></td>
                            <td><?= $total ?></td>
                            </tr>
                                
                            
                       
                    
                
</div>

        </table>
        


    </div>
</div>
    

