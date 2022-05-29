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
$municipal_update=\yii\helpers\Arrayhelper::map(\app\models\Municipals::find()->where(['id'=>$user_details['fk_municipal_id']])->all(),'id','municipal_nepali');
$district_login=\yii\helpers\Arrayhelper::map(\app\models\District::find()->where(['id'=>$user_details['fk_district_id']])->all(),'id','district_nepali');

$this->registerJs($this->render('verification.js'),5);
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form1', 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
    <div class="col-sm-4">

    <?php if($user_details['user_type']==1){ ?>
            <?= $form->field($model, 'user_type')->widget(Select2::classname(), [
                                    'data' => ['1'=>'Province'],
                                    'language' => 'de',
                                    'options' => ['id' => 'user_type','onchange'=>'hide()'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'initialize'=>true
                                    ],
                                ]); ?>
    <?php } else if($user_details['user_type']==2){ ?>
        <?= $form->field($model, 'user_type')->widget(Select2::classname(), [
                                    'data' => ['2'=>'District'],
                                    'language' => 'de',
                                    'options' => ['id' => 'user_type','onchange'=>'hide()'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'initialize'=>true
                                    ],
                                ]); ?>
    <?php } else if($user_details['user_type']==3){ ?>
        <?= $form->field($model, 'user_type')->widget(Select2::classname(), [
                                    'data' => ['3'=>'Municipal'],
                                    'language' => 'de',
                                    'options' => ['id' => 'user_type','onchange'=>'hide()'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'initialize'=>true
                                    ],
                                ]); ?>
    <?php } else{ ?>
        <?= $form->field($model, 'user_type')->widget(Select2::classname(), [
                                    'data' => ['4'=>'Superadmin'],
                                    'language' => 'de',
                                    'options' => ['id' => 'user_type','onchange'=>'hide()'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'initialize'=>true
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
    
    <?php if($user_details['user_type']==1){ ?>
        <div class="row">
    <div class="col-sm-4" id="prov">
        <?= $form->field($model, 'fk_province_id')->widget(Select2::classname(), [
                                    'data' => $province1,
                                    'language' => 'de',
                                    'options' => [ 'id' => 'province'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'initialize'=>true
                                    ],
                                ]);
                                ?>
                </div>
                <div class="col-sm-4">
    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    </div>
</div>
    <div class="row">
    <div class="col-sm-4">
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'pin')->TextInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
    <div class="col-sm-4" style="margin-top:1.7em;">
            <?= Html::Button('पेश गर्नुहोस', ['class' => 'btn btn-success',
            'id'=>'print-div3',
            'data-toggle'=>'modal',
            'data-target'=>'#exampleModal3',
                            ]); ?>
        </div>
    </div>


        <?php } else if($user_details['user_type']==2){ ?>
            <div class="row">
            <div class="col-sm-4" id="prov">
        <?= $form->field($model, 'fk_province_id')->widget(Select2::classname(), [
                                    'data' => $province1,
                                    'language' => 'de',
                                    'options' => [ 'id' => 'province'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'initialize'=>true
                                    ],
                                ]);
                                ?>
                </div>

            <div class="col-sm-4" id="dis">
            <?=
        $form->field($model, 'fk_district_id')->widget(Select2::classname(), [
                                    'data' => $district_login,
                                    'language' => 'en',
                                    'options' => ['id' => 'district'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'placeholder' => 'छान्नुहोस् ',
                                        'initialize'=>true
                                        
                                        
                                    ],
                                ]);
                                ?>
                                </div>
                                <div class="col-sm-4">
    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>
    </div>
                            </div>
<div class="row">
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
    <div class="row">
        <div class="col-sm-4" style="margin-top:1.7em;">
            <?= Html::Button('पेश गर्नुहोस', ['class' => 'btn btn-success',
            'id'=>'print-div3',
            'data-toggle'=>'modal',
            'data-target'=>'#exampleModal3',
                            ]); ?>
        </div>
    </div>
    <?php } else if($user_details['user_type']==3){ ?>
        <div class="row">
        <div class="col-sm-4" id="prov">
        <?= $form->field($model, 'fk_province_id')->widget(Select2::classname(), [
                                    'data' => $province1,
                                    'language' => 'de',
                                    'options' => [ 'id' => 'province'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'initialize'=>true
                                    ],
                                ]);
                                ?>
                </div>

            <div class="col-sm-4" id="dis">
            <?=
        $form->field($model, 'fk_district_id')->widget(Select2::classname(), [
                                    'data' => $district_login,
                                    'language' => 'en',
                                    'options' => ['id' => 'district'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'initialize'=>true
                                        
                                        
                                    ],
                                ]);
                                ?>
                                </div>
        <div class="col-sm-4" id="mun">
                <?= $form->field($model, 'fk_municipal_id')->widget(Select2::classname(), [
                                    'data' => $municipal_update,
                                    'language' => 'en',
                                    'options' => ['id' => 'municipal'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'initialize'=>true
                                        
                                        
                                    ],
                                ]);
                                ?>
    
    </div>
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
    </div>
    <div class="row">
    <!-- <div class="col-sm-4">
        <= $form->field($model, 'pin')->TextInput(['maxlength' => true]) ?>
        </div> -->
        <div class="col-sm-4" style="margin-top:1.7em;">
            <?= Html::Button('पेश गर्नुहोस', ['class' => 'btn btn-success',
            'id'=>'print-div3',
            'data-toggle'=>'modal',
            'data-target'=>'#exampleModal3',
                            ]); ?>
        </div>
    </div>
     <?php } else{?>
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
    </div>
    <div class="row">
    <!-- <div class="col-sm-4">
        <= $form->field($model, 'pin')->TextInput(['maxlength' => true]) ?>
        </div> -->
        <div class="col-sm-4" style="margin-top:1.7em;">
            <?= Html::Button('पेश गर्नुहोस', ['class' => 'btn btn-success',
            'id'=>'print-div3',
            'data-toggle'=>'modal',
            'data-target'=>'#exampleModal3',
     ]); ?>
        </div>
    </div>
    <?php } ?>
    <?php ActiveForm::end(); ?>

</div>
<script>
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
<script>
    function initial(){ 
        // console.log('sss');
        var form = document.getElementById("dynamic-form1");
        form.submit();
        
    }
</script>
<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Please Enter PIN Code</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <input type="hidden" value="<?= $user_details['pin']?>" id="municipal_id1">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">PIN Code:</label>
            <input type="password" class="form-control" value="" placeholder="Enter PIN Code" id="typed_pin1">
          </div>
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <= Html::SubmitButton('Confirm',['class'=>'btn btn-primary','name'=>'confirm1','id'=>'btn_submit']); ?> -->
        <button type="button" class="btn btn-primary" name="confirm1" id="btn_submit1">Confirm</button>
      </div>
    </div>
  </div>
</div>