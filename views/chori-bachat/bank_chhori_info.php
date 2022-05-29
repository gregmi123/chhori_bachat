<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model app\models\ChoriBachat */
$message = Yii::$app->session->getFlash('message');
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'खाता खोल्नको लागि पठाएको', 'url' => ['chori-bachat/request-account']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// var_dump($message);die;
$this->registerJs($this->render('myJs.js'), 5);
?>
<?php 
foreach($chori_details as $chori_detail){
    //var_dump($chori_detail['dob']);die;
}


?>
<div class="chori-bachat-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <table class="table table-bordered">
        <table class="table table-bordered">
        <tr>
        <h3 style="text-align: center; background-color: #00b3ee ; line-height: 35px;"> छोरिको विवरण </h3>
        </tr>
        <tr>
            <th>
                छोरिको फोटो  
            </th>
            <td>
                <img src="<?= $chori_detail['image']?>" height="150" width="200" alt="alt"/>     
            </td>
        </tr>
        <tr>
            <th>
                छोरिको नाम 
            </th>
            
            <td>
                <?= $chori_detail['name']." ".$chori_detail['middle_name']." ".$chori_detail['last_name'] ?>
            </td>
        </tr>
        <tr>
            <th>
                जन्म मिति 
            </th>
            <td>
                <?= $chori_detail['dob'] ?>
            </td>
        </tr>
        <tr>
            <th>
                जन्म दर्ता न 
            </th>
            <td>
                <?= $chori_detail['birth_certificate_no'] ?>
            </td>
        </tr>
        <tr>
            <th>
                दर्ता मिति 
            </th>
            <td>
                <?= $chori_detail['birth_certificate_date']?>
            </td>
        </tr>
        <tr>
            <th>
                 ठेगाना 
            </th>
           
                <td><?= $chori_detail['municipal_nepali'] ?>-<?= $chori_detail['district_nepali'] ?>-<?= $chori_detail['tole_name'] ?>-<?= $chori_detail['ward_name'] ?></td>
            
        </tr>
        
    </table>
    <table class="table table-bordered">
        <tr>
        <h3 style="text-align: center;  background-color: #00b3ee ; line-height: 35px;"> अभिभावक तथा संरक्षक को विवरण  </h3>
        </tr>
        <tr>
            <th>
              अभिभावकको फोटो 
            </th>
            <td>
                <img src="<?= $chori_detail['guardian_image'] ?>" height="150" width="200" alt="alt"/>   
            </td>
        </tr>
        <tr>
            <th>
                बुवाको नाम
            </th>
            <td>
                <?= $chori_detail['father_name'] ?>
            </td>
            
        </tr>
        <tr>
            <th>
                बुवाको नागरिता न 
            </th>
            <td>
                <?= $chori_detail['father_citizenship_no']?>
            </td>
        </tr>
        <tr>
            <th>
                आमाको नाम 
            </th>
            <td>
                <?= $chori_detail['mother_name'] ?>
            </td>
        </tr>
        <tr>
            <th>
                आमाको नागरिता न 
            </th>
            <td>
                <?= $chori_detail['mother_citizenship_no'] ?>
            </td>
        </tr>
        <tr>
            <th>
                संरक्षकको नाम
            </th><!-- comment -->
            <td>
                <?php $chori_detail['take_care_person'] ?>
            </td>
        </tr>
        <tr>
            <th>
              संरक्षकको नागरिता न   
            </th>
            <td>
               <?= $chori_detail['take_care_citizenship_no'] ?>
            </td>
        </tr>
    </table>
    <table class="table table-bordered">
        <tr>
        <h3 style="text-align: center;  background-color: #00b3ee ; line-height: 35px;"> आवशेक कागजातहरु को प्रतिलिपि   </h3>
        </tr>
        <tr>
            <th>
                छोरिको जन्म दर्ताको 
            </th>
            <td>
                <img src="<?= $chori_detail['chori_birth_certificate_doc'] ?>" height="300" width="250" alt="alt"/>  
            </td>
        </tr>
        <tr>
            <th>
               बुवाको नागरिता प्रतिलिपि 
            </th>
            <td>
                <img src=" <?= $chori_detail['parents_citizenship_doc'] ?>" height="300" width="250"  alt="alt"/> 
            </td>
        </tr>
        <tr>
            <th>
               आमाको नागरिता प्रतिलिपि 
            </th>
            <td>
                <img src=" <?= $chori_detail['mother_citizenship_doc'] ?>" height="300" width="250"  alt="alt"/> 
            </td>
        </tr>
        <tr>
            <th>
                सस्था भए सस्थाको प्रमाणपत्र 
            </th>
            <td>
                <img src=" <?= $chori_detail['sastha_certificate'] ?>" height="300" width="250"  alt="alt"/>  
            </td>
        </tr>
        <tr>
            <th>
                 स्वास्थ केन्द्रको वा खोप लिएको प्रमाणपत्र 
            </th>
            <td>
                <img src=" <?= $chori_detail['hospital_certificate'] ?>" height="300" width="250"  alt="alt"/>  
            </td>
        </tr>
        <tr>
            <th>
                 स्वास्थ केन्द्रको वा खोप लिएको प्रमाणपत्र 
            </th>
            <td>
                <img src=" <?= $chori_detail['woda_sifarish_doc'] ?>" height="300" width="250"  alt="alt"/>  
            </td>
        </tr>
       
    </table>
