<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PaymentChori */

$this->title = 'छोरी मासिक रकम ';
$this->params['breadcrumbs'][] = ['label' => 'भुक्तानी', 'url' => ['payment-chori/multifind']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-chori-create">

    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('multiple_form', [
        'model' => $model,
        'account_opened' => $account_opened,
        'multipleChhori' => empty($multipleChhori) ? [new OtherMonthPayment()] : $multipleChhori,
        'models' => $models,
        'pages' => $pages,
        'multi_month'=>$multi_month,
        'final_date'=>$final_date,
    ])
    ?>

</div>
