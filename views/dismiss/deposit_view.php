<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Dismiss */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'जम्मा रकम निकाल्ने कारण', 'url' => ['deposit-index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="dismiss-view">

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
            // 'id',
            'name',
            // 'fk_user_id',
            // 'fk_municipal_id',
            // 'created_date',
        ],
    ]) ?>

</div>
