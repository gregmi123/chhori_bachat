<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ChoriBachat */

$this->title = 'छोरी बचत फर्म ';
$this->params['breadcrumbs'][] = ['label' => 'छोरी बचत', 'url' => ['index']];
$this->params['breadcrumbs'][] ='सिर्जना गर्नुहोस';
?>
<div class="chori-bachat-create">

    <h1 style="text-align: center"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'mes'=>$mes,
    ]) ?>

</div>
