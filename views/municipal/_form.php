<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\select2\Select2;
$province = ArrayHelper::map(\app\models\Province::find()->all(), 'id', 'province_nepali');
/* @var $this yii\web\View */
/* @var $model app\models\Municipal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="municipal-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                  <?= $form->field($model, 'logo')->fileInput() ?>   
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                     <?=
           $form->field($model, 'fk_province')->widget(Select2::classname(), [
                                    'data' => $province,
                                    'language' => 'de',
                                    'options' => ['placeholder' => 'Select a province ...', 'id' => 'province'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>

                </div>
                <div class="col-md-4">
                    
                      <?=
                                $form->field($model, 'fk_district')->widget(DepDrop::className(), [
                                    'type' => DepDrop::TYPE_SELECT2,
                                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                    'options' => ['id' => 'district'],
                                    'pluginOptions' => [
                                        'depends' => ['province'],
                                        'placeholder' => 'छान्नुहोस्',
                                        'initialize'=>true,
                                        'url' => Url::to(['chori-bachat/province'])
                                    ]
                                ])
                                ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4">
                <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                <?= $form->field($model, 'head_officer')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                <?= $form->field($model, 'municipal_code')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('पेश गर्नुहोस', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
