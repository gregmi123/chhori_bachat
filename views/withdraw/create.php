<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Withdraw */
$user_id = yii::$app->user->id;
$user_details = app\models\Users::findOne(['id' => $user_id]);
$active_year=\app\models\EconomicYear::find()->where(['fk_province_id' => $user_details->fk_province_id])->andWhere(['status'=>1])->one();
$chori_acc_details=\app\models\ChoriAccountDetails::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['id'=>$id])->one();
$chori_bachat=\app\models\ChoriBachat::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['id'=>$chori_acc_details['fk_chori_bachat']])->one();

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'जम्मा रकम निकाल्नको लागी', 'url' => ['chori-account-details/withdraw']];
$this->params['breadcrumbs'][] = ['label' =>$chori_bachat['name']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
