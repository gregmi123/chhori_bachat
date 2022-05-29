<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Caste */

$this->title = 'अपडेट जाति: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'जाति', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'अपडेट';
?>
<div class="caste-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
