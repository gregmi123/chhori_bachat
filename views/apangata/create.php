<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Apangata */

$this->title = 'सिर्जना गर्नुहोस';
$this->params['breadcrumbs'][] = ['label' => 'अशक्तता', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apangata-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
