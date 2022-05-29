<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InitialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Initials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="initial-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Initial', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fk_year',
            'fk_province_id',
            'fk_user',
            'fk_municipal',
            //'fk_district',
            //'created_date',
            //'payment_id',
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
