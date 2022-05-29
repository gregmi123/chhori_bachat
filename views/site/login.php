<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login" >
    
    <?php
    $form = ActiveForm::begin([
                'id' => 'login-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-1 control-label'],
                ],
    ]);
    ?>

    <div class="container">

        <div class="header">
            <img src="images/enblem.png ">
            <h2 style="color: white;font-weight:bold;">LOG IN</h2>

        </div>
        <div class="main">
            <form>
                <span>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true,'style'=>'width:70%;height:30px;border:none;']) ?>
                </span>
                <br>
                <span>
                    <i class="glyphicon glyphicon-apple"></i>
                    <?= $form->field($model, 'password')->passwordInput(['style'=>'width:70%;height:30px;border:none;']) ?>

                </span>
                <span>
                    <?=
                    $form->field($model, 'rememberMe')->checkbox([
                        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        'style'=>'font-size:13px;margin-left:-200px;',
                    ])
                    ?>
                </span><!-- comment -->
                <br>
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-11">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-lg', 'name' => 'login-button','style'=>'width:80px;height:30px;border-radius:10px;margin-top:-30px;']) ?>
                    </div>
                </div>

            </form>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>