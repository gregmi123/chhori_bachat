<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MoneySet */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'भुक्तानी गर्नुपर्ने रकम', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="money-set-view">

    

    <p>
        <?= Html::a('अपडेट', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <!-- Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> -->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            //'fk_user_id',
            //'fk_municipal_id',
            'initial_payment',
            'previous_payment',
            // [
            //     'attribute' => 'status',
            //     'label' => ' स्थिति',
            //     'format' => 'html',
                
            //     'value' => function($model) {
            //         if ($model->status == 0) {
            //             return '<i class="danger" style="color:red;">Inactive</i>';
            //         } 
            //         else{
            //             return '<i class="success"style="color:green;">Active</i>'; 
            //         }
            //     }
            // ],
            //'created_date',
        ],
    ]) ?>

</div>
