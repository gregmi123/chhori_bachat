<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MoneySet */

//$this->title = 'Create Money Set';
$this->title='सिर्जना गर्नुहोस';
$this->params['breadcrumbs'][] = ['label' => 'भुक्तानी गर्नुपर्ने रकम', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-set-create">

    <h1 style="margin-left:0.8em;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
