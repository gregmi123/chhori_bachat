<?php 
use yii\helpers\Html;
$helper = new app\controllers\Helper();

$this->title = 'खाता खोल्नु पर्ने छोरिहरु को विवरण ';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

<br>
<button style="float:right;" onclick="printDiv()">Print</button>

<div id="printdiv">
  <div class="row-no-gutters">
    <div class="col-md-12">
        <?php foreach($activeChoriList as $active ){
            
        } ?>
        <p style="text-align: center;font-family: sans-serif;font-size: 19px;line-height: 29px; ">
            .....................<br><!-- comment -->
                    नगर/गाँउ कार्यपालिका को कार्यालय <br>
             .......................
        </p>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8">
                <p style=" margin-left: 13%;font-family: sans-serif;font-size: 19px;line-height: 29px;">
                    श्री प्रबन्धक ज्ज्यु ,<br>
                    .............. बैंक <br>
                    ................कर्णाली प्रदेश 
                    
                </p> 
            </div>
            <div class="col-md-4">
                <p style="margin-left: 12%;margin-top: 11%; font-size: 19px;">
                    मिति :<?= $helper->actionNepaliDate(); ?>
                </p>
            </div>
        </div>
    </div><br><!-- comment -->
    <div class="row-no-gutters">
        <div class="col-md-12">
            <h4 style="text-align: center;font-weight: bold;font-size: 18px;">
                बिषय : खाता खोलिदिने बारे। 
            </h4>
        </div>
        <div class="col-md-12">
            <div class="col-md-10">
                <h4 style="text-align: justify;padding-left: 8%; " >
                    प्रस्तुत बिषयमा कर्णाली प्रदेश सरकारको <span style="font-weight: bold;">बैंक खाता छोरीको, सुरक्षा जीवन भरिको </span> कार्यक्रम अन्तर्गत देहायेका 
                    व्यक्तिहरुको खाता खोलिदिनु हुन आवासक कागजात सहित सिफारिस गरि पठाएको छ।  निजरुको खाता खोलि खाता 
                    नम्बर सहितको जानकारी यस कार्यालयमा पठाईदिनु हुन अनुरोध छ।  
                </h4>
            </div>
        </div>
    </div>


<table border="1" style="margin-top: 14%;" class="table table-bordered">
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
    <tbody>
        <?php $count =1; ?>
        <?php foreach($activeChoriList as $active ){
             
   //var_dump($active['dob']);die;
 ?>

        <tr>
            <td><?= $count++ ?></td>
            <td><?= $active['name'] ?></td>
            <td><?= $active['dob'] ?></td>
            <td><?= $active['birth_certificate_no'] ?></td>
            <td><?= $active['birth_certificate_date'] ?></td>
            <td><?= $active['father_name'] ?></td>
            <td><?= $active['tole_name'] ?>-<?= $active['wname'] ?></td>
           
        </tr>
<?php } ?>
    </tbody>
</table>
    <div class="col-md-12">
        
        <p style="margin-left:70%;margin-top:3%;font-family: sans-serif;font-size: 19px;line-height: 29px;">
            दस्तखत :...................<!-- comment --><br><!-- comment -->
            नाम :......................<br>
            पद : प्रमुख प्रशासकीय अधिकृत
        </p>
    </div>
</div>  
</div>


 <script>
      function printDiv()
    {

        var divToPrint = document.getElementById('printdiv');

        var newWin = window.open('', 'Print-Window');

        newWin.document.open();

        newWin.document.write('<html><head><style>table{width: 100%;border: none;background-color: none;margin-left:0px;background-color:transparent;}.col-md-12{width:100%;}.content{margin-top:-15px;}</style></head><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

        newWin.document.close();

        setTimeout(function () {
            newWin.close();
        }, 10);

    }

   </script>






