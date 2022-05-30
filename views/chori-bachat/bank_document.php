<?php

use yii\helpers\Html;

$helper = new app\controllers\Helper();

$this->title = 'खाता खोल्नु पर्ने छोरिहरु को विवरण ';
$this->params['breadcrumbs'][]=['label'=>'खाताको लागि अनुरोधको सुची','url'=>['chori-bachat/request-index']];
$this->params['breadcrumbs'][] = $this->title;

$eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
$nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');


?>
<style>
    th,td{
        text-align:center;
    }

</style>
<h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>


<button class="btn btn-success" style="float:right;" onclick="printDoc()">Print</button>
<div  id="printdiv">
<div class="row-no-gutters" style="padding:50px;">
    <?php foreach ($bank_chhori_data as $bank_chori) {
        ?>


        
            <div class="col-md-12">

                <p style="text-align: center;font-family: sans-serif;font-size: 19px;line-height: 29px; ">
                    <br><!-- comment -->
                   
                 
                    <?php
                    $municipalModel = new app\models\ChoriBachat();
                    echo $municipalModel->getMunicipal($bank_chori['fk_per_municipal']);
                    ?><br>
                    नगर/गाँउ कार्यपालिका को कार्यालय <br>
                    <?php
                    $districtModel = new app\models\ChoriBachat();
                    echo $districtModel->getDistrict($bank_chori['fk_per_district']);
                    ?>
                </p>
            </div>
            <div class="row-no-gutters">
                <div class="col-md-12">

                    <div class="">
                        <p style="font-family: sans-serif;font-size: 19px;line-height: 29px;">
                            श्री प्रबन्धक ज्ज्यु ,<br>
                            <?= $bank_name['bank_name']; ?> <br>
                            कर्णाली प्रदेश 

                        </p> 

                    </div>
                    <div class="">
                        <p style="font-size: 19px;float:right;">
                            मिति :<?= 
                            $date1 = str_replace($eng_date, $nepali_date, $helper->actionNepaliDate());
                            // $helper->actionNepaliDate(); ?>
                        </p>
                    </div>
                </div>
            </div><!-- comment -->
            <div class="row-no-gutters">
                <div class="col-md-12">
                <br><br>
                    <h4 style="text-align: center;font-weight: bold;font-size: 18px;">
                        बिषय : खाता खोलिदिने बारे। 
                    </h4>
                </div>
                <div class="col-md-12">
                    <div class="col-md-10">
                        <h4 style="text-align: justify;padding-left: 8%; " >
                            प्रस्तुत बिषयमा कर्णाली प्रदेश सरकारको <span style="font-weight: bold;">बैंक खाता छोरीको, सुरक्षा जीवन भरिको </span> कार्यक्रम अन्तर्गत देहाएका 
                            व्यक्तिहरुको खाता खोलिदिनहुन आवश्यक कागजात सहित सिफारिस गरी पठाइएको छ।  निजहरुको खाता खोली खाता 
                            नंबर सहितको जानकारी यस कार्यालयमा पठाईदिनु हुन अनुरोध छ।  
                        </h4>
                        <h4 style="text-decoration:underline;">
                            देहाय:
                        </h4>
                    </div>
                </div>
            </div>
            
            <?php break; } ?>
            <table style="" class="table table-bordered">
                <thead>
                    <tr>
                        <th>सी.न. </th>
                        <th>नाम</th>
                        <th>जन्म मिति </th>
                        <th>जन्म दर्ता न.</th>
                        <th>दर्ता मिति </th>
                        <th>अभिभावकको नाम </th>
                        <th>ठेगाना</th>

                    </tr>
                </thead>
                
                
                    <?php $count = 1; ?>
                    <?php foreach ($bank_chhori_data as $bank_chori) {
                        $ward=\app\models\Ward::findone(['id'=>$bank_chori['fk_ward']]);
        ?>
                    <tr>
                        <td><?= $count++; ?></td>
                        <td><?= $bank_chori['name'].' '.$bank_chori['middle_name'].' '.$bank_chori['last_name'] ?></td>
                        <td><?= 
                        $date2 = str_replace($eng_date, $nepali_date, $bank_chori['dob']);
                        //$bank_chori['dob'] ?></td>
                        <td><?= $bank_chori['birth_certificate_no'] ?></td>
                        <td><?= 
                        $date3 = str_replace($eng_date, $nepali_date, $bank_chori['birth_certificate_date']);
                        //$bank_chori['birth_certificate_date'] ?></td>
                        <?php if($bank_chori['take_care_person']){ ?>
                        <td><?= $bank_chori['take_care_person'] ?></td>
                        <?php } else if($bank_chori['father_name']){ ?>
                            <td><?= $bank_chori['father_name'] ?></td>
                        <?php } else{ ?>
                            <td><?= $bank_chori['mother_name'] ?></td>
                        <?php } ?>
                        <?php 
                        $municipal_nepali=\app\models\Municipals::findOne(['id'=>$bank_chori['fk_per_municipal']]);
                        $district_nepali=\app\models\District::findOne(['id'=>$bank_chori['fk_per_district']]);
                        $ward=\app\models\Ward::findOne(['id'=>$bank_chori['fk_ward']]);

                        if($bank_chori['tole_name']){
                        ?>
                        <td><?= $municipal_nepali['municipal_nepali'] ?>-<?= $district_nepali['district_nepali'] ?>-<?= $bank_chori['tole_name'] ?>-<?= $ward['ward_name'] ?> </td>    
                    <?php } else { ?>
                        <td><?= $municipal_nepali['municipal_nepali'] ?>-<?= $district_nepali['district_nepali'] ?>-<?= $ward['ward_name'] ?> </td>
                        <?php } ?>
                    </tr>
                    <?php } ?>
               

                    </table>
            <br><br>
            <div class="col-md-12">

                <p style="margin-left:70%;font-family: sans-serif;font-size: 19px;line-height: 29px;">
                    दस्तखत :...................<!-- comment --><br><!-- comment -->
                    नाम :......................<br>
                    पद : प्रमुख प्रशासकीय अधिकृत
                </p>
            </div>
            
                
                
               
            <?php foreach ($bank_chhori_data as $bank_chori) {
        ?>  
        <?php if($bank_chori['chori_birth_certificate_doc']){ ?>
                <div class="col-md-12">
                    <img style="padding: 30px;" src="<?= $bank_chori['chori_birth_certificate_doc'] ?>" height="848px" width="100%" alt="alt"/>
                    <br><!-- comment -->
                    <h4 style="text-align: center;">
                        <?= $bank_chori['name'].' '.$bank_chori['middle_name'].' '.$bank_chori['last_name'] ?> को जन्मदर्ता को प्रतिलिपि
                    </h4>
                </div>
                <?php } ?>
                <?php if($bank_chori['parents_citizenship_doc']){ ?>
                <div class="col-md-12">
                    <img style="padding: 30px;" src="<?= $bank_chori['parents_citizenship_doc'] ?>"  height="848px;" width="100%" alt="alt"/>
                    <br><!-- comment -->
                    <h4 style="text-align: center;">
                    <?= $bank_chori['name'].' '.$bank_chori['middle_name'].' '.$bank_chori['last_name'] ?> को बुवाको नागरिता को प्रतिलिपि 
                    </h4>
                </div>
                <?php } ?>
                <?php if($bank_chori['mother_citizenship_doc']){ ?>
                <div class="col-md-12">
                    <img style="padding: 30px;" src="<?= $bank_chori['mother_citizenship_doc'] ?>"  height="848px;" width="100%" alt="alt"/>
                    <br><!-- comment -->
                    <h4 style="text-align: center;">
                    <?= $bank_chori['name'].' '.$bank_chori['middle_name'].' '.$bank_chori['last_name'] ?> को आमको नागरिता को प्रतिलिपि 
                    </h4>
                </div>
                <?php } ?>
                <?php if($bank_chori['sastha_certificate']){ ?>
                <div class="col-md-12">
                    <img style="padding: 30px;" src="<?= $bank_chori['sastha_certificate'] ?>"  height="848px;" width="100%" alt="alt"/>
                    <br><!-- comment -->
                    <h4 style="text-align: center;">
                    <?= $bank_chori['name'].' '.$bank_chori['middle_name'].' '.$bank_chori['last_name'] ?> को संस्था दर्ताको प्रमाणपत्रको प्रतिलिपि
                    </h4>
                </div>
                <?php } ?>
                <?php if($bank_chori['hospital_certificate']){ ?>
                <div class="col-md-12">
                    <img style="padding: 30px;" src="<?= $bank_chori['hospital_certificate'] ?>"  height="848px;" width="100%" alt="alt"/>
                    <br><!-- comment -->
                    <h4 style="text-align: center;">
                    <?= $bank_chori['name'].' '.$bank_chori['middle_name'].' '.$bank_chori['last_name'] ?> को स्वास्थ केन्द्र प्रमाणपत्र को प्रतिलिपि वा खोप दिएको प्रतिलिपि
                    </h4>
                </div>
                <?php } ?>
                <?php if($bank_chori['woda_sifarish_doc']){ ?>
                <div class="col-md-12">
                    <img style="padding: 30px;" src="<?= $bank_chori['woda_sifarish_doc'] ?>"  height="848px;" width="100%" alt="alt"/>
                    <br><!-- comment -->
                    <h4 style="text-align: center;">
                    <?= $bank_chori['name'].' '.$bank_chori['middle_name'].' '.$bank_chori['last_name'] ?> को वडा सिफारिसको प्रतिलिपि
                    </h4>
                </div>
                <?php } ?>
    <?php } ?>
    </div>  
</div>

<script>
    function printDoc()
    {

        // var divToPrint = document.getElementById('printdiv');

        // var newWin = window.open('', 'Print-Window');

        // newWin.document.open();

        // newWin.document.write('<html><head><style>table{width: 100%;border: none;background-color: none;margin-left:0px;background-color:transparent;}.col-md-12{width:100%;}</style></head><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

        // newWin.document.close();

        // setTimeout(function () {
        //     newWin.close();
        // }, 1000);
        var html="<html><head><style>table{width:100%;text-align:center;background-color:none;margin-left:0px;background-color:transparent;}.col-md-12{width:100%;}</style></head>";
   html+= document.getElementById('printdiv').innerHTML;

   html+="</html>";

   var printWin = window.open('','Print-Window','left=0,top=0,width=auto,height=auto,toolbar=0,scrollbars=0,status =0');
   printWin.document.write(html);
   printWin.document.close();
   printWin.print();
   printWin.close();

    }

</script>





