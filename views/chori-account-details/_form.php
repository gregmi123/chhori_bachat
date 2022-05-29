<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\ChoriAccountDetails */
/* @var $form yii\widgets\ActiveForm */
$chori = \app\models\ChoriBachat::find()->andWhere(['status'=>1])->all();
$active_chori_bachat = \yii\helpers\ArrayHelper::map($chori,'id','name');
//var_dump($active_chori_bachat);die;
$bank_name = yii\helpers\ArrayHelper::map(app\models\BankDetails::find()->all(),'id','name');
//var_dump($bank_name);die;
?>

<div class="chori-account-details-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                     <?=
             $form->field($model, 'fk_chori_bachat')->textInput(['maxlength' => true])
     ?>
                </div>
                <div class="col-md-6">
                 <?=
            $form->field($model, 'bank_name')->widget(Select2::classname(), [
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
                    <?= $form->field($model, 'account_no')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    
                   <?= $form->field($model, 'account_open_date',['inputOptions' => ['id' => 'nepali-datepicker','class'=>'form-control']]) ?>

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