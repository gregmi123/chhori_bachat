<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MoneySetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Money Sets';
$this->title='भुक्तानी गर्नुपर्ने रकम';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-set-index">

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
            'heading' => '<b style="font-weight:bold;margin-left:40%;">भुक्तानी गर्नु पर्ने कारण</b>',
    
        ],
        'columns' => [
           
            ['class' => 'yii\grid\SerialColumn',
            'header'=>'क्र.स.',
            'options'=>['style'=>'width:5%;']],

           // 'id',
            //'fk_user_id',
            //'fk_municipal_id',
            'initial_payment',
            'previous_payment',
            [
                'attribute' => 'status',
                'label' => ' स्थिति',
                'format' => 'html',
                
                'value' => function($data) {
                    if($data['status']==1){
                        return Html::a('Active',['money-set/status','id'=>$data['id']],['class'=>'btn btn-success']);
                    }
                    else{
                        return Html::a('Inactive',['money-set/status','id'=>$data['id']],['class'=>'btn btn-danger']);
                    }
                }
            ],
            //'created_date',

            [   
                'class' => 'yii\grid\ActionColumn',
               'template'=>'{update}{view}' ],
        ],
    ]); ?>


</div>
