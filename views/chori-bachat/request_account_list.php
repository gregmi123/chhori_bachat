<?php

use yii\helpers\Html;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ChoriBachatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'खाता खोल्न को लागि पठाएको छोरीहरुको सुची ';
$this->params['breadcrumbs'][] = ['label'=>'खाता खोल्न को लागि पठाएको'];
$url = "index.php?r=chori-account-details/create";
?>

<div class="chori-bachat-index">
  
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'toolbar'=>['{toggleData}'],
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        // 'showPageSummary' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<b style="font-weight:bold;margin-left:35%;">खाता खोल्न को लागि पठाएको छोरीहरुको सुची</b>',
    
        ],
        'filterModel' => $searchModel,
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn',
            'header'=>'क्र.स.',
            ],
            

            //'id',
            //'fk_user_id',
            //'image',
             
            
           // 'camera_image',
           // 'thumb_left',
            //'thumb_right',
            //'guardian_image',
            'unique_id',
            ['attribute'=>'name',
            'label'=>'नाम',
            'value'=>function($data){
                return $data['name']." ".$data['middle_name']." ".$data['last_name'];
            }
            ],
            ['attribute'=>'dob',
            'value'=>function($data){
                $eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                $nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
                return(str_replace($eng_date, $nepali_date, $data->dob));
            }],
            //'birth_certificate_no',
            //'birth_certificate_date',
            'father_name',
            ['attribute'=>'created_date',
            'value'=>function($data){
                $eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                $nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
                return(str_replace($eng_date, $nepali_date, $data->created_date));
            }],
            //'father_citizenship_no',
            //'mother_name',
            //'mother_citizenship_no',
            //'take_care_person',
            //'take_care_citizenship_no',
            //'fk_per_province',
            //'fk_per_district',
            //'fk_per_municipal',
            //'fk_ward',
            //'tole_name',
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