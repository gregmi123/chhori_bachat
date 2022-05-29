<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CheckPayment */
/* @var $form yii\widgets\ActiveForm */
$economicYear= \yii\helpers\ArrayHelper::map(app\models\EconomicYear::find()->where(['status'=>1])->all(),'id','economic_year');
//var_dump($economicYear);die;
$month = \yii\helpers\ArrayHelper::map(\app\models\Month::find()->all(),'id','month_name');
$verified_chori= \yii\helpers\ArrayHelper::map(\app\models\ChoriBachat::find()->where(['status'=>2])->all(),'id','name');
//var_dump($verified_chori);die;
?>

<div class="check-payment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fk_economic_year')->dropDownList($economicYear); ?>
    <?= $form->field($model, 'fk_month')->checkboxList($month) ?>

    <?= $form->field($model, 'fk_chori_bachat')->checkboxList($verified_chori) ?>

    

   

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
