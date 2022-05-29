<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ChoriAccountDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'खाता खारिज गर्नको लागी';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chori-account-details-index">

   

    <?php 
    // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProviders,
        'filterModel' => $searchModels,
        'toolbar'=>['{toggleData}'],
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
            'heading' => '<b style="font-weight:bold;margin-left:40%;">खाता खारिज गर्नको लागी</b>',
    
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
            'header'=>'क्र.स.',
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
                }
            ],
            'account_no',
           
            ['attribute'=>'account_open_date',
            'value'=>function($data){
                $eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                $nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
                return(str_replace($eng_date, $nepali_date, $data['account_open_date']));
            }],
            //  'remarks',
            //'fk_user_id',
            //'created_date',
            
            ['class' => 'yii\grid\ActionColumn',
            'template'=>'{view}',
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                'title' => Yii::t('app', 'lead-view'),
                    ]);
                }],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url ='index.php?r=withdraw/dismiss-create&id='.$model['id'];
                        return $url;
                    }
                }
 
                
                ],
        ],
    ]); ?>


</div>
