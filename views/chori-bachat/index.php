<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ChoriBachatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'छोरीहरुको सुची ';
$this->params['breadcrumbs'][] = ['label'=>'छोरी बचत फर्म'];
$this->params['breadcrumbs'][] = ['label'=>'तथ्याङ्ग'];
$url = "index.php?r=chori-account-details/create";

$user_id = yii::$app->user->id;
$user_details = app\models\Users::findOne(['id' => $user_id]);

$this->registerJs($this->render('delete_verification.js'), 5);
?>
<style>
</style>
<div class="chori-bachat-index">

    <p>
        <button onclick="myFunction()" class="btn btn-success pull-right" style="margin-left:1em;">खाता खोल्नको लागी अनुरोध गर्नुहोस </button>
    </p>
    <p>
        <?= Html::Button('Delete गर्नको लागी अनुरोध गर्नुहोस', ['class' => 'btn btn-danger pull-right','id'=>'delete',
            'data-toggle'=>'modal',
            'data-target'=>'#exampleModal',
            'name'=>'btn',
        ]); ?>    
    </p>
    <p>
        
     <?= Html::a('फर्म सिर्जना गर्नुहोस', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

        
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'toolbar' =>  [
        
            '{toggleData}'
        ],
        'exportConfig' => [
            //GridView::HTML => ['label' => 'HTML'],
            // GridView::CSV => ['label' => 'CSV'],
            // GridView::TEXT  => ['label' => 'Text'],
            GridView::EXCEL => ['label' => 'Excel','filename'=>'Chhori'],
            GridView::PDF => ['label' => 'PDF','filename'=>'Chhori'],
            // GridView::JSON => ['label' => 'JSON'],
        ],
        'rowOptions'=>function($model){
            if($model->status == 0){
                return ['style' => 'background-color:#F4A460;color:white;'];
            }
            if($model->status == 1){
                return ['style'=>'background-color:	#800080;color:white;'];
            }
            if($model->status == 2){
                return ['class' => 'info'];
            }
            if($model->status == 3){
                return ['style'=>'background-color:#696969;color:white;'];
            }
            if($model->status == 4){
                return ['style'=>'background-color:#D4AC0D;color:white;'];
            }
            if($model->status == 6){
                return ['style' => 'background-color:#5cb85c;color:white;'];
            }
            if($model->status == 7){
                return ['style' => 'background-color:#E52009;color:white;'];
            }
            else{
                return ['style'=>'background-color:#2B547E;color:white;'];
            }
        },
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
            //'father_citizenship_no',
            //'mother_name',
            //'mother_citizenship_no',
            //'take_care_person',
            //'take_care_citizenship_no',
            //'fk_per_province',
            //'fk_per_district',
            //'fk_per_municipal',
            // ['attribute'=>'fk_ward',
            // 'value'=>function($data){
            //     $ward=\app\models\Ward::findone(['id'=>$data['fk_ward']]);
            //     $eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
            //     $nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
            //     return(str_replace($eng_date, $nepali_date, $ward['ward_name']));
            // }
            // ],
            'tole_name',
            //'chori_birth_certificate_doc',
            //'parents_citizenship_doc',
            //'sastha_certificate',
            //'hospital_certificate',
            //'status',
            // 'created_date',
            ['attribute'=>'created_date',
            'value'=>function($data){
                $eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                $nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
                return(str_replace($eng_date, $nepali_date, $data->created_date));
            }],
            [
                'attribute' => 'status',
                'label' => 'कागजात प्रमाणित',
                'format' => 'html',
                'filter' =>['1'=>'Verified','0'=>'Not Verified','2'=>'Account Opened','3'=>'Account Request','5'=>'Initial Deposited','6'=>'Withdrawal','7'=>'Closed account'],
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
            [
    'class' => 'yii\grid\CheckboxColumn',
    'contentOptions'=>[ 'style'=>'width: 50px;background-color:white;'],
    'name' => 'checked',
    'checkboxOptions'=> function($model, $key, $index, $column) {
        
     return ["value" => $model->id];
    
    }
],
            [
                
                'class' => 'yii\grid\ActionColumn',
                // 'header'=>'कार्यहरू',
                // 'headerOptions'=>['style'=>'color:#337ab7;'],
                'template' => '{view}',
                'options'=>['style'=>'width:80px;'],
                'contentOptions'=>['style'=>'background-color:white;']
                
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
    'bordered' => true,
    'striped' => false,
    'condensed' => false,
    'responsive' => true,
    'hover' => true,
    // 'showPageSummary' => true,
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<b style="font-weight:bold;margin-left:45%;">छोरीहरुको सुची</b>',

    ],
    ]); ?>

    <!--  -->
    </div>
<script>
function myFunction(){
    confirm("Are you sure ?");
    var keys = $('#w0').yiiGridView('getSelectedRows');
    if(keys.length >0){
        $.post('index.php?r=chori-bachat/check-status&ids='+keys,function(data){
            if(!data){
                alert("क्र्पया Verified भएका छोरीहरु मात्र छान्नुहोस् ... !");
            }else{
                window.location = 'index.php?r=chori-bachat/bank-docs&ids='+keys;
            }
        });
       

    }else{
        alert('Select at least one chhori !');
    }
    console.log(keys);
}

function deleteChhori(){
    var keys = $('#w0').yiiGridView('getSelectedRows');
    if(keys.length >0){
                window.location = 'index.php?r=chori-bachat/delete-list&ids='+keys;

    }else{
        alert('Select at least one chhori !');
    }
    console.log(keys);
}
</script>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Please Enter PIN Code</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <input type="hidden" value="<?= $user_details['pin']?>" id="municipal_id">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">PIN Code:</label>
            <input type="password" class="form-control" value="" placeholder="Enter PIN Code" id="typed_pin">
          </div>
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <?= Html::SubmitButton('Confirm',['class'=>'btn btn-primary','name'=>'confirm1','id'=>'btn_submit']); ?> -->
        <button type="button" class="btn btn-primary" name="confirm1" id="btn_submit">Confirm</button>
      </div>
    </div>
  </div>
</div>