<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
$user_id=yii::$app->user->id;
$user_details=\app\models\Users::findone(['id'=>$user_id]);

if($user_details['user_type']==1){
    $this->params['breadcrumbs'][] = ['label' => 'प्रोफाइल', 'url' => ['profile','id'=>$user_id]];
    $this->params['breadcrumbs'][] = $model->name;
}else{
    $this->params['breadcrumbs'][] = ['label' => 'प्रोफाइल', 'url' => ['profile','id'=>$user_id]];
    $this->params['breadcrumbs'][] = $model->name;
}


?>
<div class="users-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('profile', [
        'model' => $model,
    ]) ?>

</div>
