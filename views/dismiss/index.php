<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DismissSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'खाता खारेज गर्ने कारण';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dismiss-index">

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
            'heading' => '<b style="font-weight:bold;margin-left:40%;">खाता खारेज गर्ने कारण</b>',
    
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
            'header'=>'क्र.स.',
            'options'=>['style'=>'width:5%;']],

            // 'id',
             'name',
            // 'fk_user_id',
            // 'fk_municipal_id',
            // 'created_date',

            ['class' => 'yii\grid\ActionColumn',
            'template'=>'{update}{view}',],
        ],
    ]); ?>


</div>
