<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WithdrawSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="withdraw-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fk_chori') ?>

    <?= $form->field($model, 'fk_dismiss') ?>

    <?= $form->field($model, 'amount') ?>

    <?= $form->field($model, 'fk_bank') ?>

    <?php // echo $form->field($model, 'fk_account') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'fk_user_id') ?>

    <?php // echo $form->field($model, 'fk_municipal') ?>

    <?php // echo $form->field($model, 'fk_economic_year') ?>

    <?php // echo $form->field($model, 'fk_month') ?>

    <?php // echo $form->field($model, 'fk_province') ?>

    <?php // echo $form->field($model, 'fk_district') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
