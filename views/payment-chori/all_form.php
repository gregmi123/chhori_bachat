<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
$eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
$nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');

 $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); 
?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>सी.न.</th>
                <th>छोरीको ID</th>
                <th>नाम</th>
                <th>बैंकको नाम </th>
                <th>खाता खुलेको महिना</th>
                <th> खाता न. </th>
                <th>पहिलो महिना रकम रु.</th>
                
            </tr>
        </thead>

        <?php
        $user_id = yii::$app->user->id;
        $user_details = app\models\Users::findOne(['id' => $user_id]);
        $money=\app\models\MoneySet::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['status'=>1])->one();
        DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-items', // required: css class selector
            'widgetItem' => '.item', // required: css class
            'limit' => 4, // the maximum times, an element can be cloned (default 999)
            'min' => 1, // 0 or 1 (default 1)
            'insertButton' => '.add-item', // css class
            'deleteButton' => '.remove-item', // css class
            'model' => $multipleChhori[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'fk_chori_bachat',
                'fk_bank_details',
                'fk_chori_account_details',
                'amount',
            ],
        ]);
        ?>
<!-- <?=$form->field($model, 'id')->hiddenInput()->label(false)?> -->
        <div class="container-items"><!-- widgetContainer -->
            <?php
           

            foreach ($multipleChhori as $i => $chhori):
                $count = 1;
                $start=1;
              //  $start=(($page-1)*$per_page)+1;
                foreach ($models as $j => $opened) {
                   
                    
                    
                    $deposit_date=explode('-',$opened['account_open_date']);
                    if((int)$deposit_date[1]>3){
                        $deposit_date[1]=(int)$deposit_date[1]-3;
                    }else{
                        $deposit_date[1]=(int)$deposit_date[1]+9;
                    }
                    $deposit_year=\app\models\Year::findone(['id'=>$opened['fk_year']]);
                    $month=\app\models\Month::find()->where(['id'=>$deposit_date[1]])->one();
                    //var_dump($opened->id);die;
                    ?>
                    
                    <?= $form->field($chhori, "[{$j}]fk_chori_bachat")->hiddenInput(['maxlength' => true,'value'=>$opened['id']])->label(false) ?>
                    <?= $form->field($chhori, "[{$j}]fk_bank_details")->hiddenInput(['maxlength' => true,'value'=>$opened['bank_id']])->label(false) ?>
                   <?= $form->field($chhori, "[{$j}]fk_chori_account_details")->hiddenInput(['maxlength' => true,'value'=>$opened['account_id']])->label(false) ?>
                   <?= $form->field($chhori, "[{$j}]post_date")->hiddenInput(['maxlength' => true,'value'=>$opened['account_open_date']])->label(false) ?>
                   <?= $form->field($chhori, "[{$j}]created_date")->hiddenInput(['maxlength' => true,'value'=>$opened['account_open_date']])->label(false) ?>
                    <tr>
                    <td>
                    <?= $form->field($chhori, 'serial')->hiddenInput(['maxlength' => true,'readonly'=>true])->label(false) ?>    
                    <?= $start++ ?></td>
                    
                    <td>
                        <?= $form->field($chhori, "[{$j}]chhori_name")->hiddenInput(['maxlength' => true,'readonly'=>true ,'value' => $opened['name']])->label(false) ?>
                        <?= $opened['name'] ?>
                    </td>
                    <td>
                    <?= $form->field($chhori, 'chhori_id')->hiddenInput(['maxlength' => true,'readonly'=>true])->label(false) ?>   
                    <?= $opened['unique_id'] ?>
                    </td>
                    <td>
                        <?= $form->field($chhori, "[{$j}]banks_name")->hiddenInput(['maxlength' => true,'readonly'=>true, 'value' => $opened['bank_name']])->label(false) ?>
                        <?= $opened['bank_name'] ?>
                    </td>
                    <td>
                        <?= $form->field($chhori, "[{$j}]fk_month")->hiddenInput(['maxlength' => true, 'value' =>$month['id']])->label(false) ?>
                        <span style="color:blue;"><?= str_replace($eng_date, $nepali_date,$deposit_year['economic_year'])?></span> को <span style="color:blue;"><?= $month['month_name']?></span> मा खुलेको खाता
                    </td>
                    <td>
                        <?= $form->field($chhori, "[{$j}]chhori_account")->hiddenInput(['maxlength' => true,'readonly'=>true , 'value' => $opened['account_no']])->label(false) ?>
                        <?= $opened['account_no'] ?>
                    </td>
                    <td>
                        <?= $form->field($chhori, "[{$j}]amount")->textInput(['maxlength' => true, 'value' =>$money['initial_payment'],'readOnly'=>true])->label(false) ?>
                    </td>
                    

                    </tr>
                    
                    <div class="item "><!-- widgetBody -->

                        <div class="lists">
                            <?php
                            // necessary for update action.
                            if (!$model->isNewRecord) {
                                echo Html::activeHiddenInput($model, "[{$i}]id");
                            }
                            ?>
                            </div>
            </div>

                        <?php } ?>
                    
                    <?php endforeach; ?>
                        </div>
                    <?php DynamicFormWidget::end(); ?>
                


    </table>
    
    
       
    <?php $form = ActiveForm::end()?>