<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EconomicYear */

$this->title = $model->year($model->economic_year);
$this->params['breadcrumbs'][] = ['label' => 'आर्थिक वर्ष ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="economic-year-view">

<h1><?= Html::encode($this->title) ?></h1>

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
            //'id',
            ['attribute'=>'economic_year',
            'value'=>function($model){
                return $model->year($model->economic_year);
            }
            ],
            //'fk_user_id',
            //'fk_municipal_id',
            [
                'attribute' => 'status',
                'label' => ' स्थिति',
                'format' => 'html',
                
                'value' => function($model) {
                    if ($model->status == 0) {
                        return '<i class="danger" style="color:red;">Inactive</i>';
                    } 
                    else{
                        return '<i class="success"style="color:green;">Active</i>'; 
                    }
                }
            ],
            //'created_date',
        ],
    ]) ?>

</div>
