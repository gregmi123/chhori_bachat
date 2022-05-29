<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ChoriBachat */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'खाता खोल्न नसकिएको', 'url' => ['chori-bachat/account-notverified-chhori']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


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
        <h3 style="text-align: center; background-color: #00b3ee ; height: 30px;"> छोरिको विवरण </h3>
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
                <?= $chori_detail['name'] ?>
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
        <h3 style="text-align: center;  background-color: #00b3ee ; height: 30px;"> अभिभावक तथा संरक्षक को विवरण  </h3>
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
        <h3 style="text-align: center;  background-color: #00b3ee ; height: 30px;"> आवशेक कागजातहरु को प्रतिलिपि   </h3>
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
               वडा बाट लिएको सिफारिस 
            </th>
            <td>
                <img src=" <?= $chori_detail['woda_sifarish_doc'] ?>" height="300" width="250"  alt="alt"/>  
            </td>
        </tr>
        
        <tr>
            <th>
               थप गर्नुपर्ने कागजात :
            </th>
            <th>
                 <?= $chori_detail['remarks'] ?>
            </th>
        </tr>
    </table>
    
   
    
  </div>
