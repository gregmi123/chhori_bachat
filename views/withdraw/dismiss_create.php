<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Withdraw */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'खाता खारिज गर्नको लागी', 'url' => ['chori-account-details/dismiss']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('dismiss', [
        'model' => $model,
    ]) ?>

</div>
