<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ApangataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'अशक्तता';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apangata-index">

    <h1 style="text-align: center"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('सिर्जना गर्नुहोस', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

  
            'name',
         
            //'fk_municipal_id',
            //'created_date',
          

            [   
                'class' => 'yii\grid\ActionColumn',
               'template'=>'{update}{view}' ],
        ],
    ]); ?>


</div>
