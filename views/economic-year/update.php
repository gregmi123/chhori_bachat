<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EconomicYear */

$this->title = 'अपडेट आर्थिक वर्ष: ' . $model->year($model->economic_year);
$this->params['breadcrumbs'][] = ['label' => 'आर्थिक वर्ष', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->year($model->economic_year), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'अपडेट';
?>
<div class="economic-year-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
