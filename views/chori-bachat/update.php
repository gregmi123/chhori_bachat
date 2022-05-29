<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ChoriBachat */

$this->title = 'अपडेट फर्म: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'छोरी बचत', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'अपडेट';
?>
<div class="chori-bachat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('update_form', [
        'model' => $model,
    ]) ?>

</div>
