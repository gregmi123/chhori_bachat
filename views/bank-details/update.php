<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BankDetails */

$this->title = 'अपडेट बैंक: ' . $model->bank_name;
$this->params['breadcrumbs'][] = ['label' => 'बैंक', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bank_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'अपडेट';
?>
<div class="bank-details-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
