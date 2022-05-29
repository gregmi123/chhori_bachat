<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Year */

$this->title = 'अपडेट: ' . $model->economic_year;
$this->params['breadcrumbs'][] = ['label' => 'वर्ष', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->economic_year, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'अपडेट';
?>
<div class="year-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
