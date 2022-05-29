<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EconomicYearSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'आर्थिक वर्ष';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="economic-year-index">

    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('सिर्जना गर्नुहोस ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
        'pjax' => true,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'floatHeader' => true,
        // 'showPageSummary' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
            'header'=>'क्र.स.',
            'options'=>['style'=>'width:5%;']],

            //'id',
            ['attribute'=>'economic_year',
            'value'=>function($model){
                return($model->year($model->economic_year));
            }
            ],
            //'fk_user_id',
            //'fk_municipal_id',
            //'status',
            [
                'attribute' => 'status',
                'label' => ' स्थिति',
                'format' => 'html',
                
                'value' => function($data) {
                    if($data['status']==1){
                        return Html::a('Active',['economic-year/status','id'=>$data['id']],['class'=>'btn btn-success']);
                    }
                    else{
                        return Html::a('Inactive',['economic-year/status','id'=>$data['id']],['class'=>'btn btn-danger']);
                    }
                }
            ],
            //'created_date',

            ['class' => 'yii\grid\ActionColumn'
                ,'template'=>'{update}{view}'],
        ],
    ]); ?>


</div>
