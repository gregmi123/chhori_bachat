<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dismiss */
if($model->type==2){
$this->title = 'अपडेट खाता खारेज गर्ने कारण: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'खाता खारेज गर्ने कारण', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'अपडेट';
}else{
    $this->title = 'अपडेट जम्मा रकम निकाल्ने कारण: ' . $model->name;
    $this->params['breadcrumbs'][] = ['label' => 'जम्मा रकम निकाल्ने कारण', 'url' => ['deposit-index']];
    $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = 'अपडेट';
}
?>
<div class="dismiss-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
