<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$year=ArrayHelper::map(\app\models\Year::find()->where(['status'=>1])->all(),'id','economic_year');
/* @var $this yii\web\View */
/* @var $model app\models\EconomicYear */
/* @var $form yii\widgets\ActiveForm */
$message=yii::$app->session->getFlash('message');
?>

<div class="economic-year-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'economic_year')->dropDownList($year,['id'=>'year','prompt'=>'छान्नुहोस्']) ?>


    <!-- <?= $form->field($model, 'status')->dropDownList(['prompts'=>'छान्नुहोस्','1'=>'Active','0'=>'Inactive']); ?> -->

    

    <div class="form-group">
        <?= Html::submitButton('पेश गर्नुहोस', ['class' => 'btn btn-success']) ?>
        <?php
        if($message) {
            echo '<p style="color:red;">' . $message . '</p>';
        }
        ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
