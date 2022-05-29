<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'वडा ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ward-index">

    <p>
        <?= Html::a('सिर्जना गर्नुहोस', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        
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
            'heading' => '<b style="font-weight:bold;margin-left:40%;">वार्ड</b>',
    
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
            'header'=>'क्र.स.',
            'options'=>['style'=>'width:5%;']],

            //'id',
            'ward_name',
            //'created_date',

            [   
                'class' => 'yii\grid\ActionColumn',
               'template'=>'{update}{view}' ],
        ],
    ]); ?>


</div>
