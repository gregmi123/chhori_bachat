<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Caste */

$this->title = 'सिर्जना गर्नुहोस';
$this->params['breadcrumbs'][] = ['label' => 'जाति', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="caste-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
