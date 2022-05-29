<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\ChoriBachat;
use app\models\OtherMonthPayment;
$helper = new app\controllers\Helper();
use app\models\District;
use app\models\Ward;
use app\models\Municipals;

if(isset($_GET['page'])){
    $page=$_GET['page'];
}
else{
    $page=1;
}
if(isset($_GET['per-page'])){
$per_page=$_GET['per-page'];
}
else{
    $per_page=20;
}
/* @var $this yii\web\View */
/* @var $model app\models\PaymentChori */
/* @var $form yii\widgets\ActiveForm */
$money=\app\models\MoneySet::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->one();
$year = \app\models\EconomicYear::find()->andWhere(['status' => 1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
$economic_year=\app\models\Year::find()->where(['id'=>$year['economic_year']])->one();



$chori_name = yii\helpers\ArrayHelper::map(\app\models\ChoriBachat::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['status' => 5])->all(), 'id', 'name');
//var_dump($chori_name);die;
// $month =\app\models\Month::find()->andWhere(['id'=>$selectmonth])->one();
// $month1=\app\models\Month::find()->where(['id'=>$add_month])->one();
//var_dump($bank_name);die;
// $add_months = yii\helpers\ArrayHelper::map(\app\models\Month::find()->where(['id'=>$add_month])->all(), 'id', 'month_name');


//var_dump($economic_year);die;
// $province=\app\models\Province::find()->Where(['id' => $user_details->fk_province_id])->one();
$eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
$nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
$bank=\app\models\BankDetails::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->one();
$province=\app\models\Province::find()->Where(['id' => $user_details->fk_province_id])->one();

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'प्रारम्भिक भुक्तानीको लागी बैंकलाइ अनुरोध', 'url' => ['initial/create']];
$this->params['breadcrumbs'][] = $this->title;

$check=\app\models\PaymentChori::find()
                    ->where(['fk_user_id' => $user_id])
                    ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                    ->andWhere(['fk_economic_year'=>$economic_year['id']])
                    ->andWhere(['fk_initial'=>$initial_id])
                    ->one(); 
$bank=\app\models\BankDetails::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['id'=>$check['fk_bank_details']])->one();
?>
<style>
#find{
    background-color:red;
    color:white;
    margin-top:1.7em;
    margin-left:3em;

}
th,td{
    text-align:center;
}
</style>
<br>
<div class="col-sm-12">
<button class="btn btn-success" style="float:right;" onclick="printDiv()">Print</button>
</div>
<?= Html::a('Update',['check-update-initial','initial_id'=>$initial_id],['style'=>'float:left;','class'=>'btn btn-primary']) ?>
<div id="printdiv">
<?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?> 
  <div class="row-no-gutters" style="padding:3em 3em 0em 1em;">
    <div class="col-md-12">
        
        <p style="text-align: center;font-family: sans-serif;font-size: 19px;line-height: 29px; ">
        <?php
                    $municipalModel = new app\models\ChoriBachat();
                    echo $municipalModel->getMunicipal($user_details['fk_municipal_id']);
                    ?><br><!-- comment -->
                    नगर/गाँउ कार्यपालिका को कार्यालय <br>
                    <?php
                    $districtModel = new app\models\ChoriBachat();
                    echo $districtModel->getDistrict($user_details['fk_district_id']);
                    ?>
        </p>
    </div>
    <div class="row">
        <div class="col-md-12">
        <div class="col-md-12">
                <p style="float:right;font-size: 19px;">
                    मिति :<?= 
                    str_replace($eng_date, $nepali_date, $helper->actionNepaliDate());
                    ?>
                </p>
            </div>
            <br><br>
            <div class="col-md-8">
                <p style=" margin-left: 13%;font-family: sans-serif;font-size: 19px;line-height: 29px;">
                    श्री प्रबन्धक ज्ज्यु ,<br>
                    <?= $bank['bank_name'] ?>,<br>
                    <?= $province['province_nepali'] ?>,
                    
                </p> 
            </div>
        </div>
    </div>
