<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$user_id=yii::$app->user->id;
$user_details=\app\models\Users::findone(['id'=>$user_id]);
$this->title = 'प्रयोगकर्ता';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('सिर्जना गर्नुहोस', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php if($user_details['user_type']==1){ ?>
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

            //'id',
            //'fk_municipal_id',
            // [
            //  'attribute' =>'fk_municipal_id',
            //     'value' =>'municipalName.municipal_nepali'
            // ],
            'name',
            'phone',
            //'position',
            ['attribute'=>'username',
            'label'=>'Username',
            ],
            // 'password',
            [
                  'attribute' =>'user_type',
                  'format' => 'html',
                     'value' =>function($model){
                         if($model->user_type==1){
                             return '<i>Province</i>';
                         }
                         else if($model->user_type==2){
                            return '<i>District</i>';
                        }
                        else{
                            return '<i>Municipal</i>';
                        }
                        
                     },
                     'filter'=>['2'=>'District','3'=>'Municipal'],
                 ],
            // 'authkey',
            //'created_date',
            //'updated_date',

            [   
                'class' => 'yii\grid\ActionColumn',
               'template'=>'{update}{view}' ],
        ],
    ]); ?>
<?php } else{ ?>
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

            //'id',
            //'fk_municipal_id',
            // [
            //  'attribute' =>'fk_municipal_id',
            //     'value' =>'municipalName.municipal_nepali'
            // ],
            'name',
            'phone',
            //'position',
            ['attribute'=>'username',
            'label'=>'Username',
            ],
            // 'password',
            [
                  'attribute' =>'user_type',
                  'format' => 'html',
                     'value' =>function($model){
                         if($model->user_type==1){
                             return '<i>Province</i>';
                         }
                         else if($model->user_type==2){
                            return '<i>District</i>';
                        }
                        else if($model->user_type==3){
                            return '<i>Municipal</i>';
                        }else{
                            return '<i>Superadmin</i>';
                        }
                        
                     },
                    
                 ],
            // 'authkey',
            //'created_date',
            //'updated_date',

            [   
                'class' => 'yii\grid\ActionColumn',
               'template'=>'{update}{view}' ],
        ],
    ]); ?>
    <?php } ?>
</div>
