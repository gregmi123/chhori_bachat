<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Apangata */

$this->title = 'अपडेट अशक्तता: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'अशक्तता', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'अपडेट';
?>
<div class="apangata-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
