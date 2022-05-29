<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ChoriBachatSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chori-bachat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fk_user_id') ?>

    <?= $form->field($model, 'image') ?>

    <?= $form->field($model, 'camera_image') ?>

    <?= $form->field($model, 'thumb_left') ?>

    <?php // echo $form->field($model, 'thumb_right') ?>

    <?php // echo $form->field($model, 'guardian_image') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'dob') ?>

    <?php // echo $form->field($model, 'birth_certificate_no') ?>

    <?php // echo $form->field($model, 'birth_certificate_date') ?>

    <?php // echo $form->field($model, 'father_name') ?>

    <?php // echo $form->field($model, 'father_citizenship_no') ?>

    <?php // echo $form->field($model, 'mother_name') ?>

    <?php // echo $form->field($model, 'mother_citizenship_no') ?>

    <?php // echo $form->field($model, 'take_care_person') ?>

    <?php // echo $form->field($model, 'take_care_citizenship_no') ?>

    <?php // echo $form->field($model, 'fk_per_province') ?>

    <?php // echo $form->field($model, 'fk_per_district') ?>

    <?php // echo $form->field($model, 'fk_per_municipal') ?>

    <?php // echo $form->field($model, 'fk_ward') ?>

    <?php // echo $form->field($model, 'tole_name') ?>

    <?php // echo $form->field($model, 'chori_birth_certificate_doc') ?>

    <?php // echo $form->field($model, 'parents_citizenship_doc') ?>

    <?php // echo $form->field($model, 'sastha_certificate') ?>

    <?php // echo $form->field($model, 'hospital_certificate') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
