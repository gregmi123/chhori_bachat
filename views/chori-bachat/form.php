<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\ChoriAccountDetails */
/* @var $form yii\widgets\ActiveForm */

$chori1 = \app\models\ChoriBachat::find()->andWhere(['status'=>1])->all();
$active_chori_bachat = \yii\helpers\ArrayHelper::map($chori1,'id','name');
//var_dump($active_chori_bachat);die;
$user_id = yii::$app->user->id;

$user_details = app\models\Users::findOne(['id'=>$user_id]);
$bank_name = yii\helpers\ArrayHelper::map(app\models\BankDetails::find()->where(['fk_user_id'=>$user_id])->andWhere(['fk_municipal_id'=>$user_details->fk_municipal_id])->all(),'id','name');

//var_dump($bank_name);die;
$count=00001;
?>

<div class="chori-account-details-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                     <?=
            $form->field($account_chori, 'fk_chori_bachat')->textInput(['maxlength' => true,'value'=>$chori['name']])
     ?>
                </div>
                <div class="col-md-6">
                 <?=
            $form->field($account_chori, 'bank_name')->widget(Select2::classname(), [
          'data' => $bank_name,
          'language' => 'de',
         'options'=>[
             'placeholder' =>'बैंकको नाम छानुहोस  ',
         ] ,
          'pluginOptions' => [
           'allowClear' => true
                     ],
                     ]);
     ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <?= $form->field($account_chori, 'account_no')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    
              <?= $form->field($account_chori, 'account_open_date',['inputOptions' => ['id' => 'nepali-datepicker','class'=>'form-control']]) ?>

                </div>
            </div>
        </div>
    </div>
   
    <div class="form-group">
        <?= Html::submitButton('पेश गर्नुहोस', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js = '$("#nepali-datepicker").nepaliDatePicker();$("#nepali-datepicker1").nepaliDatePicker();$("#nepali-datepicker2").nepaliDatePicker();$("#nepali-datepicker3").nepaliDatePicker();$("#nepali-datepicker4").nepaliDatePicker();$("#nepaliDate3").nepaliDatePicker();';
$this->registerJs($js, 5);