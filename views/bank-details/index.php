<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BankDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'बैंक';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-details-index">

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
        'floatHeader' => true,
        // 'showPageSummary' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<b style="font-weight:bold;margin-left:45%;">बैंक</b>',
    
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
            'header'=>'क्र.स.',
            'options'=>['style'=>'width:5%;']],

            //'id',
            'bank_name',
            //'fk_user_id',
            //'created_date',
            [
                'attribute' => 'status',
                'label' => ' स्थिति',
                'format' => 'html',
                
                'value' => function($data) {
                    if($data['status']==1){
                        return Html::a('Active',['bank-details/status','id'=>$data['id']],['class'=>'btn btn-success']);
                    }
                    else{
                        return Html::a('Inactive',['bank-details/status','id'=>$data['id']],['class'=>'btn btn-danger']);
                    }
                }
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' =>'{update}{view}'],
        ],
    ]); ?>


</div>
