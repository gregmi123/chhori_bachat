<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Initial */
/* @var $form yii\widgets\ActiveForm */
$user_id=yii::$app->user->id;
$user_details=\app\models\Users::findone(['id'=>$user_id]);
$economic_year=\app\models\EconomicYear::find()->where(['status'=>1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
$submit_year=\app\models\Year::findone(['id'=>$economic_year['economic_year']]);
$initial=\app\models\Initial::find()->where(['fk_year'=>$economic_year['economic_year']])->andWhere(['fk_province_id'=>$user_details['fk_province_id']])->andWhere(['fk_user'=>$user_id])->orderBy(['id'=>SORT_DESC])->all();
$eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
$nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');
?>
<style>
    th,td{
        text-align:center;
    }
</style>
<div class="initial-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-12">
        
        <div class="col-md-12" style="font-weight:bold;">
            <span>आर्थिक वर्ष: </span><?= 
            str_replace($eng_date, $nepali_date, $submit_year['economic_year']);
            ?>
        </div>
        <div class="col-sm-12" style="height:600px;overflow-y:scroll;">
        <hr style="border: 1px solid black;border-bottom:0px;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width:10%;">
                        क्र.स
                    </th>
                    <th style="width:30%;">
                        बैंक
                    </th>
                    <th style="width:20%;">
                        प्रारम्भिक भुक्तानीको कोड
                    </th>
                    <th style="width:10%;">
                        पेश गरेको मिति
                    </th>
                    <th style="width:15%;">
                        विवरण
                    </th>
                </tr>
                <tbody>
                    
                    <?php 
                    $count=1;
                    foreach($initial as $initial_data){ 
                        $bank=\app\models\BankDetails::findone(['id'=>$initial_data['fk_bank']]);    
                    ?>
                    <tr>
                        <td>
                            <?= $count++; ?>
                        </td>
                        <td>
                            <?= $bank['bank_name'] ?>
                        </td>
                        <td>
                            <?= $initial_data['payment_id'] ?>
                        </td>
                        <td>
                            <?= $initial_data['created_date'] ?>
                        </td>
                        <td>
                            <?= Html::a('Print View',['payment-chori/initial-deposit','initial_id'=>$initial_data['id']],['class'=>'btn btn-danger','id'=>'pview']); ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </thead>

        </table>
        </div>
</div>
    <?php ActiveForm::end(); ?>

</div>
