<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ChoriAccountDetails */

$this->title = 'खातावाला छोरि';
$this->params['breadcrumbs'][] = ['label' => 'Chori Account Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chori-account-details-create">

    <h1 style="text-align: center"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
