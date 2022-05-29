<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MoneySet */

$this->title = 'अपडेट भुक्तानी गर्नुपर्ने रकम: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'भुक्तानी गर्नुपर्ने रकम', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'अपडेट';
?>
<div class="money-set-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
