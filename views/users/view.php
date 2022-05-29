<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'प्रयोगकर्ता', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="users-view">

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
            //'fk_municipal_id',
            'name',
            'phone',
            'position',
            ['attribute'=>'username',
            'label'=>'Username',
            ],
            ['attribute'=>'password',
            'label'=>'Password',
            ],
            // 'password',
            //'authkey',
            // 'created_date',
            //'updated_date',
        ],
    ]) ?>

</div>
