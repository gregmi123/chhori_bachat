<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PaymentChori */

$this->title = ' प्रारम्भिक भुक्तान गर्नको लागी ';
$this->params['breadcrumbs'][] = ['label' => 'भुक्तानी'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-chori-create">

    <?php if(!empty($models)){ ?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
    <?php } ?>
    <?=
    $this->render('_form', [
        'model' => $model,
        'account_opened'=>$account_opened,
        'multipleChhori' => $multipleChhori,
        'models' => $models,
        'pages' => $pages,
        'bank'=>$bank,
    ])
    ?>

</div>
