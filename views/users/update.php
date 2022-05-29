<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
$user_id=yii::$app->user->id;
$user_details=\app\models\Users::findone(['id'=>$user_id]);

if($user_details['user_type']==1){
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'प्रयोगकर्ता', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'अपडेट प्रयोगकर्ता: ' .$this->title;
}
else if($user_details['user_type']==2){
    $this->title = $model->name;
    $this->params['breadcrumbs'][] = ['label' => 'प्रयोगकर्ता', 'url' => ['index']];
    $this->params['breadcrumbs'][] = 'अपडेट प्रयोगकर्ता: ' .$this->title;
    }
else{
    $this->params['breadcrumbs'][] = ['label' => 'प्रोफाइल', 'url' => ['profile','id'=>$user_id]];
    $this->params['breadcrumbs'][] = $model->name;
}


?>
<div class="users-update">

    <h1 style="text-align:center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formupdate', [
        'model' => $model,
    ]) ?>

</div>
