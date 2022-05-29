<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'सिर्जना गर्नुहोस';
$this->params['breadcrumbs'][] = ['label' => 'प्रयोगकर्ता', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'u_id'=>$u_id,
    ]) ?>

</div>