</div><br><!-- comment -->
    <div class="row-no-gutters" style="padding:0 3em 0em 1em;">
        <div class="col-md-12">
            <h4 style="text-align: center;font-weight: bold;font-size: 18px;">
                बिषय : जम्मा गरी पाउँ भन्ने बारे। 
            </h4>
        </div>
        <div class="col-md-12">
            <div class="col-md-11">
                <h4 style="text-align: justify;padding-left: 8%; " >
                    प्रस्तुत बिषयमा कर्णाली प्रदेश सरकारको <span style="font-weight: bold;">बैंक खाता छोरीको, सुरक्षा जीवन भरिको </span> कार्यक्रम अन्तर्गत देहाएको 
                    छोरीहरुको खातामा दिएको कुल रकम जम्मा गरिदिन अनुरोध छ | निजहरुको खातामा जम्मा गरी खाता नम्बर सहितको जानकारी यस कार्यालयमा पठाईदिनु हुन अनुरोध छ। 
                    <br>
                    <br>
                    
                </h4>
                
            </div>
        </div>

             
    </div>
    <div class="col-md-12" id="initial_table" >
    <div class="">
    <br>
    <span style="font-weight:bold;padding:0 3em 0em 3em;">छोरीहरुको विवरण: </span>
    <div class="" style="float:right;">
        <?= Html::Button('<i class="glyphicon glyphicon-resize-full"></i> All', ['name' => 'all1','class'=>'btn btn-default','id'=>'all','onclick'=>'page('.$initial_id.')']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-resize-small"></i> Page', ['/payment-chori/initial-deposit','initial_id'=>$initial_id], ['name'=>'all2','id'=>'all2','class'=>'btn btn-default']) ?>
        </div>
    <hr style="border: 1px solid black;">
    <table class="table table-bordered" style="padding:0 3em 0em 3em;">
    <th>सी.न.</th>
    <th>छोरीको ID</th>
    <th>नाम  </th>
    <th>ठेगाना </th>
    <th>बुवाको नाम  </th>
    <th>जन्म मिति    </th>
    <th>मोबाइल न.   </th>
    <th>नगरपालिका   </th>
    <th>दर्ता मिति   </th> 

    <?php
    $a=1;
    $start=0;
    $start=(($page-1)*$per_page)+1; 
    foreach($models as $payment){ 
        $chori_bachat = \app\models\ChoriBachat::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['id' => $payment['fk_chori_bachat']])->one();
        $district=District::find()->where(['id'=>$chori_bachat['fk_per_district']])->one();
        $ward=Ward::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->where(['id'=>$chori_bachat['fk_ward']])->one();
        $municipals=Municipals::find()->where(['id'=>$chori_bachat['fk_per_municipal']])->one();
        $date1 = str_replace($eng_date, $nepali_date, $chori_bachat['dob']);
        $date2 = str_replace($eng_date, $nepali_date,$chori_bachat['created_date']);
        $mobile = str_replace($eng_date, $nepali_date,$chori_bachat['mobile_no']);?>
    <tr>
    <td><?= $start++ ?></td>
    <td><?= $chori_bachat['unique_id'] ?></td>
    <td><?= $chori_bachat['name']." ".$chori_bachat['middle_name']." ".$chori_bachat['last_name'] ?></td>
    <td><?= $district['district_nepali'] ?>-<?= $chori_bachat['tole_name'] ?>-<?= $ward['ward_name'] ?> </td>
    <td><?= $chori_bachat['father_name'] ?></td>
    <td><?= $date1?></td>
    <td><?= $mobile ?></td>
    <td><?= $municipals['municipal_nepali'] ?></td>
    <td><?= $date2?></td>
    </tr>

    <?php } ?>
    </table>
    

    </div> 

