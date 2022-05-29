<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\select2\Select2;
//use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\ChoriBachat */
/* @var $form yii\widgets\ActiveForm */
$user_id = yii::$app->user->id;
$user_details = app\models\Users::findOne(['id' => $user_id]);
$province = ArrayHelper::map(\app\models\Province::find()->where(['id'=>$user_details['fk_province_id']])->all(), 'id', 'province_nepali');
$ward = ArrayHelper::map(\app\models\Ward::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->all(), 'id', 'ward_name');
$district=ArrayHelper::map(\app\models\District::find()->where(['id'=>$user_details['fk_district_id']])->all(), 'id', 'district_nepali');
$municipal=ArrayHelper::map(\app\models\Municipals::find()->where(['id'=>$user_details['fk_municipal_id']])->all(), 'id', 'municipal_nepali');
$caste=ArrayHelper::map(\app\models\Caste::find()->all(), 'id', 'name');
$apanga=ArrayHelper::map(\app\models\Apangata::find()->all(), 'id', 'name');
$sankrakchak=['1'=>'बुवा','2'=>'आमा','3'=>'अन्य'];

$message1=Yii::$app->session->getFlash('message');
?>

<div class="chori-bachat-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <table class="table table-bordered">

        <tr>
            <th style="background-color: #DDEAFF;">
                <?= $this->title ?>
            </th>
        </tr>
        <tr>
            <td>
                <div class="col-md-12">
                    <div class="row">
                        <h4><b>#फोटो</b></h4>
                        <div class="col-md-12">
                            <!-- <div class="col-md-4">
                                <= $form->field($model, 'update_file')->fileInput() ?>

                            </div> -->
                            <!-- <div class="col-md-4">
                                 $form->field($model, 'camera_image')->textInput(['maxlength' => true]) ?>
                            </div> -->
                            <!-- <div class="col-md-4">
                                <= $form->field($model, 'update_parent_file')->fileInput() ?>
                            </div> -->
                            <div class="row">
                        <div class="col-md-12"  id="photo-fileg">
                            <div class="col-md-6">
                                <?php if($model->guardian_image){ 
                                echo Html::img($model->guardian_image,['width'=>'100','height'=>'100','id'=>'guardian']);    
                                ?>
                                <!-- comment -->
                                <?php } else{ ?>
                                    <img id="guardian" src="#" >
                                <?php } ?>
                                <?= $form->field($model, 'update_parent_file')->fileInput(['maxlength' => true, 'onchange' => 'guardianURL(this);', 'id' => 'guardiang']) ?>
                            </div>
                            <div class="col-md-3" style="margin-top: 0px;margin-left: 15px;">
                                <a href="#" onclick="showCameraG()" class="btn btn-warning" style="margin-left: -270px;margin-top:40px;">क्यामेरा</a>
                            </div>
                        </div>

                        <div class="col-md-12" style="display: none;" id="camera-showg">
                            <div class="col-md-6">
                                <video id="videog" height="" width="300"></video><br>
                                <a href="#result" id="captureg" class="btn btn-primary" >take a photo</a>
                                <a href="#" onclick="displayPhotoG()" class="btn btn-warning">कम्प्युटरबाट</a>
                                <canvas id="canvasg" width="400" height="300" style="display:none;"></canvas> 
                            </div>

                            <div class="col-md-6">
                                <?= $form->field($model, 'photo_from_camera_guardian')->hiddenInput(['maxlength' => true, 'id' => 'photo-from-camerag'])->label(false) ?>
                                <canvas id="canvas1g" width="400" height="300" style="display:none;"></canvas> 
                                <img src = "" id = "photog",alt="photo of you">
                            </div>
                        </div>
                    </div>
                        </div>
                        <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12"  id="photo-file">
                            <div class="col-md-6">
                            <?php if($model->image){ 
                                echo Html::img($model->image,['width'=>'100','height'=>'100','id'=>'foto']);    
                                ?>
                                <!-- comment -->
                                <?php } else{ ?>
                                    <img id="foto" src="#" >
                                <?php } ?>
                                <?= $form->field($model, 'update_file')->fileInput(['maxlength' => true, 'onchange' => 'readURL(this);', 'id' => 'computer-photo']) ?>
                            </div>
                            <div class="col-md-3" style="margin-top: 0px;margin-left: 15px;">
                                <a href="#" onclick="showCamera()" class="btn btn-warning" style="margin-left: -270px;margin-top:40px;">क्यामेरा</a>
                            </div>
                        </div>

                        <div class="col-md-12" style="display: none;" id="camera-show">
                            <div class="col-md-6">
                                <video id="video" height="" width="300"></video><br>
                                <a href="#result" id="capture" class="btn btn-primary" >take a photo</a>
                                <a href="#" onclick="displayPhoto()" class="btn btn-warning">कम्प्युटरबाट</a>
                                <canvas id="canvas" width="400" height="300" style="display:none;"></canvas> 
                            </div>

                            <div class="col-md-6">
                                <?= $form->field($model, 'photo_from_camera')->hiddenInput(['maxlength' => true, 'id' => 'photo-from-camera'])->label(false) ?>
                                <canvas id="canvas1" width="400" height="300" style="display:none;"></canvas> 
                                <img src = "" id = "photo",alt="photo of you">
                            </div>
                        </div>
                    </div>
                </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="col-md-12">
                    <div class="row">
                        <h4><b>#औठा छाप</b></h4>
                        <div class="col-md-12">
                            <div id="finger-print">
                                <div class="col-md-6">
                                    <a id="btnInfo" value="Get Info" class="btn btn-primary btn-100" onclick="return Capture()" >बाँया</a>
                                    <img id="imgFinger" width="100px" height="100px" alt="Finger Image" />
                                    <?= $form->field($model, 'thumbLeft')->hiddenInput(['maxlength' => true, 'id' => 'finger-info'])->label(false) ?>

                                    <?= $form->field($model, 'iso_template')->hiddenInput(['maxlength' => true, 'id' => 'iso-template'])->label(false) ?>
                                    <?= $form->field($model, 'ansi_template')->hiddenInput(['maxlength' => true, 'id' => 'ansi-template'])->label(false) ?>
                                </div>
                                <div class="col-md-6">
                                    <a id="btnInfo" value="Get Info" class="btn btn-primary btn-100" onclick="return CaptureLeft()" >दायाँ</a>
                                    <img id="leftFinger" width="100px" height="100px" alt="Finger Image" />
                                    <?= $form->field($model, 'thumbRight')->hiddenInput(['maxlength' => true, 'id' => 'left-finger-info'])->label(false) ?>
                                    <?= $form->field($model, 'left_iso_template')->hiddenInput(['maxlength' => true, 'id' => 'left-iso-template'])->label(false) ?>
                                    <?= $form->field($model, 'left_ansi_template')->hiddenInput(['maxlength' => true, 'id' => 'left-ansi-template'])->label(false) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="col-md-12">
                    <div class="row">
                        <h4><b>#छोरी को विवरण</b></h4>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'dob',['inputOptions' => ['id' => 'nepali-datepicker','class'=>'form-control']])->widget(MaskedInput::class,[
                                    'mask' => '9999-99-99',
                                ]) ?>
                                <?php if($message1 && $mes==1){ 
                                    echo '<p style="color:red;">'.$message1.'</p>';
                                 } ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <?= $form->field($model, 'birth_certificate_no')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'birth_certificate_date', ['inputOptions' => ['id' => 'nepali-datepicker1', 'class' => 'form-control']])->widget(MaskedInput::class,[
                                    'mask' => '9999-99-99',
                                ]) ?>
                                <?php if($message1 && $mes==2){ 
                                    echo '<p style="color:red;">'.$message1.'</p>';
                                 } ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                        <div class="col-md-6">
                                <?=
                                $form->field($model, 'fk_caste')->widget(Select2::classname(), [
                                    'data' => $caste,
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'छान्नुहोस्...'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        
                                    ],
                                ]);
                                ?>
                        </div>
                        <div class="col-md-6">
                                <?=
                                $form->field($model, 'fk_apangata')->widget(Select2::classname(), [
                                    'data' => $apanga,
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'छान्नुहोस् ...'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        
                                    ],
                                ]);
                                ?>
                                </div>
                        </div>
                        <?= $form->field($model, 'unique_id')->hiddenInput(['maxlength' => true])->label(false) ?>
                        <?= $form->field($model, 'fk_economic_year')->hiddenInput(['maxlength' => true])->label(false) ?>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="col-md-12">
                    <div class="row">
                        <h4><b>#अभिभावक विवरण </b></h4>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <?= $form->field($model, 'father_name')->textInput(['maxlength' => true,'id'=>'father_name']) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'father_citizenship_no')->textInput(['maxlength' => true,'id'=>'father_citizenship_no']) ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <?= $form->field($model, 'mother_name')->textInput(['maxlength' => true,'id'=>'mother_name']) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'mother_citizenship_no')->textInput(['maxlength' => true,'id'=>'mother_citizenship_no']) ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                                <?= $form->field($model, 'check_guardian')->radioList($sankrakchak ,['itemOptions' => ['id'=>'guardian','onClick'=>"care(this.value)"]]) ?>
                            </div>
                        <div class="col-md-12"  id="take_care_detail">
                            <div class="col-md-6">
                                <?= $form->field($model, 'take_care_person')->textInput(['maxlength' => true,'id'=>'take_care_person']) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'take_care_citizenship_no')->textInput(['maxlength' => true,'id'=>'take_care_citizenship_no']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="col-md-12">
                    <div class="row">
                        <h4><b>#ठेगाना</b></h4>
                        <?php if($user_details['user_type']==1){ ?>
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <?=
                                $form->field($model, 'fk_per_province')->widget(Select2::classname(), [
                                    'data' => $province,
                                    'language' => 'en',
                                    'options' => ['id' => 'province'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                            </div>
                            <div class="col-md-4">
                                <?=
                                $form->field($model, 'fk_per_district')->widget(DepDrop::className(), [
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
                            </div>
                            <div class="col-md-4">
                                <?=
                                $form->field($model, 'fk_per_municipal')->widget(DepDrop::className(), [
                                    'type' => DepDrop::TYPE_SELECT2,
                                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                    'options' => ['id' => 'municipal'],
                                    'pluginOptions' => [
                                        'depends' => ['district'],
                                        'placeholder' => 'छान्नुहोस्',
                                        'url' => Url::to(['chori-bachat/municipal'])
                                    ]
                                ])
                                ?>
                            </div>
                        </div>
                        <?php } else if($user_details['user_type']==2){?>
                            <div class="col-md-12">
                            <div class="col-md-4">
                                <?=
                                $form->field($model, 'fk_per_province')->widget(Select2::classname(), [
                                    'data' => $province,
                                    'language' => 'de',
                                    'options' => ['id' => 'province'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                            </div>
                            <div class="col-md-4">
                                <?=
                                $form->field($model, 'fk_per_district')->widget(Select2::classname(), [
                                    'data' => $district,
                                    'language' => 'de',
                                    'options' => ['id' => 'district'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ]
                                ])
                                ?>
                            </div>
                            <div class="col-md-4">
                                <?=
                                $form->field($model, 'fk_per_municipal')->widget(DepDrop::className(), [
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
                            </div>
                        </div>   
                        <?php } else{?>
                            <div class="col-md-12">
                            <div class="col-md-4">
                                <?=
                                $form->field($model, 'fk_per_province')->widget(Select2::classname(), [
                                    'data' => $province,
                                    'language' => 'de',
                                    'options' => ['id' => 'province'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                            </div>
                            <div class="col-md-4">
                                <?=
                                $form->field($model, 'fk_per_district')->widget(Select2::classname(), [
                                    'data' => $district,
                                    'language' => 'de',
                                    'options' => ['id' => 'district'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ]
                                ])
                                ?>
                            </div>
                            <div class="col-md-4">
                                <?=
                                $form->field($model, 'fk_per_municipal')->widget(Select2::classname(), [
                                    'data' => $municipal,
                                    'language' => 'de',
                                    'options' => ['id' => 'municipal'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ]
                                ])
                                ?>
                            </div>
                        </div>  
                        <?php } ?>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <?=
                                $form->field($model, 'fk_ward')->widget(Select2::classname(), [
                                    'data' => $ward,
                                    'language' => 'de',
                                    'options' => ['placeholder' => 'छान्नुहोस् ...'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        
                                    ],
                                ]);
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'tole_name')->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="col-md-12">
                    <h4><b>#सम्पर्क ठेगाना </b></h4>
                    <div class="col-md-4">
                        <?= $form->field($model,'mobile_no')->textInput(); ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model,'phone_no')->textInput(); ?>
                    </div>
                    <div class="col-md-4">
                      <?= $form->field($model,'email')->textInput(); ?>  
                    </div>
                </div>   
            </td> 
           
        </tr>
        <tr>
            <td>
                <div class="col-md-12">
                    <div class="row">
                        <h4><b>#आवश्यक कागजातहरु</b></h4>
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <?= $form->field($model, 'chori_birth_certificate_doc')->fileInput() ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'parents_citizenship_doc')->fileInput() ?>             
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'mother_citizenship_doc')->fileInput() ?>             
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <?= $form->field($model, 'hospital_certificate')->fileInput() ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'woda_sifarish_doc')->fileInput() ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'sastha_certificate')->fileInput() ?>               
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="col-md-12">
                    <div class="form-group">
                        <?= Html::submitButton('पेश गर्नुहोस', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </td>
        </tr>
        <?php ActiveForm::end(); ?>     
    </table>


</div>
<script>
    function care(check_value){
        if(check_value==1){
            father=document.getElementById('father_name').value;
            father_citizenship=document.getElementById('father_citizenship_no').value;
            document.getElementById('take_care_person').value=father;
            document.getElementById('take_care_citizenship_no').value=father_citizenship;
        }
        else if(check_value==2){
            mother=document.getElementById('mother_name').value;
            mother_citizenship=document.getElementById('mother_citizenship_no').value;
            document.getElementById('take_care_person').value=mother;
            document.getElementById('take_care_citizenship_no').value=mother_citizenship;
        }else{
            document.getElementById('take_care_person').value="";
            document.getElementById('take_care_citizenship_no').value="";
        }
    }
</script>
<script language="javascript" type="text/javascript">
function showCamera() {
    var video = document.getElementById('video'),
        canvas = document.getElementById('canvas'),
        photo = document.getElementById('photo'),
        result = document.getElementById('photo-from-camera'),
        image_preview = document.getElementById('foto'),
        computer_photo = document.getElementById('computer-photo');
        context = canvas.getContext('2d');
        navigator.getMedia = navigator.getUserMedia ||
                navigator.webkitGetUserMedia ||
                navigator.mozGetUserMedia ||
                navigator.msGetUserMedia;
        navigator.getMedia({
            video: true,
            audio: false
        }, function (stream) {
            video.srcObject = stream;
            video.play();
        }, function (error) {
            //error occcured
        });
        document.getElementById('capture').addEventListener('click', function () {
            computer_photo.value = null;
            image_preview.src = '#';
            context.drawImage(video, 0, 0, 400, 300);
            photo.setAttribute('src', canvas.toDataURL('image/png'));
            result.setAttribute('value', canvas.toDataURL('image/png'));
        });
        document.getElementById('camera-show').style.display = 'block';
        document.getElementById('photo-file').style.display = 'none';
    }
    function showCameraG() {
        var video = document.getElementById('videog'),
        canvas = document.getElementById('canvasg'),
        photo = document.getElementById('photog'),
        result = document.getElementById('photo-from-camerag'),
        image_preview = document.getElementById('guardian'),
        computer_photo = document.getElementById('guardiang');
context = canvas.getContext('2d');
navigator.getMedia = navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia;
navigator.getMedia({
    video: true,
    audio: false
}, function (stream) {
    video.srcObject = stream;
    video.play();
}, function (error) {
    //error occcured
});
document.getElementById('captureg').addEventListener('click', function () {
    computer_photo.value = null;
    image_preview.src = '#';
    context.drawImage(video, 0, 0, 400, 300);
    photo.setAttribute('src', canvas.toDataURL('image/png'));
    result.setAttribute('value', canvas.toDataURL('image/png'));
});
        document.getElementById('camera-showg').style.display = 'block';
        document.getElementById('photo-fileg').style.display = 'none';
    }
    function displayPhoto() {
        document.getElementById('photo').src = '#';
        document.getElementById('photo-from-camera').value = null;
        document.getElementById('camera-show').style.display = 'none';
        document.getElementById('photo-file').style.display = 'block';
    }
    function displayPhotoG() {
        document.getElementById('photog').src = '#';
        document.getElementById('photo-from-camerag').value = null;
        document.getElementById('camera-showg').style.display = 'none';
        document.getElementById('photo-fileg').style.display = 'block';
    }
function readURL(input) {
if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
        $('#foto')
                .attr('src', e.target.result)
                .width(100)
                .height(100);
    };
    reader.readAsDataURL(input.files[0]);
}
}
function guardianURL(input) {
    console.log(input);
if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
        $('#guardian')
                .attr('src', e.target.result)
                .width(100)
                .height(100);
    };
    reader.readAsDataURL(input.files[0]);
}
}

    var quality = 60; //(1 to 100) (recommanded minimum 55)
    var timeout = 10; // seconds (minimum=10(recommanded), maximum=60, unlimited=0 )

    function GetInfo() {
        document.getElementById('tdSerial').innerHTML = "";
        document.getElementById('tdCertification').innerHTML = "";
        document.getElementById('tdMake').innerHTML = "";
        document.getElementById('tdModel').innerHTML = "";
        document.getElementById('tdWidth').innerHTML = "";
        document.getElementById('tdHeight').innerHTML = "";
        document.getElementById('tdLocalMac').innerHTML = "";
        document.getElementById('tdLocalIP').innerHTML = "";
        document.getElementById('tdSystemID').innerHTML = "";
        document.getElementById('tdPublicIP').innerHTML = "";


        var key = document.getElementById('txtKey').value;

        var res;
        if (key.length == 0) {
            res = GetMFS100Info();
        } else {
            res = GetMFS100KeyInfo(key);
        }

        if (res.httpStaus) {

            document.getElementById('txtStatus').value = "ErrorCode: " + res.data.ErrorCode + " ErrorDescription: " + res.data.ErrorDescription;

            if (res.data.ErrorCode == "0") {
                document.getElementById('tdSerial').innerHTML = res.data.DeviceInfo.SerialNo;
                document.getElementById('tdCertification').innerHTML = res.data.DeviceInfo.Certificate;
                document.getElementById('tdMake').innerHTML = res.data.DeviceInfo.Make;
                document.getElementById('tdModel').innerHTML = res.data.DeviceInfo.Model;
                document.getElementById('tdWidth').innerHTML = res.data.DeviceInfo.Width;
                document.getElementById('tdHeight').innerHTML = res.data.DeviceInfo.Height;
                document.getElementById('tdLocalMac').innerHTML = res.data.DeviceInfo.LocalMac;
                document.getElementById('tdLocalIP').innerHTML = res.data.DeviceInfo.LocalIP;
                document.getElementById('tdSystemID').innerHTML = res.data.DeviceInfo.SystemID;
                document.getElementById('tdPublicIP').innerHTML = res.data.DeviceInfo.PublicIP;
            }
        } else {
            alert(res.err);
        }
        return false;
    }

    function Capture() {
        try {
            //   document.getElementById('txtStatus').value = "";
            document.getElementById('imgFinger').src = "data:image/bmp;base64,";
            document.getElementById('finger-info').value = "";
            document.getElementById('iso-template').value = "";
            document.getElementById('ansi-template').value = "";
//                document.getElementById('txtIsoImage').value = "";
//                document.getElementById('txtRawData').value = "";
//                document.getElementById('txtWsqData').value = "";

            var res = CaptureFinger(quality, timeout);
            if (res.httpStaus) {

                //document.getElementById('txtStatus').value = "ErrorCode: " + res.data.ErrorCode + " ErrorDescription: " + res.data.ErrorDescription;

                if (res.data.ErrorCode == "0") {
                    document.getElementById('imgFinger').src = "data:image/bmp;base64," + res.data.BitmapData;
                    // var imageinfo = "Quality: " + res.data.Quality + " Nfiq: " + res.data.Nfiq + " W(in): " + res.data.InWidth + " H(in): " + res.data.InHeight + " area(in): " + res.data.InArea + " Resolution: " + res.data.Resolution + " GrayScale: " + res.data.GrayScale + " Bpp: " + res.data.Bpp + " WSQCompressRatio: " + res.data.WSQCompressRatio + " WSQInfo: " + res.data.WSQInfo;
                    document.getElementById('finger-info').value = "data:image/bmp;base64," + res.data.BitmapData;
                    document.getElementById('iso-template').value = res.data.IsoTemplate;
                    document.getElementById('ansi-template').value = res.data.AnsiTemplate;
//                        document.getElementById('txtIsoImage').value = res.data.IsoImage;
//                        document.getElementById('txtRawData').value = res.data.RawData;
//                        document.getElementById('txtWsqData').value = res.data.WsqImage;
                }
            } else {
                alert(res.err);
            }
        } catch (e) {
            alert(e);
        }
        return false;
    }
    function CaptureLeft() {
        try {
            //   document.getElementById('txtStatus').value = "";
            document.getElementById('leftFinger').src = "data:image/bmp;base64,";
            document.getElementById('left-finger-info').value = "";
            document.getElementById('left-iso-template').value = "";
            document.getElementById('left-ansi-template').value = "";
//                document.getElementById('txtIsoImage').value = "";
//                document.getElementById('txtRawData').value = "";
//                document.getElementById('txtWsqData').value = "";

            var res = CaptureFinger(quality, timeout);
            if (res.httpStaus) {

                //document.getElementById('txtStatus').value = "ErrorCode: " + res.data.ErrorCode + " ErrorDescription: " + res.data.ErrorDescription;

                if (res.data.ErrorCode == "0") {
                    document.getElementById('leftFinger').src = "data:image/bmp;base64," + res.data.BitmapData;
                    // var imageinfo = "Quality: " + res.data.Quality + " Nfiq: " + res.data.Nfiq + " W(in): " + res.data.InWidth + " H(in): " + res.data.InHeight + " area(in): " + res.data.InArea + " Resolution: " + res.data.Resolution + " GrayScale: " + res.data.GrayScale + " Bpp: " + res.data.Bpp + " WSQCompressRatio: " + res.data.WSQCompressRatio + " WSQInfo: " + res.data.WSQInfo;
                    document.getElementById('left-finger-info').value = "data:image/bmp;base64," + res.data.BitmapData;
                    document.getElementById('left-iso-template').value = res.data.IsoTemplate;
                    document.getElementById('left-ansi-template').value = res.data.AnsiTemplate;
//                        document.getElementById('txtIsoImage').value = res.data.IsoImage;
//                        document.getElementById('txtRawData').value = res.data.RawData;
//                        document.getElementById('txtWsqData').value = res.data.WsqImage;
                }
            } else {
                alert(res.err);
            }
        } catch (e) {
            alert(e);
        }
        return false;
    }

    function Verify() {
        try {
            var isotemplate = document.getElementById('txtIsoTemplate').value;
            var res = VerifyFinger(isotemplate, isotemplate);

            if (res.httpStaus) {
                if (res.data.Status) {
                    alert("Finger matched");
                } else {
                    if (res.data.ErrorCode != "0") {
                        alert(res.data.ErrorDescription);
                    } else {
                        alert("Finger not matched");
                    }
                }
            } else {
                alert(res.err);
            }
        } catch (e) {
            alert(e);
        }
        return false;

    }

    function Match() {
        try {
            var isotemplate = document.getElementById('txtIsoTemplate').value;
            var res = MatchFinger(quality, timeout, isotemplate);

            if (res.httpStaus) {
                if (res.data.Status) {
                    alert("Finger matched");
                } else {
                    if (res.data.ErrorCode != "0") {
                        alert(res.data.ErrorDescription);
                    } else {
                        alert("Finger not matched");
                    }
                }
            } else {
                alert(res.err);
            }
        } catch (e) {
            alert(e);
        }
        return false;

    }

    function GetPid() {
        try {
            var isoTemplateFMR = document.getElementById('txtIsoTemplate').value;
            var isoImageFIR = document.getElementById('txtIsoImage').value;

            var Biometrics = Array(); // You can add here multiple FMR value
            Biometrics["0"] = new Biometric("FMR", isoTemplateFMR, "UNKNOWN", "", "");

            var res = GetPidData(Biometrics);
            if (res.httpStaus) {
                if (res.data.ErrorCode != "0") {
                    alert(res.data.ErrorDescription);
                } else {
                    document.getElementById('txtPid').value = res.data.PidData.Pid
                    document.getElementById('txtSessionKey').value = res.data.PidData.Sessionkey
                    document.getElementById('txtHmac').value = res.data.PidData.Hmac
                    document.getElementById('txtCi').value = res.data.PidData.Ci
                    document.getElementById('txtPidTs').value = res.data.PidData.PidTs
                }
            } else {
                alert(res.err);
            }

        } catch (e) {
            alert(e);
        }
        return false;
    }
    function GetProtoPid() {
        try {
            var isoTemplateFMR = document.getElementById('txtIsoTemplate').value;
            var isoImageFIR = document.getElementById('txtIsoImage').value;

            var Biometrics = Array(); // You can add here multiple FMR value
            Biometrics["0"] = new Biometric("FMR", isoTemplateFMR, "UNKNOWN", "", "");

            var res = GetProtoPidData(Biometrics);
            if (res.httpStaus) {
                if (res.data.ErrorCode != "0") {
                    alert(res.data.ErrorDescription);
                } else {
                    document.getElementById('txtPid').value = res.data.PidData.Pid
                    document.getElementById('txtSessionKey').value = res.data.PidData.Sessionkey
                    document.getElementById('txtHmac').value = res.data.PidData.Hmac
                    document.getElementById('txtCi').value = res.data.PidData.Ci
                    document.getElementById('txtPidTs').value = res.data.PidData.PidTs
                }
            } else {
                alert(res.err);
            }

        } catch (e) {
            alert(e);
        }
        return false;
    }
    function GetRbd() {
        try {
            var isoTemplateFMR = document.getElementById('txtIsoTemplate').value;
            var isoImageFIR = document.getElementById('txtIsoImage').value;

            var Biometrics = Array();
            Biometrics["0"] = new Biometric("FMR", isoTemplateFMR, "LEFT_INDEX", 2, 1);
            Biometrics["1"] = new Biometric("FMR", isoTemplateFMR, "LEFT_MIDDLE", 2, 1);
            // Here you can pass upto 10 different-different biometric object.


            var res = GetRbdData(Biometrics);
            if (res.httpStaus) {
                if (res.data.ErrorCode != "0") {
                    alert(res.data.ErrorDescription);
                } else {
                    document.getElementById('txtPid').value = res.data.RbdData.Rbd
                    document.getElementById('txtSessionKey').value = res.data.RbdData.Sessionkey
                    document.getElementById('txtHmac').value = res.data.RbdData.Hmac
                    document.getElementById('txtCi').value = res.data.RbdData.Ci
                    document.getElementById('txtPidTs').value = res.data.RbdData.RbdTs
                }
            } else {
                alert(res.err);
            }

        } catch (e) {
            alert(e);
        }
        return false;
    }

    function GetProtoRbd() {
        try {
            var isoTemplateFMR = document.getElementById('txtIsoTemplate').value;
            var isoImageFIR = document.getElementById('txtIsoImage').value;

            var Biometrics = Array();
            Biometrics["0"] = new Biometric("FMR", isoTemplateFMR, "LEFT_INDEX", 2, 1);
            Biometrics["1"] = new Biometric("FMR", isoTemplateFMR, "LEFT_MIDDLE", 2, 1);
            // Here you can pass upto 10 different-different biometric object.


            var res = GetProtoRbdData(Biometrics);
            if (res.httpStaus) {
                if (res.data.ErrorCode != "0") {
                    alert(res.data.ErrorDescription);
                } else {
                    document.getElementById('txtPid').value = res.data.RbdData.Rbd
                    document.getElementById('txtSessionKey').value = res.data.RbdData.Sessionkey
                    document.getElementById('txtHmac').value = res.data.RbdData.Hmac
                    document.getElementById('txtCi').value = res.data.RbdData.Ci
                    document.getElementById('txtPidTs').value = res.data.RbdData.RbdTs
                }
            } else {
                alert(res.err);
            }

        } catch (e) {
            alert(e);
        }
        return false;
    }
</script>
<?php
$js = '$("#nepali-datepicker").nepaliDatePicker({ndpYear:true,ndpMonth:true,ndpYearCount:20});$("#nepali-datepicker1").nepaliDatePicker({ndpYear:true,ndpMonth:true,ndpYearCount:20});$("#nepali-datepicker2").nepaliDatePicker();$("#nepali-datepicker3").nepaliDatePicker();$("#nepali-datepicker4").nepaliDatePicker();$("#nepaliDate3").nepaliDatePicker();';
$this->registerJs($js, 5); 
