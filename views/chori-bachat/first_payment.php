<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ChoriBachatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'First deposited ';
$this->params['breadcrumbs'][] = $this->title;
$url = "index.php?r=chori-account-details/create";
?>

<div class="chori-bachat-index">

    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
    <p>
        <button onclick="myFunction()" class="btn btn-primary pull-right">Send</button>
    </p>
   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn'],
            

            //'id',
            //'fk_user_id',
            //'image',
             [
         'attribute'=>'image',
        
        'format'=>'html',

         'value' => function ($data) {
                $url = $data['image'];
                return Html::img($url, ['alt'=>'myImage','width'=>'90','height'=>'80']);
         }
         ],
            
           // 'camera_image',
           // 'thumb_left',
            //'thumb_right',
            //'guardian_image',
            'name',
            'dob',
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
            //'firstPayment',
                 [
                  'attribute'=>'firstPayment',
                     
                 ],
            //'chori_birth_certificate_doc',
            //'parents_citizenship_doc',
            //'sastha_certificate',
            //'hospital_certificate',
            //'status',
            
            //'created_date',
            [
    'class' => 'yii\grid\CheckboxColumn',
    'contentOptions'=>[ 'style'=>'width: 50px'],
    'name' => 'checked',
    'checkboxOptions'=> function($model, $key, $index, $column) {
     return ["value" => $model->id];
    }
],
            
        ],
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