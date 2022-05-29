<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ChoriBachatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'छोरी बचत ';
$this->params['breadcrumbs'][] =['label'=>'खाताको लागि अनुरोधको सुची'];
$url = "index.php?r=chori-account-details/create";


?>
<style>
</style>
<div class="chori-bachat-index">

    <p>
        <button onclick="myFunction()" class="btn btn-success pull-right">खाता खोल्नको लागी बैंकलाइ अनुरोधको पत्र </button>
    </p>
   <br>
   <br>

    <?php 
    
    // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'toolbar'=>['{toggleData}'],
        'exportConfig' => [
            //GridView::HTML => ['label' => 'HTML'],
            // GridView::CSV => ['label' => 'CSV'],
            // GridView::TEXT  => ['label' => 'Text'],
            GridView::EXCEL => ['label' => 'Excel','filename'=>'Chhori'],
            GridView::PDF => ['label' => 'PDF','filename'=>'Chhori'],
            // GridView::JSON => ['label' => 'JSON'],
        ],
    'bordered' => true,
    'striped' => false,
    'condensed' => false,
    'responsive' => true,
    'hover' => true,
    // 'showPageSummary' => true,
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<b style="font-weight:bold;margin-left:45%;">छोरी बचत</b>',

    ],
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn',
            'header'=>'क्र.स.',
            'contentOptions'=>['style'=>'background-color:white;color:black;']
        ],
            

            //'id',
            //'fk_user_id',
            //'image',
             
            
           // 'camera_image',
           // 'thumb_left',
            //'thumb_right',
            //'guardian_image',
            'unique_id',
            'name',
            ['attribute'=>'dob',
            'value'=>function($data){
                $eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                $nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
                return(str_replace($eng_date, $nepali_date, $data->dob));
            }],
            //'birth_certificate_no',
            //'birth_certificate_date',
            'father_name',
            //'father_citizenship_no',
            //'mother_name',
            //'mother_citizenship_no',
            //'take_care_person',
            //'take_care_citizenship_no',
            //'fk_per_province',
            //'fk_per_district',
            //'fk_per_municipal',
            //'fk_ward',
            'tole_name',
            ['attribute'=>'created_date',
            'value'=>function($data){
                $eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                $nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
                return(str_replace($eng_date, $nepali_date, $data->created_date));
            }],
            //'chori_birth_certificate_doc',
            //'parents_citizenship_doc',
            //'sastha_certificate',
            //'hospital_certificate',
            //'status',
            [
                'attribute' => 'status',
                'label' => 'कागजात प्रमाणित',
                'format' => 'html',
                'filter' =>'',
                'value' => function($model) {
                    if ($model->status == 0) {
                        return '<i >Not Verified</i>';
                    } if($model->status==1) {
                        return '<i >Verified</i>';
                    }if($model->status==2){
                       return '<i>Account opened</i>'; 
                    }if($model->status==3){
                       return '<i>Account requested</i>'; 
                    }
                   if($model->status==4){
                        return '<i>Account not verified</i>';
                    }
                    if($model->status==5){
                        return '<i>Initial Deposited</i>';
                    }
                    if($model->status==6){
                        return '<i>Withdrawal</i>';
                    }
                    if($model->status==7){
                        return '<i >Closed Account</i>';
                    }
                    else{
                        return '<i>Account opened</i>'; 
                    }
                }
            ],
                    
            //'created_date',
            [
    'class' => 'yii\grid\CheckboxColumn',
    'contentOptions'=>[ 'style'=>'width: 50px;background-color:white;'],
    'name' => 'checked',
    'checkboxOptions'=> function($model, $key, $index, $column) {
     return ["value" => $model->id];
    }
],
//             [
                
//                 'class' => 'yii\grid\ActionColumn',
//                 'header'=>'कार्यहरू',
//                 'headerOptions'=>['style'=>'color:#337ab7;'],
//                 'template' => '{update}{view}',
//                 'options'=>['style'=>'width:80px;'],
//                 'contentOptions'=>['style'=>'background-color:white;']
                
// //              'buttons'=>[
// //                'unique' =>function($url ,$model){
// //                        if($model->status==1){
// //                            return Html::a('<span class="glyphicon glyphicon-copyright-mark"></span>',['unique-chori','id'=>$model->id],['title'=> yii::t('yii', 'Create unique id'),]);
// //                        }
// //                        
// //                }
// //            ],
//             ],
        ],
    ]); ?>

    <?php
    \yii\widgets\LinkPager::widget([
        'pagination'=>$dataProvider->pagination,
    ]); ?>
    </div>
<script>
function myFunction(){
    var keys = $('#w0').yiiGridView('getSelectedRows');
    if(keys.length >0){
        window.location = 'index.php?r=chori-bachat/bank-docs&ids='+keys;
    }else{
        alert('Select at least one chhori !');
    }
    console.log(keys);
}
</script>