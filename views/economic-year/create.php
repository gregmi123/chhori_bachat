<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EconomicYear */

$this->title = 'सिर्जना गर्नुहोस';
$this->params['breadcrumbs'][] = ['label' => 'आर्थिक वर्ष', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="economic-year-create">

    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