<!--    <table class="table table-bordered">
        <tr>
           <tr>
        <h3 style="text-align: center;  background-color: #00b3ee ; height: 30px;"> यदि कागजातहरु अनुसूची बभोजिम छ भने प्रमाणित गर्नुहोस  </h3>
           </tr>
           
        </tr>
        
         <tr>
            <th>Status</th>
            <td>
               <?php
                if ($model['status'] == 0) {
                    echo  Html::a('प्रमाणित नभयको ', ['verify', 'id' => $model['id']], ['class' => 'btn btn-sm btn-danger',
                        
                        'data' => [
                'confirm' => 'के सबै कागजातहरु ठिक छन् ?',
                'method' => 'post',
            ],
                        ]);
                } else{
                    echo  Html::a('प्रमाणित भयको ', ['verified', 'id' => $model['id']], ['class' => 'btn btn-sm btn-success',
                        'data' => [
                'confirm' => 'के तपाई प्रमाणित नगर्न खोज्नु भएको हो ?',
                'method' => 'post',
            ],
                        
              ]);
                }
                ?>
            </td>
        </tr>
    </table>
    </table>-->
       
     <?php $form=ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','class' => 'disable-submit-buttons']]); ?> 
     <?= $form->field($accountDetails, 'chori_unique_id')->hiddenInput(['value'=>$chori_detail['unique_id']])->label(false) ?>
        <table border="1" class="table table-bordered">
            <tr>
            <h4 style="text-align: center;">बैंक प्रयोजनाको लागि मात्र </h4>
            </tr>
            <tr>
                <?= $form->field($accountDetails,'radio_status')->checkbox(['onchange'=>'displayBankDetails()','id'=>'check-bank']); ?>
            </tr>
            
            <tr>
              <div class="col-md-12" id="hide-content" style="display: none">
                <div class="col-md-6">
                    <?= $form->field($accountDetails, 'account_no')->textInput(['maxlength' => true]) ?>
                    <?php
                    if ($message && $mes==1) {
                        echo '<p style="color:red;">' . $message . '</p>';
                    }
                    ?>
                </div>
                <div class="col-md-6">
                    
                   <?= $form->field($accountDetails, 'account_open_date',['inputOptions' => ['id' => 'nepali-datepicker','class'=>'form-control']])->widget(MaskedInput::class,[
                                    'mask' => '9999-99-99',
                                ]) ?>
                   <?php
                    if ($message && $mes==2) {
                        echo '<p style="color:red;">' . $message . '</p>';
                    }
                    ?>
                </div>
                  
            </div>  
            </tr>
            <tr>
            <div class="col-md-12" id="content" >
           <?= $form->field($accountDetails, 'remarks')->widget(TinyMce::className(), [
    'options' => ['rows' => 6],
    'language' => 'en',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    ]
]);?>
<?php
        if ($message && $mes==3) {
            echo '<p style="color:red;">' . $message . '</p>';
        }
        ?>
              </div>  
            </tr>
            
         <?= Html::submitButton('पेश गर्नुहोस', ['class' => 'btn btn-success','data' => ['confirm' => 'के तपाई पेश गर्न चाहनुहुन्छ?','method'=>'post']]) ?>  
         
         <?php
                    if ($message && $mes==4) {
                        echo '<p style="color:red;">' . $message . '</p>';
                    }
                    ?>
        </table> 
        
       
  <?php ActiveForm::end(); ?>
    
  </div>

<script>
   window.onload = function(){
    let checkBox = document.getElementById('check-bank');
    var target = document.getElementById('hide-content');
     var target1 = document.getElementById('content');
     if(checkBox.checked){
        $(target).show();
        $(target1).hide();
    }else{
        $(target).hide();
        $(target1).show();
    }
   }
function displayBankDetails(){
    let checkBox = document.getElementById('check-bank');
    var target = document.getElementById('hide-content');
     var target1 = document.getElementById('content');
     
    if(checkBox.checked){
        $(target).show();
        $(target1).hide();
    }else{
        $(target).hide();
        $(target1).show();
    }
}

</script>
<?php
$js = '$("#nepali-datepicker").nepaliDatePicker({ndpYear:true,ndpMonth:true,ndpYearCount:20});$("#nepali-datepicker1").nepaliDatePicker();$("#nepali-datepicker2").nepaliDatePicker();$("#nepali-datepicker3").nepaliDatePicker();$("#nepali-datepicker4").nepaliDatePicker();$("#nepaliDate3").nepaliDatePicker();';
$this->registerJs($js, 5);
