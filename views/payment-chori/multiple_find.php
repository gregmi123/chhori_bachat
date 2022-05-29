<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

$this->title = ' मासिक रकम जम्मा गर्नको लागी ';
$this->params['breadcrumbs'][] = ['label' => 'भुक्तानी'];
$this->params['breadcrumbs'][] = $this->title;
/* @var $this yii\web\View */
/* @var $model app\models\PaymentChori */
/* @var $form yii\widgets\ActiveForm */
$user_id = yii::$app->user->id;
$user_details = app\models\Users::findOne(['id' => $user_id]);
$chori_name = yii\helpers\ArrayHelper::map(\app\models\ChoriBachat::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['status' => 5])->all(), 'id', 'name');
//var_dump($chori_name);die;
$month = yii\helpers\ArrayHelper::map(\app\models\Month::find()->all(), 'id', 'month_name');
//var_dump($month);die;
$year = \app\models\EconomicYear::find()->andWhere(['status' => 1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
$economic_year=\app\models\Year::find()->where(['id'=>$year['economic_year']])->one();
//var_dump($economic_year);die;
$eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
$nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
?>
<style>
#find{
    background-color:red;
    color:white;
    margin-top:3.2em;
    margin-left:3em;

}
.payment-chori-form{
    margin-top:2em;
}
</style>
<div class="payment-chori-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-12">
        
        <div class="col-md-12">

            <?= $form->field($model, 'fk_economic_year')->hiddenInput(['maxlength' => true, 'readonly' => true, 'value' => $economic_year['economic_year']])->label(false) ?>
            <span style="font-weight:bold;">आर्थिक वर्ष: </span><?= 
            str_replace($eng_date, $nepali_date, $economic_year['economic_year']);
            ?>
        </div>
        <div class="col-sm-4">
        <br>
            <!-- <?= $form->field($model, 'deposit_method')->dropDownList(['1'=>'मासीक','2'=>'चौमासिक'], ['id' => 'method', 'prompt' => 'छान्नुहोस्','onchange'=>'hide()']); ?> -->
            <?= $form->field($model, 'deposit_method')->dropDownList(['2'=>'चौमासिक'], ['id' => 'method']); ?>
        </div>
        <div class="col-md-4" style="display:none;" id="month">
            <br>
            <?= $form->field($model, 'fk_month')->dropDownList($month, ['id' => 'month_name', 'prompt' => 'छान्नुहोस्']); ?>

        </div>
        <div class="col-md-4" style="" id="month-method">
            <br>
            <?= $form->field($model, 'month_method')->dropDownList(['1'=>'प्रथम','2'=>'दोस्रो','3'=>'तेस्रो'], ['id' => 'month_method_value', 'prompt' => 'छान्नुहोस्'])->label('चौमासिक'); ?>

        </div>
        
        <?php echo Html::button('Search',['name' => 'btn3','class'=>'btn','id'=>'find','onclick'=>"myfun($economic_year->id)"]); ?>    
    
    </div>

    <?php ActiveForm::end(); ?>

    
</div>

<script>
// var target_data =document.getElementById('target');
//        target_data.hide();
    function myfun(year) {
        var method=document.getElementById("method").value;
        if(method==1){
        var month = document.getElementById("month_name").value;
        }else{
            var month=document.getElementById("month_method_value").value;
        }
        //console.log(year);
        //alert(month);
        // console.log(month);
        $.post('index.php?r=payment-chori/multi&month=' + month + '&year=' + year +'&method='+method);
        
    }
    function hide(){
        var method=document.getElementById("method").value;
        var month=document.getElementById("month");
        var month_method=document.getElementById("month-method");
        if(method==1){
            $(month).show();
            $(month_method).hide();
        }
        else if(method==2){
            $(month_method).show();
            $(month).hide();
        }
        else{
            $(month).hide();
            $(month_method).hide();
        }
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
