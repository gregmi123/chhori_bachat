<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$user_id = yii::$app->user->id;
$message = Yii::$app->session->getFlash('message');
$user_details = app\models\Users::findOne(['id' => $user_id]);
$check=\app\models\OtherMonthPayment::find()
                    ->where(['fk_user_id' => $user_id])
                    ->andWhere(['fk_municipal' => $user_details['fk_municipal_id']])
                    ->andWhere(['fk_province_id'=>$user_details['fk_province_id']])
                    ->andWhere(['fk_year' => $year])
                    ->andWhere(['fk_month'=>$month])
                    ->one();
$bank=yii\helpers\ArrayHelper::map(\app\models\BankDetails::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->all(),'id','bank_name');
?>

<?php $form = ActiveForm::begin(); ?>
    <div class="row" style="padding:3em;">
    <div class="col-sm-4">
        <?= $form->field($model, 'bank')->widget(Select2::classname(), [
                                    'data' => $bank,
                                    'language' => 'en',
                                    'options' => ['id' => 'bank','value'=>$check['fk_bank']],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('बैंक') ; ?>
                                <?php
        if ($message && $mes==1) {
            echo '<p style="color:red;">' . $message . '</p>';
        }
        ?>
    </div>
    <!-- <div class="col-sm-4">
        <= $form->field($model, 'check_update')->textInput(['maxlength' => true,'id' => 'check','value'=>$check['cheque_no']])->label('चेक न.') ?>
        <php if ($message && $mes==0) {
            echo '<p style="color:red;">' . $message . '</p>';
        }
        ?>
    </div> -->
    <div class="col-sm-12">
        <?= Html::submitButton('पेश गर्नुहोस', ['class' => 'btn btn-success']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>