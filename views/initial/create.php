<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Initial */

$this->title = 'Create Initial';
$this->params['breadcrumbs'][] = ['label' => 'प्रारम्भिक भुक्तानीको लागी बैंकलाइ अनुरोध', 'url' => ['create']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="initial-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