<div class="payment-chori-form" >

    
        <br>
        <div class="row">
        <div class="col-sm-3" style="padding:0 3em 0em 3em;">
        
            <span style="font-weight:bold;">आर्थिक वर्ष: </span><?= str_replace($eng_date,$nepali_date,$economic_year['economic_year'])?>
        
            </div>
            
            </div>
            <hr style="border: 1px solid black;">
    
        
        
  

   

    <div class="contain" id="target">
        
        
        <table class="table table-bordered" id="table2" style="padding:0 3em 0em 3em;">
            <thead>
                <tr>
                    <th>सी.न.</th>
                    <th>छोरीको ID</th>
                    <th>नाम</th>
                    <th>बैंकको नाम </th>
                    <th> खाता न. </th>
                    <th> रकम रु.</th>
                </tr>
            </thead>

            
           
        
                <?php
                
                    $count = 1;
                    $total=0;
                    $total_amount=0;
                    $count_month=1;
                    $start1=0;
                    $start1=(($page-1)*$per_page)+1;
                    foreach ($models as $pchori) {
                        //var_dump($opened->id);die;
                        $bachat = \app\models\ChoriBachat::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['id' => $pchori['fk_chori_bachat']])->one();
                        $chori_account=\app\models\ChoriAccountDetails::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['id' => $payment['fk_chori_account_details']])->one();
                        $bank=\app\models\BankDetails::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['id'=>$chori_account['bank_name']])->one();
                        ?>
               
                                
                                
                                
                            <tr>

                                <td>
                                    <?= $start1++; ?>
                                </td>
                                <td>
                                    
                                    <?= $bachat['unique_id']?>
                                </td>
                                <td>
                                    
                                    <?= $bachat['name']." ".$bachat['middle_name']." ".$bachat['last_name']?>
                                </td>
                                <td>
                                    <?= $bank['bank_name']?>
                                </td>
                                <td>
                                    
                                    <?= $chori_account['account_no']?>
                                </td>
                                <td>
                                    
                                    <?= (int)$pchori['amount'] ?>
                                </td>

                            </tr>
                            
                            <?php $total=$total+($pchori['amount']) ?>
                            <?php }  ?>
                            <tr>
                            <td colspan="5" style="text-align:center;"><span style="text-align:center;">कुल</span></td>
                            <td><?= $total ?></td>
                            </tr>
                                
                            
                       
                    
                


        </table>
        


    </div>
</div>
        <?php ActiveForm::end(); ?>
        </div>
                    </div>
</div> 

</div>
<script>
    function page(initial_id){
        $.post('index.php?r=payment-chori/report&initial_id='+initial_id,function(data){
            document.getElementById('initial_table').innerHTML=data;
        });
    }
    
</script>

<script>
      function printDiv()
    {

        var divToPrint = document.getElementById('printdiv');

        var newWin = window.open('', 'Print-Window');

        newWin.document.open();

        newWin.document.write('<html><head><style>\
        table{width:90%;margin-left:5%;border:1px solid black;border-collapse: collapse;}\
        th,td{border: 1px solid black;border-collapse: collapse;}\
        hr{display:none;}\
        td,th{text-align:left;}\
        #hide{display:none;}\
        #all{display:none;}\
        #all2{display:none;}</style></head><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

        newWin.document.close();

        setTimeout(function () {
            newWin.close();
        }, 10);

    }

   </script>
<script>
// $(document).ready(function(){
//    $('#month').on('change', function(){
//       var month = $(this).val();
//       var year =$('#economic-year').val();
//       //alert(year);
//       //if(month!==""){
//           $.ajax({
//              url: 'chori_payment.php',
//              method : 'post',
//              data: {month:month, year:year},
//              success : function(data){
//                  $('#target').fadeIn(data);
//                  $('#target').val(data);
//                  alert(data);
//              }
//             
//           });
//       //}
//    });
// });
</script>
