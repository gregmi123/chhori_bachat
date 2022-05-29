<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\YearSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'वर्ष';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="year-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('सिर्जना गर्नुहोस', ['create'], ['class' => 'btn btn-success']) ?>
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
        'pjax' => false,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'floatHeader' => false,
        // 'showPageSummary' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
            'header'=>'क्र.स.',
            'options'=>['style'=>'width:5%;']],

         
            'economic_year',
            [
                'attribute' => 'status',
                'label' => ' स्थिति',
                'format' => 'html',
                
                'value' => function($data) {
                    if($data['status']==1){
                        return Html::a('Active',['year/inactive','id'=>$data['id']],['class'=>'btn btn-success']);
                    }
                    else{
                        return Html::a('Inactive',['year/active','id'=>$data['id']],['class'=>'btn btn-danger']);
                    }
                }
            ],

            ['class' => 'yii\grid\ActionColumn',
            'template'=>'{update}{view}'],
        ],
    ]); ?>


</div>
