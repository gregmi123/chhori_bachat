<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ChoriBachat */

$this->params['breadcrumbs'][] = ['label' => 'छोरी बचत फर्म'];
$this->params['breadcrumbs'][] = ['label' => 'तथ्याङ्ग', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>$model->name];
$this->params['breadcrumbs'][] = $this->title;
//\yii\web\YiiAsset::register($this);
//$this->title = 'login your password';
//$message = Yii::$app->session->getFlash('message');
//$form = \yii\widgets\ActiveForm::begin();
?>




<div class="chori-bachat-view">
    <p>
        <?php if($model->status==0 || $model->status==1 || $model->status==3 || $model->status==4){ ?>
        <?= Html::a('अपडेट', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php } ?>
    </p>
    <h1><?= Html::encode($this->title) ?></h1>

    <h3 style="text-align: center; height: 30px;"> <u><b>छोरिको विवरण </b></u></h3>
</tr>
<?php if($chori_detail['image']!=null){ ?>
<p style="text-align: center;"><img src="<?= $chori_detail['image'] ?>" style="border-radius: 25px;" height="150" width="200" alt="alt"/> 
<?php } ?> 
<!-- comment --></p>
<h4 style="text-align: center; font-weight: bold;"> फोटो </h4>

<table class="table table-bordered" style="width: 80%; margin-left: 10%;">
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
            छोरिको ID
        </th>
        <td>
            <?= $chori_detail['unique_id']; ?>   
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
          जन्म दर्ता न.
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
          <?= $chori_detail['birth_certificate_date'] ?> 
        </td>

    </tr>
    <tr>
        <th>
          ठेगाना
        </th>
        <td>
          <?= $chori_detail['municipal_nepali'] ?>-<?= $chori_detail['district_nepali'] ?>-<?= $chori_detail['tole_name'] ?>-<?= $chori_detail['ward_name'] ?> 
        </td>

    </tr>
    <tr>
        <th>
         सम्पर्क ठेगाना 
        </th>
        <td>
            <b> मोबाइल न.:</b> &nbsp;&nbsp;<?= $chori_detail['mobile_no'] ?><br><!-- comment -->
            <b>इमेल:</b> &nbsp;&nbsp; <?= $chori_detail['email'] ?><br>
            <b>फोन न:</b> &nbsp;&nbsp;<?= $chori_detail['phone_no'] ?>
        </td>

    </tr>
    <tr>
        <th>
            औंठा छाप
        </th>
        <td style="display:flex;">
            <b> दाँया:</b> &nbsp;&nbsp;<?= Html::img($chori_detail['thumb_right'],['width'=>'100px;','height'=>'100px;','alt'=>'left-finger']) ?><br><!-- comment -->
            <b>बाँया:</b> &nbsp;&nbsp; <?= Html::img($chori_detail['thumb_left'],['width'=>'100px;','height'=>'100px;','alt'=>'right-finger']) ?><br>
        </td>

    </tr>
</table>


<h3 style="text-align: center;  height: 30px;"> <u><b>अभिभावक तथा संरक्षकको विवरण </b></u> </h3>
<p style="text-align: center;"><img src="<?= $chori_detail['guardian_image'] ?>" style="border-radius: 25px;" height="150" width="200" alt="alt"/>   
    <!-- comment --></p>
<h4 style="text-align: center; font-weight: bold;"> अभिभावकको फोटो  </h4>
<table class="table table-bordered" style="width: 80%; margin-left: 10%;">
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
            <?= $chori_detail['father_citizenship_no'] ?>
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
            <?= $chori_detail['take_care_person'] ?>
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

<h3 style="text-align: center;"> <b><u>आवशेक कागजातहरुको प्रतिलिपि</u> </b>  </h3>
<table class="table table-bordered" style="width: 80%; margin-left: 10%;">
    
    
   
    <tr>
        <?php if($chori_detail['chori_birth_certificate_doc']){ ?>
        <td>
           <img src="<?= $chori_detail['chori_birth_certificate_doc'] ?>" height="400" width="100%" alt="alt"/>
           <h4 style="text-align: center">
               छोरिको प्रतिलिपि 
           </h4>
        </td>
        <?php } ?>
        <?php if($chori_detail['parents_citizenship_doc']){ ?>
        <td>
              
            <img src=" <?= $chori_detail['parents_citizenship_doc'] ?>" height="400" width="100%"  alt="alt"/>
            <h4 style="text-align: center;"> बुवाको नागरिताको प्रतिलिपि  </h4>
        </td>
        <?php } ?>
    </tr>
    
    <tr>
    <?php if($chori_detail['mother_citizenship_doc']){ ?>
        <td>
            <img src=" <?= $chori_detail['mother_citizenship_doc'] ?>" height="400" width="100%"  alt="alt"/> 
           <h4 style="text-align: center">
              आमाको नागरिताको प्रतिलिपि   
           </h4>
        </td>
        <?php } ?>
        <?php if($chori_detail['woda_sifarish_doc']){ ?>
        <td>
              
            <img src="<?= $chori_detail['woda_sifarish_doc'] ?>" height="400" width="100%"  alt="alt"/>  
            <h4 style="text-align: center;"> वडा सिफारिसको प्रतिलिपि </h4>
        </td>
        <?php } ?>
    </tr>
    <tr>
    <?php if($chori_detail['hospital_certificate']){ ?>
        <td>
            <img  src=" <?= $chori_detail['hospital_certificate'] ?>" height="400" width="100%"  alt="alt"/> 
           <h4 style="text-align: center">
              स्वास्थ केन्द् वा खोप लिएको प्रमाणपत्र  
           </h4>
        </td>
        <?php } ?>
        <?php if($chori_detail['sastha_certificate']){ ?>
        <td>
              
            <img src=" <?= $chori_detail['sastha_certificate'] ?>" height="400" width="100%"  alt="alt"/>  
            <h4 style="text-align: center;">  संस्था भए संस्थाको प्रमाणपत्र   </h4>
        </td>
        <?php } ?>
    </tr>
    
</table>
<?php if(!($model['status'] == 6 || $model['status'] == 7 || $model['status'] == 5 )) { ?>
<h3 style="text-align: center;"> <b><u>यदि कागजातहरु अनुसूची बमोजिम छ भने प्रमाणित गर्नुहोस</u></b> </h3>
<table  class="table table-bordered" style="width: 80%; margin-left: 10%;">
    <tr>
        <th>Status</th>
        <td>
            <?php
            if($model['status'] == 0 || $model['status'] == 4) {
                echo Html::a('प्रमाणित गर्नुहोस ', ['verify', 'id' => $model['id']], ['class' => 'btn btn-sm btn-danger',
                    'data' => [
                        'confirm' => 'के सबै कागजातहरु ठिक छन् ?',
                        'method' => 'post',
                    ],
                ]);
            } else {
                echo Html::a('रद्द गर्नुहोस ', ['verified', 'id' => $model['id']], ['class' => 'btn btn-sm btn-success',
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
<?php } ?>
</div>












