<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
$user_id=yii::$app->user->id;
$user_details=\app\models\Users::findone(['id'=>$user_id]);
$province1=ArrayHelper::map(\app\models\Province::find()->where(['id'=>$user_details['fk_province_id']])->all(),'id','province_nepali');
$municpal_name = ArrayHelper::map(\app\models\Municipal::find()->all(),'id','name');
$province = ArrayHelper::map(\app\models\Province::find()->all(), 'id', 'province_nepali');
$district_login=\yii\helpers\Arrayhelper::map(\app\models\District::find()->where(['fk_province'=>$user_details['fk_province_id']])->all(),'id','district_nepali');
$message=yii::$app->session->getFlash('message');
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
    <div class="col-sm-4">
    <?php if($user_details['user_type']==1){ ?>
        <?= $form->field($model, 'user_type')->widget(Select2::classname(), [
                                    'data' => ['2'=>'District','3'=>'Municipal'],
                                    'language' => 'de',
                                    'options' => ['placeholder' => 'छान्नुहोस्', 'id' => 'user_type','onchange'=>'hide()'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]); ?>
        
        <?php } else if($user_details['user_type']==2){ ?>
            <?= $form->field($model, 'user_type')->widget(Select2::classname(), [
                                        'data' => ['3'=>'Municipal'],
                                        'language' => 'de',
                                        'options' => ['id' => 'user_type','onchange'=>'hide()'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]); ?>
            
            <?php } else if($user_details['user_type']==2){ ?>
            <?= $form->field($model, 'user_type')->widget(Select2::classname(), [
                                    'data' => ['1'=>'Province','2'=>'District','3'=>'Municipal'],
                                    'language' => 'de',
                                    'options' => ['placeholder' => 'छान्नुहोस्', 'id' => 'user_type','onchange'=>'hide()'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]); ?>
        <?php } else{ ?>
            <?= $form->field($model, 'user_type')->widget(Select2::classname(), [
                                    'data' => ['4'=>'Superadmin','1'=>'Province','2'=>'District','3'=>'Municipal'],
                                    'language' => 'de',
                                    'options' => ['placeholder' => 'छान्नुहोस्', 'id' => 'user_type','onchange'=>'hide()'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]); ?>
        <?php } ?>
    </div>
    <div class="col-sm-4">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
    <?= $form->field($model, 'phone')->textInput() ?>
    </div>
    </div>
    <div class="row">
    <div class="col-sm-4" id="prov">
    <?php if($user_details['user_type']==1 || $user_details['user_type']==2){ ?>
        <?= $form->field($model, 'fk_province_id')->widget(Select2::classname(), [
                                    'data' => $province1,
                                    'language' => 'de',
                                    'options' => [ 'id' => 'province'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
        
        <?php }
        else{ ?>
            <?= $form->field($model, 'fk_province_id')->widget(Select2::classname(), [
                                    'data' => $province,
                                    'language' => 'de',
                                    'options' => ['placeholder' => 'छान्नुहोस्', 'id' => 'province'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
        <?php } ?>
                </div>
                <?php if($user_details['user_type']==2){ 
                    $district_name=\yii\helpers\Arrayhelper::map(\app\models\District::find()->where(['id'=>$user_details['fk_district_id']])->all(),'id','district_nepali');    
                    ?>
                <div class="col-sm-4" id="dis">
                <?=
        $form->field($model, 'fk_district_id')->widget(Select2::classname(), [
                                    'data' => $district_name,
                                    'language' => 'en',
                                    'options' => ['id' => 'district'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        
                                        
                                    ],
                                ]);
                                ?>
                                
                                </div>
                                <div class="col-sm-4" id="mun">
    <?=
                                $form->field($model, 'fk_municipal_id')->widget(DepDrop::className(), [
                                    'type' => DepDrop::TYPE_SELECT2,
                                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                    'options' => ['id' => 'municipal'],
                                    'pluginOptions' => [
                                        'depends' => ['district'],
                                        'placeholder' => 'छान्नुहोस्',
                                        'initialize' => true,
                                        'url' => Url::to(['chori-bachat/municipal'])
                                    ]
                                ])
                                ?>
                                <?php if($message && $u_id==3){ ?>
                                <p style="color:red;"><?= $message ?></p>
                                <?php } ?>
    
    </div>
        <?php }  else{?>
            <div class="col-sm-4" id="dis" style="display: none;">
                <!-- <=
        $form->field($model, 'fk_district_id')->widget(Select2::classname(), [
                                    'data' => $district_login,
                                    'language' => 'en',
                                    'options' => ['id' => 'district'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'placeholder' => 'छान्नुहोस् ',
                                        
                                        
                                    ],
                                ]);
                                ?> -->
                                <?=
                                $form->field($model, 'fk_district_id')->widget(DepDrop::className(), [
                                    'type' => DepDrop::TYPE_SELECT2,
                                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                    'options' => ['id' => 'district'],
                                    'pluginOptions' => [
                                        'depends' => ['province'],
                                        'placeholder' => 'छान्नुहोस्',
                                        'initialize' => true,
                                        'url' => Url::to(['chori-bachat/province'])
                                    ]
                                ])
                                ?>
                                <?php if($message && $u_id==2){ ?>
                                <p style="color:red;"><?= $message ?></p>
                                <?php } ?>
                                </div>
                                <div class="col-sm-4" id="mun" style="display: none;">
    <?=
                                $form->field($model, 'fk_municipal_id')->widget(DepDrop::className(), [
                                    'type' => DepDrop::TYPE_SELECT2,
                                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                    'options' => ['id' => 'municipal'],
                                    'pluginOptions' => [
                                        'depends' => ['district'],
                                        'placeholder' => 'छान्नुहोस्',
                                        'initialize' => true,
                                        'url' => Url::to(['chori-bachat/municipal'])
                                    ]
                                ])
                                ?>
                                <?php if($message && $u_id==3){ ?>
                                <p style="color:red;"><?= $message ?></p>
                                <?php } ?>
    
    </div>
        <?php } ?>
    </div>
    <div class="row">
    <div class="col-sm-4">
    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
    <?= $form->field($model, 'pin')->TextInput(['maxlength' => true]) ?>
    </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('पेश गर्नुहोस', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    window.onload=function(){
        user_type=document.getElementById('user_type').value;
        province_user=document.getElementById('prov');
        district_user=document.getElementById('dis');
        municipal_user=document.getElementById('mun');
       if(user_type==1){
        $(province_user).show();
        $(district_user).hide();
        $(municipal_user).hide();
       }
       else if(user_type==2){
        $(province_user).show();
        $(district_user).show();
        $(municipal_user).hide();
       }
       else if(user_type==3){
        $(province_user).show();
        $(district_user).show();
        $(municipal_user).show();
       }  
       else{
        $(province_user).hide();
        $(district_user).hide();
        $(municipal_user).hide();
       }
    }
    function hide(){
        user_type=document.getElementById('user_type').value;
        province_user=document.getElementById('prov');
        district_user=document.getElementById('dis');
        municipal_user=document.getElementById('mun');
       if(user_type==1){
        $(province_user).show();
        $(district_user).hide();
        $(municipal_user).hide();
       }
       else if(user_type==2){
        $(province_user).show();
        $(district_user).show();
        $(municipal_user).hide();
       }
       else if(user_type==3){
        $(province_user).show();
        $(district_user).show();
        $(municipal_user).show();
       }  
       else{
        $(province_user).hide();
        $(district_user).hide();
        $(municipal_user).hide();
       }
    }
</script>