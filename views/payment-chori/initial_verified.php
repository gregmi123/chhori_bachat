<?php

//use kartik\widgets\ActiveField;
use yii\helpers\Html;

$this->title = 'Enter PIN NO.';
$this->params['breadcrumbs'][]=['label'=>'भुक्तानी'];
$message = Yii::$app->session->getFlash('message');
$form = \yii\widgets\ActiveForm::begin();
?>

<div class="col-md-12 col-sm-12">
    <h3 style=""><?= $this->title ?></h3>
    <hr><!-- comment -->
    <div class="col-md-4" style="background-color: whitesmoke;margin-left: 330px;margin-top: 60px;">
        <?php
        if ($message) {
            echo '<p style="color:red;">' . $message . '</p>';
        }
        ?>
        <?= $form->field($model, 'pin')->TextInput() ?>
        <?= Html::submitButton('Okay',['payment-chori/create','class' => 'btn btn-success']) ?>
    </div>

</div>
<?php
\yii\widgets\ActiveForm::end();
?>