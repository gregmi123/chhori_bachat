<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CheckPayment */

$this->title = 'Update Check Payment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Check Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="check-payment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
