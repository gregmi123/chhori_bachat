<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ChoriBachatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'कागजातहरु प्रमाणित भएकोहरु  ';
$this->params['breadcrumbs'][] = $this->title;
$url = "index.php?r=chori-account-details/create";
?>

<div class="chori-bachat-index">

    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
  
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn'],
            

            //'id',
            //'fk_user_id',
            //'image',
        //      [
        //  'attribute'=>'image',
        
        // 'format'=>'html',

        //  'value' => function ($data) {
        //         $url = $data['image'];
        //         return Html::img($url, ['alt'=>'myImage','width'=>'90','height'=>'80']);
        //  }
        //  ],
            
           // 'camera_image',
           // 'thumb_left',
            //'thumb_right',
            //'guardian_image',
            'unique_id',
            'name',
            'dob',
            'birth_certificate_no',
            //'birth_certificate_date',
            'father_name',
            //'father_citizenship_no',
            'mother_name',
            //'mother_citizenship_no',
            //'take_care_person',
            //'take_care_citizenship_no',
            //'fk_per_province',
            //'fk_per_district',
            //'fk_per_municipal',
            //'fk_ward',
            'tole_name',
            //'chori_birth_certificate_doc',
            //'parents_citizenship_doc',
            //'sastha_certificate',
            //'hospital_certificate',
            //'status',
          
            //'created_date',
            
            [
                
                'class' => 'yii\grid\ActionColumn',
                'template' => '{bank}',
                'buttons' =>[
                    'bank' => function($url, $model){
                    if($model->status == 3) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['chhori-info','id'=>$model->id], ['title' => Yii::t('yii', 'Chhori Information'),]);
                    }
                       
                    }],
//              'buttons'=>[
//                'unique' =>function($url ,$model){
//                        if($model->status==1){
//                            return Html::a('<span class="glyphicon glyphicon-copyright-mark"></span>',['unique-chori','id'=>$model->id],['title'=> yii::t('yii', 'Create unique id'),]);
//                        }
//                        
//                }
//            ],
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