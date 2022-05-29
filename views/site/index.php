<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\baseUrl;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */

$this->title = 'छोरी बचत खाता';

$eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
$nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
?>
<style>
 #districts{
   
    margin-top:1em;
    padding:3em;
    width:70%;
    display: inline-block;
    color:blue;
 }
#logo{
    width:100px;
    margin-left:-1em;
    margin-bottom:-6em;
    margin-top:-8em;
    
}
#name{
    font-size:13px;
    text-decoration:none;
    
}
.site-index{
    border: 2px solid black;
    border-radius:5px;
    margin-top:3px;
    
}

</style>
<div class="site-index">

<div class="container-fluid">
<div class="col-sm-12">
        <?php 
        
        $user_id=yii::$app->user->id;
        $user_details=\app\models\Users::findone(['id'=>$user_id]);
        $year = \app\models\EconomicYear::find()->Where(['status' => 1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
        $economic_year=\app\models\Year::find()->where(['id'=>$year['economic_year']])->one();  
        $chori_bachat_caste=[];
        // $chori_bachat_caste = (new \yii\db\Query())
        //     ->select('chori_bachat.id,chori_bachat.fk_caste,caste.name as caste_name,count(chori_bachat.fk_caste) as caste_count')
        //     ->from('chori_bachat')
        //     ->join('LEFT JOIN', 'caste', 'caste.id=chori_bachat.fk_caste')
        //     ->Where(['chori_bachat.fk_per_municipal'=>$user_details['fk_municipal_id']])
        //     ->andWhere(['chori_bachat.fk_economic_year'=>$year['economic_year']])
        //     ->groupBy('chori_bachat.fk_caste')
        //     ->all();
        //     $chori_bachat_apangata = (new \yii\db\Query())
        //     ->select('chori_bachat.id,chori_bachat.fk_apangata,apangata.name as apangata_name,count(chori_bachat.fk_apangata) as apangata_count')
        //     ->from('chori_bachat')
        //     ->Where(['chori_bachat.fk_per_municipal'=>$user_details['fk_municipal_id']])
        //     ->andWhere(['chori_bachat.fk_economic_year'=>$year['economic_year']])
        //     ->join('LEFT JOIN', 'apangata', 'apangata.id=chori_bachat.fk_apangata')
        //     ->groupBy('chori_bachat.fk_apangata')
        //     ->all();
           $chori_bachat_apangata=[];
            
        
        $total_chori=\app\models\ChoriBachat::find()->where(['fk_user_id'=>$user_details['id']])->count();
        $verified_chhori=\app\models\ChoriBachat::find()->where(['fk_user_id'=>$user_details['id']])->andWhere(['or',
        ['status'=>1],
        ['status'=>2],
        ['status'=>3],
        ['status'=>5],
        ['status'=>6],
        ['status'=>7],
        ])->count();
        $unverified_chhori=\app\models\ChoriBachat::find()->where(['fk_user_id'=>$user_details['id']])->andWhere(['or',
        ['status'=>0],
        ['status'=>4]
        ])->count();

        $running_chhori=\app\models\ChoriBachat::find()->where(['fk_user_id'=>$user_details['id']])->andWhere(['status'=>5])->count();
        $withdraw_chhori=\app\models\ChoriBachat::find()->where(['fk_user_id'=>$user_details['id']])->andWhere(['status'=>6])->count();
        $closed_chhori=\app\models\ChoriBachat::find()->where(['fk_user_id'=>$user_details['id']])->andWhere(['status'=>7])->count();
        $total_initial=\app\models\PaymentChori::find()->where(['fk_user_id'=>$user_details['id']])->where(['fk_economic_year'=>$year['economic_year']])->Sum('amount');
        $total_deposit=\app\models\OtherMonthPayment::find()->where(['fk_user_id'=>$user_details['id']])->where(['fk_year'=>$year['economic_year']])->Sum('amount');
            //var_dump($total_initial);die;
        $total_chori=\app\models\ChoriBachat::find()->where(['fk_user_id'=>$user_details['id']])->count();
        $total_initial=\app\models\PaymentChori::find()->where(['fk_user_id'=>$user_details['id']])->Sum('amount');
        $total_deposit=\app\models\OtherMonthPayment::find()->where(['fk_user_id'=>$user_details['id']])->Sum('amount');
        
        
        ?>
        <div class="col-sm-4" style="background-color:#17a2b8;height:160px;width:24%;margin-bottom:1em;border-radius: 20px;margin-top:2em;">
        <div class="col-sm-12">
        <h4 style="color:white;font-weight:bold;"><span class="glyphicon glyphicon-user" style="color:white;font-weight:bold;font-size:20px;"></span> कुल छोरी</h4>
        </div>
        <div class="col-sm-12" style="overflow-wrap: break-word;">
        <!-- <h6 style="color:white;font-weight:bold;">-><span ><= $chori['caste_name'] ?> (<= $chori['caste_count'] ?>)</span></h6> -->
        <!-- <h6 style="color:white;font-weight:bold;">-><span ><= $chori['caste_name'] ?> (<= $chori['caste_count'] ?>)</span></h6> -->
        <h5 style="color:black;font-weight:bold;"><span>प्रमाणित</span><span style="color:white;font-weight:bold;"> (<?= $verified_chhori ?>)</span></h5>
        <!-- <h6 style="color:white;font-weight:bold;">-><span ><= $chori['caste_name'] ?> (<= $chori['caste_count'] ?>)</span></h6> -->
        <h5 style="color:black;font-weight:bold;"><span>अप्रमाणित</span><span style="color:white;font-weight:bold;"> (<?= $unverified_chhori ?>)</span></h5>
        <h5 style="color:black;font-weight:bold;"><span>जम्मा छोरी</span><span style="color:white;font-weight:bold;"> (<?= $total_chori ?>)</span></h5>
        </div>
        
</div>
<div class="col-sm-4" style="background-color:rgb(255, 152, 0);height:160px;width:24%;margin-bottom:1em;border-radius:20px;margin-top:2em;margin-left:0.5%;">
        <div class="col-sm-12">
        <h4 style="color:white;font-weight:bold;"><span class="glyphicon glyphicon-refresh" style="color:white;font-weight:bold;font-size:20px;"></span> जम्मा रकम </h4>
        </div>
        <div class="col-sm-12" style="overflow-wrap: break-word;">
        <h5 style="color:black;font-weight:bold;"><span>प्रारम्भिक</span><span style="color:white;font-weight:bold;"> (<?= $total_initial ?>)</span></h5>
        <h5 style="color:black;font-weight:bold;"><span>मासिक</span><span style="color:white;font-weight:bold;"> (<?= $total_deposit ?>)</span></h5>
        <h5 style="color:black;font-weight:bold;"><span>जम्मा </span><span style="color:white;font-weight:bold;"> (<?= $total_initial + $total_deposit ?>)</span></h5>
        <!-- <php foreach($chori_bachat_apangata as $chori_apangata){ 
          if(!$chori_apangata['apangata_count']==0){?>
          
        <h6 style="color:white;font-weight:bold;">-><span ><= $chori_apangata['apangata_name'] ?> (<= $chori_apangata['apangata_count'] ?>)</span></h6>
        <php } } ?> -->
        </div>
        
</div>
<div class="col-sm-4" style="background-color:rgb(76 175 79);height:160px;border-radius:20px;margin-top:2em;margin-bottom:1em;width:24%;margin-left:0.5%;">
        <?php 
        
        $user_id=yii::$app->user->id;
        $user_details=\app\models\Users::findone(['id'=>$user_id]);
        // $account_details_status=(new \yii\db\Query())
        //     ->select('chori_bachat.id,chori_bachat.status,COUNT(chori_bachat.status) as status_count')
        //     ->from('chori_bachat')
        //     ->Where(['chori_bachat.fk_per_municipal'=>$user_details['fk_municipal_id']])
        //     ->andWhere(['chori_bachat.fk_economic_year'=>$year['economic_year']])
        //     ->groupBy('chori_bachat.status')
        //     ->all();
            //var_dump($total_initial);die;
            $account_details_status=[];
        ?>
        <div class="col-sm-12">
        <h4 style="color:white;font-weight:bold;"><span class="glyphicon glyphicon-briefcase" style="color:white;font-weight:bold;font-size:20px;"></span> रकम लिएका छोरी </h4>
        </div>
        
        <div class="col-sm-12" style="overflow-wrap: break-word;">
        <h3 style="color:white;font-weight:bold;text-align:center;"><span ><?= $withdraw_chhori ?></span></h3>
        <!-- <php foreach($account_details_status as $status){ >
          <php if((int)$status['status']==0){>
          <h6 style="color:white;font-weight:bold;">-><span >प्रमाणित नभएको(<= $status['status_count'] >)</span></h6>
        <php } >
        <php if((int)$status['status']==5){>
          <h6 style="color:white;font-weight:bold;">-><span >भुक्तान भएको(<= $status['status_count'] >)</span></h6>
        <php } >
        <php if((int)$status['status']==6){>
          <h6 style="color:white;font-weight:bold;">-><span >रकम लिएको(<= $status['status_count'] >)</span></h6>
        <php } >
        <php if((int)$status['status']==7){>
          <h6 style="color:white;font-weight:bold;">-><span >खारिज भएको(<= $status['status_count'] >)</span></h6>
        <php } >
       
        <php } > -->
        </div>
        
         
</div>

<div class="col-sm-4" style="background-color:#dc3545;width:24%;height:160px;border-radius:20px;margin-top:2em;margin-bottom:1em;margin-left:0.5%;">
        <?php 
        
        $user_id=yii::$app->user->id;
        $user_details=\app\models\Users::findone(['id'=>$user_id]);
        // var_dump($user_details['fk_municipal_id']);die;
       
            // var_dump($total_initial);die;
        ?>
         <div class="col-sm-12">
        <h4 style="color:white;font-weight:bold;"><span class="glyphicon glyphicon-remove" style="color:white;font-weight:bold;font-size:20px;"></span> खारेज भएका छोरी </h4>
        </div>
        <!-- <h4 style="color:white;font-weight:bold;"><= $total_initial + $total_deposit ?>/- <span style="font-size:0.90em;"> (रु) </span></h4>
       
        <php if($total_initial){ ?>
        <h6 style="color:white;font-weight:bold;">-><span ><= $total_initial ?> /-(प्रारम्भिक )</span></h6>
        <php } else{ ?>
          <h6 style="color:white;font-weight:bold;">-><span >0 /-(प्रारम्भिक )</span></h6>
        <php } ?>
        <php if($total_deposit){ ?>
        <h6 style="color:white;font-weight:bold;">-><span ><= $total_deposit ?> /-(मासीक )</span></h6>
        <php }else{ ?>
          <h6 style="color:white;font-weight:bold;">-><span >0 /-(मासीक )</span></h6>
          <php } ?> -->
          <div class="col-sm-12" style="overflow-wrap: break-word;">
        <h3 style="color:white;font-weight:bold;text-align:center;"><span ><?= $closed_chhori ?></span></h3>
        </div>
</div>

<div class="col-sm-9">
<!-- <h4 style="font-weight:bold;">कुल छोरी: < $total_chori ?></h4> -->
<h4 style="font-weight:bold;">जम्मा रकम: <?= $total_initial + $total_deposit ?>/- <span style="font-size:0.90em;"> (रु) </span></h4>
</div>
<div class="col-sm-3">
<h4 style="font-weight:bold;float:right;">आर्थिक वर्ष: <?= str_replace($eng_date, $nepali_date, $economic_year['economic_year']); ?></h4>
</div>
</div>

<hr style="border: 1px solid black;border-bottom: 0px;margin-right:2%;">

    <div class="col-md-12">
          <div class="col-md-6">
    <div id="piechart" style="width: 500px; height:300px;" class="col-sm-6"></div>
    
    </div>
    <div class="col-md-6">
    <div id="piechart1" style="width: 500px; height:300px;" class="col-sm-6"></div>
    </div>
    </div>
    <hr style="border: 1px solid black;border-bottom: 0px;margin-right:2%;">
    <div class="col-md-12">
    <div class="col-md-6">
    <div id="chart_div" style="width: 500px; height: 400px;" class="col-sm-6"></div>
        </div>
        <div class="col-md-6">
    <div id="chart_div1" style="width: 500px; height: 400px;" class="col-sm-6"></div>
        </div>
    </div>
   
    

    </div>
</div>
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable(<?=$casteWiseChartData_initial?>);

        var options = {
          title: 'आर्थिक वर्ष अनुसार प्रारम्भिक जम्माको विवरण'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable(<?=$casteWiseChartData_other?>);

        var options = {
          title: 'आर्थिक वर्ष अनुसार मासिक जम्माको विवरण'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart1'));

        chart.draw(data, options);
      }
    </script>
      <script type="text/javascript">
      google.charts.load('current', {packages: ['corechart', 'bar']});
      google.charts.setOnLoadCallback(drawBasic);

      function drawBasic() {

        var data = new google.visualization.arrayToDataTable(<?= $casteWiseChartData_initial ?>);
            

            var options = {
              title: 'आर्थिक वर्ष अनुसार प्रारम्भिक जम्माको विवरण',
            };

            var chart = new google.visualization.ColumnChart(
              document.getElementById('chart_div'));

            chart.draw(data, options);
          }
      </script>

<script type="text/javascript">
      google.charts.load('current', {packages: ['corechart', 'bar']});
      google.charts.setOnLoadCallback(drawBasic);

      function drawBasic() {

        var data = new google.visualization.arrayToDataTable(<?= $casteWiseChartData_other ?>);
            

            var options = {
              title: 'आर्थिक वर्ष अनुसार मासिक जम्माको विवरण',
            };

            var chart = new google.visualization.ColumnChart(
              document.getElementById('chart_div1'));

            chart.draw(data, options);
          }
      </script>










