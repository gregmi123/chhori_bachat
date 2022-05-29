<?php

//use kartik\widgets\ActiveField;
use yii\helpers\Html;

// $this->title = 'login your password';
$message = Yii::$app->session->getFlash('message');
$form = \yii\widgets\ActiveForm::begin();
?>

<div class="col-md-12 col-sm-12">
    <!-- <h3 style=""><?= $this->title ?></h3> -->
    <!-- <hr>comment -->
    <div class="col-md-4" style="background-color: whitesmoke;margin-left: 330px;margin-top: 150px;">
        <?php
        if ($message) {
            echo '<p style="color:red;">' . $message . '</p>';
        }
        ?>
        <?= $form->field($model, 'password')->passwordInput()->Label('Enter PIN NO.') ?>
        <?= Html::submitButton('Okay', ['class' => 'btn btn-success']) ?>
    </div>

</div>
<?php
\yii\widgets\ActiveForm::end();
?>