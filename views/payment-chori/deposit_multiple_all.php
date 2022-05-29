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
//var_dump($economic_year);die;
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
        $per_page=10;
    }

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'मासिक जम्माको लागी बैंकलाइ अनुरोध','url'=>['payment-chori/depositview']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="">
    <br>
    <span style="font-weight:bold;">छोरीहरुको विवरण: </span>
    <div class="" style="float:right;margin-right:1em;">
    <?= Html::Button('<i class="glyphicon glyphicon-resize-full"></i> All', ['name' => 'all1','class'=>'btn btn-default','id'=>'all','onclick'=>'page('.$selectmonth.','.$add_month.','.$selectyear.')']) ?>
    <?= Html::a('<i class="glyphicon glyphicon-resize-small"></i> Page', ['/payment-chori/deposit-multiple','month'=>$selectmonth,'add_month'=>$add_month,'year'=>$selectyear], ['name'=>'all2','id'=>'all2','class'=>'btn btn-default']) ?>
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
    <td><?= $a++ ?></td>
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
  

<div class="payment-chori-form">

    
        <br>
        <div class="col-sm-12">
        <div class="col-sm-3" >
        <?= $form->field($model, 'fk_economic_year')->hiddenInput(['maxlength' => true, 'readonly' => true, 'value' => $economic_year['economic_year']])->label(false) ?>
            <span style="font-weight:bold;">आर्थिक वर्ष: </span><?= 
            str_replace($eng_date, $nepali_date, $economic_year['economic_year'])?>
        
            </div>
            <div class="col-sm-4">
            <?= $form->field($model, 'fk_month')->hiddenInput(['maxlength' => true, 'readonly' => true, 'value' => $month['month_name']])->label(false) ?>
            <span style="font-weight:bold;">महिना: </span><?= $month['month_name']?>
            </div>
            <div class="col-sm-3"style="margin-top:1em;">
            <span style="font-weight:bold;">थप महिना: </span><?= $month1['month_name']?>
            </div>
            <br><br>
            <hr style="border: 1px solid black;border-bottom:0px;">
            </div>
            
            
    
        
        
  

   

    <div class="contain" id="target">
        
        <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
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
                                        $check_month=\app\models\Month::find()->where(['id'=>$test['fk_month']])->one();
                                        ?> 
                                        <h4 style="font-weight:bold;color:red;display:inline;"><?=$check_month['month_name']?>,</h4>
                                        
                                        
                                        <?php
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
                                
                                <td>
                                    <?= $count++; ?>
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
                            <td colspan="4" style="text-align:center;"><span style="margin-left:50em;">कुल</span></td>
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

