<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ward */
/* @var $form yii\widgets\ActiveForm */
$ward=array();
for($i=1;$i<50;$i++){
    $ward[$i]=$i;
}
$message=Yii::$app->session->getFlash('message');
?>

<div class="ward-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ward_name')->dropDownList($ward,['prompt'=>'कृपया वडा छान्नुहोस्']) ?>

   

    <div class="form-group">
        <?= Html::submitButton('पेश गर्नुहोस', ['class' => 'btn btn-success']) ?>
        <?php 
        if($message){
            echo '<p style="color:red;">'.$message.'</p>';
        }
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
