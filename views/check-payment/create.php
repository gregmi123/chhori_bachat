<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CheckPayment */

$this->title = 'Create Check Payment';
$this->params['breadcrumbs'][] = ['label' => 'Check Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="check-payment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'activeChoriList'=>$activeChoriList,
    ]) ?>

</div>
