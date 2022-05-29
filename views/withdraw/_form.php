<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model app\models\Withdraw */
/* @var $form yii\widgets\ActiveForm */
$id=$_GET['id'];
$user_id = yii::$app->user->id;
$user_details =\app\models\Users::findOne(['id' => $user_id]);
$dismiss=yii\helpers\Arrayhelper::map(app\models\Dismiss::find()->where(['fk_user_id'=>$user_id])->andWhere(['fk_municipal_id'=>$user_details['fk_municipal_id']])->andWhere(['type'=>1])->all(),'id','name');
$initial=app\models\PaymentChori::find()->where(['fk_chori_account_details'=>$id])->andWhere(['fk_user_id'=>$user_id])->andWhere(['fk_municipal'=>$user_details['fk_municipal_id']])->one();
$deposit=app\models\OtherMonthPayment::find()
->where(['fk_payment_chori'=>$initial['id']])
->andWhere(['fk_user_id'=>$user_id])
->andWhere(['fk_municipal'=>$user_details['fk_municipal_id']])
->Sum('amount');
$total=(int)$initial['amount']+(int)$deposit;
$year = \app\models\EconomicYear::find()->andWhere(['status' => 1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
$economic_year=\app\models\Year::find()->where(['id'=>$year['economic_year']])->one();
$month = yii\helpers\ArrayHelper::map(\app\models\Month::find()->all(), 'id', 'month_name');


$chori_acc_details=\app\models\ChoriAccountDetails::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['id'=>$id])->one();
$chori_bachat=\app\models\ChoriBachat::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['id'=>$chori_acc_details['fk_chori_bachat']])->one();
$district=\app\models\District::find()->where(['id'=>$chori_bachat['fk_per_district']])->one();
$bank=\app\models\BankDetails::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->where(['id'=>$chori_acc_details['bank_name']])->one();
$municipals=\app\models\Municipals::find()->where(['id'=>$chori_bachat['fk_per_municipal']])->one();
$ward=\app\models\Ward::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->where(['id'=>$chori_bachat['fk_ward']])->one();

$eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
$nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
?>

<div class="withdraw-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
    <?php 
    $nep_year=str_replace($eng_date,$nepali_date,$economic_year['economic_year']);
    $nep_total=str_replace($eng_date,$nepali_date,$total);
    ?>
    <div class="col-sm-4">
    <h4><span style="font-weight:bold;">नाम:</span> <?= $chori_bachat['name']; ?> </h4>
    <h4><span style="font-weight:bold;">ठेगाना:</span> <?= $district['district_nepali'] ?>-<?= $chori_bachat['tole_name'] ?>-<?= $ward['ward_name'] ?> </h4>
    <h4><span style="font-weight:bold;">बुवाको नाम:</span> <?= $chori_bachat['father_name'] ?> </h4>
    <h4><span style="font-weight:bold;">बैंक:</span> <?= $bank['bank_name'] ?> </h4>
    <h4><span style="font-weight:bold;">खाता न.:</span> <?= $chori_acc_details['account_no'] ?> </h4>
    </div>
    
    <div class="col-sm-6">
    <?php
    $date1_withdraw = str_replace($eng_date, $nepali_date, $chori_bachat['dob']);
    $date2_withdraw = str_replace($eng_date, $nepali_date,$chori_bachat['created_date']);
    $mobile_withdraw = str_replace($eng_date, $nepali_date,$chori_bachat['mobile_no']);
    ?>
    <h4><span style="font-weight:bold;">जन्म मिति :</span> <?= $date1_withdraw ?> </h4>
    <h4><span style="font-weight:bold;">मोबाइल न.:</span> <?= $mobile_withdraw ?> </h4>
    <h4><span style="font-weight:bold;">नगरपालिका:</span> <?= $municipals['municipal_nepali'] ?> </h4>
    <h4><span style="font-weight:bold;">दर्ता मिति:</span> <?= $date2_withdraw ?> </h4> 
    <h4><span style="font-weight:bold;">छोरीको ID:</span> <?= $chori_acc_details['chori_unique_id'] ?> </h4>
    </div>
    </div>
    <hr style="border: 1px solid black;">
    
    <?= $form->field($model, 'fk_account')->hiddenInput(['value'=>$id])->label(false) ?>
    <?= $form->field($model, 'fk_economic_year')->hiddenInput(['value'=>$economic_year['id']])->label(false) ?>
    
    <div class="row">
        <div class="col-md-3" style="margin-top:2em;">
    <span style="font-weight:bold;">आर्थिक बर्ष:</span> <?= $nep_year ?>
    </div> 
    
</div>

<div class="row">
    <div class="col-md-3">
    
    <?= $form->field($model, 'amount')->hiddenInput(['maxlength' => true,'value'=>$total])->label(false); ?>
    <span style="font-weight:bold;">कुल रकम:</span> <?= $nep_total?>
    </div> 

</div>
    <br>
    
  
    <div class="row">
        <div class="col-md-3">
        <?= $form->field($model, 'fk_month')->dropDownList($month, ['id' => 'month', 'prompt' => 'छान्नुहोस्']); ?>
    </div>
    <div class="col-md-3">
    <?= $form->field($model, 'fk_dismiss')->dropdownList($dismiss,['id' => 'withdraw', 'prompt' => 'छान्नुहोस्']) ?>
    </div>
    <div class="col-md-12">
    <?= $form->field($model, 'description')->widget(TinyMce::className(), [
    'options' => ['rows' => 6],
    'language' => 'en',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    ]
]);?>


    </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('पेश गर्नुहोस', ['class' => 'btn btn-success',
        'data' => [
            'confirm' => 'के जम्मा रकम निकाल्न चाहानुहुन्छ ?',
            'method' => 'post',
        ],
    ]); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
