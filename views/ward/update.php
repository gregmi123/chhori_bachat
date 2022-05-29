<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ward */

$this->title = 'अपडेट  वडा: ' . $model->ward_name;
$this->params['breadcrumbs'][] = ['label' => 'वडा', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ward_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'अपडेट';
?>
<div class="ward-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
