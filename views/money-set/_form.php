<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MoneySet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="money-set-form">

    <?php $form = ActiveForm::begin(); ?>
    <br>
    <div class="col-md-12">
        <div class="col-md-4">
          <?= $form->field($model, 'initial_payment')->textInput() ?>  
        </div>
        <div class="col-md-4">
           <?= $form->field($model, 'previous_payment')->textInput() ?>  
        </div>
        <div class="col-md-4">
           <?= $form->field($model, 'status')->hiddenInput(['maxlength'=>true,'value'=>'1'])->label(false) ?> 
        </div>
    
    <div class="col-md-12">
  
        <?= Html::submitButton('पेश गर्नुहोस', ['class' => 'btn btn-success']) ?>
  
    </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
