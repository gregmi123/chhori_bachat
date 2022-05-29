<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ChoriAccountDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'खाताहरुको सुची';
$this->params['breadcrumbs'][] = ['label'=>'खाता खोलिसकेको विवरण'];
?>
<div class="chori-account-details-index">

    <?php 
    // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php $amount=2000; ?>
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
        'pjax' => false,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'floatHeader' => true,
        // 'showPageSummary' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<b style="font-weight:bold;margin-left:42%;">खाताहरुको सुची</b>',
    
        ],
        'rowOptions'=>function($model){
            if($model['bank_status'] == 4){
                return ['style' => 'background-color:red;'];
            }
            if($model['bank_status'] == 3){
                
                return ['style' => 'background-color:#5cb85c;'];
            }
            else{
                return ['class' => 'info'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
            'header'=>'क्र.स.',
            'contentOptions'=>['style'=>'background-color:white;color:black;']
        ],

            //'id',
            //'chori_unique_id',
            //'fk_chori_bachat',
            [
                'attribute'=>'chori_unique_id',
                'header'=>'छोरीको ID',
                'headerOptions'=>['style'=>'color:#337ab7;'],
               ],
            [
             'attribute'=>'fk_chori_bachat',
             'label'=>'नाम',
             'value'=>function($data){
                 $chori=\app\models\ChoriBachat::findone(['id'=>$data['fk_chori_bachat']]);
                 return $chori['name']." ".$chori['middle_name']." ".$chori['last_name'];
             }
            ],
            //'bank_name',
            [
                'attribute'=>'bank_name',
                'value' =>function($data){
                    $bank_name=\app\models\BankDetails::findone(['id'=>$data['bank_name']]);
                    return $bank_name['bank_name'];
                },
            ],
            'account_no',
            ['attribute'=>'account_open_date',
            'value'=>function($data){
                $eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                $nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
                return(str_replace($eng_date, $nepali_date, $data['account_open_date']));
                
            }
            ],
            //  'remarks',
            //'fk_user_id',
            //'created_date',
            
            ['class' => 'yii\grid\ActionColumn',
                // 'header'=>'कार्य',
                // 'headerOptions'=>['style'=>'color:#337ab7;'],
                'template' => '{view}',
                'options'=>['style'=>'width:80px;','hiddenFromExport' => true,],
                'contentOptions'=>['style'=>'background-color:white;color:black;'],
                
                
                ],
        ],
    ]); ?>
    <?php
    \yii\widgets\LinkPager::widget([
        'pagination'=>$dataProvider->pagination,
    ]); ?>

</div>
