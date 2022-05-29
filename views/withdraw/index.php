<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WithdrawSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Withdraws';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Withdraw', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fk_chori',
            'fk_dismiss',
            'amount',
            'fk_bank',
            //'fk_account',
            //'created_date',
            //'fk_user_id',
            //'fk_municipal',
            //'fk_economic_year',
            //'fk_month',
            //'fk_province',
            //'fk_district',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
