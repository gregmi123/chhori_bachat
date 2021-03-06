<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ward */

$this->title = $model->ward_name;
$this->params['breadcrumbs'][] = ['label' => 'वडा', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ward-view">

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
            'ward_name',
            //'created_date',
        ],
    ]) ?>

</div>
