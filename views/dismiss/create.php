<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dismiss */

$this->title = 'सिर्जना गर्नुहोस';
$this->params['breadcrumbs'][] = ['label' => 'खाता खारेज गर्ने कारण', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dismiss-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
