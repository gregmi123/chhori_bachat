<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$message=Yii::$app->session->getFlash('message');

?>


<?php $form=Activeform::begin(['options'=>['enctype'=>'multipart/form-data']])?>

<div class="row" style="border:1px solid black;margin-top:1em;margin-right:1em;">
    <div class="col-sm-8" style="padding:30px 30px 0px 30px;">
        <?= $form->field($model,'file_upload')->fileInput() ?>
        <?= Html::SubmitButton('अपलोड',['class'=>'btn btn-success']) ?>
        <?php if($message){
            echo '<p style="color:red;">'.$message.'</p>';
        } ?>
    </div>
    <div class="col-sm-4" style="padding:30px 30px 30px 30px;">
        <h5 style="text-decoration:underline;font-weight:bold;">Demo Excel format:</h5>
        <a href="sample_excel/chori_bachat.xlsx" download ><?= Html::img('images/excel.png',['width'=>'100','height'=>100]) ?><br>Click to download</a>
    </div>
</div>


<?php Activeform::end() ?>