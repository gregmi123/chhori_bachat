<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentChoriSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'भुक्तानी';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-chori-index">

    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('सिर्जना गर्नुहोस', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'post_date',
            //'fk_chori_bachat',
            [
                'attribute' => 'fk_chori_bachat',
                'value' =>'choriName.name',
            ],
            //'fk_bank_details',
            [
                'attribute' =>'fk_bank_details',
                'value' =>'bankName.bank_name'
            ],
            [
              'attribute' =>'fk_chori_account_details',
                'value'=>'accountNo.account_no',
            ],
            'amount',
            //'fk_user_id',
            //'fk_municipal',
            //'created_date',
            //'status',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{update}'],
        ],
    ]); ?>


</div>
