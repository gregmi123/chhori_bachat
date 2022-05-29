<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model app\models\PaymentChori */
/* @var $form yii\widgets\ActiveForm */
$user_id = yii::$app->user->id;
$user_details = app\models\Users::findOne(['id' => $user_id]);
$economic_year=\app\models\EconomicYear::find()->where(['status'=>1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
$chori_name = \app\models\ChoriBachat::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['status' => 2])->andWhere(['fk_economic_year'=>$economic_year['id']])->all();
//var_dump($chori_name);die;
$bank_name = yii\helpers\ArrayHelper::map(\app\models\BankDetails::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->all(), 'id', 'bank_name');
//var_dump($bank_name);die;
$message = Yii::$app->session->getFlash('message');
$this->registerJs($this->render('verification.js'),5);
if(isset($_GET['page'])){
    $page=$_GET['page'];
}
else{
    $page=1;
}
if(isset($_GET['per-page'])){
$per_page=$_GET['per-page'];
}
else{
    $per_page=20;
}

$money=\app\models\MoneySet::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['status'=>1])->one();

$eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
$nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');

if(empty($models)){
    ?>
<h1 style="text-align:center;margin-top:20%;">सबै छोरीहरुको प्रारम्भिक भुक्तान भैसकेको छ |</h1>

<?php
} else{

?>
<style>

    th,td{
        text-align:center;
    }

    #all{
        float:right;
        margin-top:1.7em;
        margin-right:1em;
    }
    #all2{
        float:right;
        margin-top:1.7em;
    }
</style>
<!-- <div style="color: red;">
    <?= Yii::$app->session->getFlash('message'); ?>  
</div> -->
<div class="payment-chori-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form1', 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <!-- <?= Html::Button('All', ['class' => 'btn btn-success','onclick'=>'all()']); ?> -->
    <!-- <?= $form->field($model, 'id')->hiddenInput()->label(false) ?> -->
    <div class="col-sm-12" >
        <div class="col-sm-3">
        <?= $form->field($model,'bank_request')->dropDownList($bank_name, ['id' => 'bank_name','prompt'=>'छान्नुहोस्']) ?>
        <?php
        if ($message && $bank==1) {
            echo '<p style="color:red;">' . $message . '</p>';
        }
        ?>    
        </div>
        <div class="col-sm-3" style="margin-left:1em;">
        <?= $form->field($model,'cheque_no')->textInput(['id' => 'cheque_no']); ?>
        <?php
        if ($message && $bank==0) {
            echo '<p style="color:red;">' . $message . '</p>';
        }
        ?>
        </div>
        <div class="" style="float:right;margin-right:1em;">
        <?= Html::a('<i class="glyphicon glyphicon-resize-small"></i> Page', ['/payment-chori/create'], ['name'=>'all2','id'=>'all2','class'=>'btn btn-default']) ?>
        <?= Html::Button('<i class="glyphicon glyphicon-resize-full"></i> All', ['name' => 'all1','class'=>'btn btn-default','id'=>'all','onclick'=>'page()']) ?>
        </div>
        </div>
        <hr style="border: 1px solid black;">
        <div class="initial" id="initial_table">
    <table class="table table-bordered" id="initial">
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
<!--  -->
        <div class="container-items"><!-- widgetContainer -->
            <?php
           

            foreach ($multipleChhori as $i => $chhori):
                $count = 1;
                $start=0;
                $start=(($page-1)*$per_page)+1;
                foreach ($models as $j => $opened) {
                   
                    
                    
                    $deposit_date=explode('-',$opened['account_open_date']);
                    if((int)$deposit_date[1]>3){
                        $deposit_date[1]=(int)$deposit_date[1]-3;
                    }else{
                        $deposit_date[1]=(int)$deposit_date[1]+9;
                    }
                    $deposit_year=\app\models\Year::findone(['id'=>$opened['fk_year']]);
                    $month=\app\models\Month::find()->where(['id'=>$deposit_date[1]])->one();
                    
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
                    <?= $form->field($chhori, 'chhori_id')->hiddenInput(['maxlength' => true,'readonly'=>true])->label(false) ?>   
                    <?= $opened['unique_id'] ?>
                    </td>
                    <td>
                        <?= $form->field($chhori, "[{$j}]chhori_name")->hiddenInput(['maxlength' => true,'readonly'=>true ,'value' => $opened['name']])->label(false) ?>
                        <?= $opened['name']." ".$opened['middle_name']." ".$opened['last_name'] ?>
                    </td>
                    <td>
                        <?= $form->field($chhori, "[{$j}]banks_name")->hiddenInput(['maxlength' => true,'readonly'=>true, 'value' => $opened['bank_name']])->label(false) ?>
                        <?= $opened['bank_name'] ?>
                    </td>
                    <td>
                        <?= $form->field($chhori, "[{$j}]fk_month")->hiddenInput(['maxlength' => true, 'value' =>$month['id']])->label(false) ?>
                        <span style="color:blue;"><?= str_replace($eng_date, $nepali_date,$deposit_date[0])?></span> को <span style="color:blue;"><?= $month['month_name']?></span> मा खुलेको खाता
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
    
    
    <?php 
        echo \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
            
        ]);
        ?>
    
        </div>
    <div class="form-group">
    <?= Html::Button('पेश गर्नुहोस', ['class' => 'btn btn-success',
            'id'=>'print-div1',
            'data-toggle'=>'modal',
            'data-target'=>'#exampleModal1',
        ]); ?>
    </div>
    <?php
        if ($message && $bank==3) {
            echo '<p style="color:red;">' . $message . '</p>';
        }
        ?>

    <?php ActiveForm::end(); ?>

</div>
<?php }?>
<script>
    function initial(){ 
        // console.log('sss');
        var form = document.getElementById("dynamic-form1");
        form.submit();
        document.getElementById("btn_submit1").onclick = function() {
            this.disabled = true;
}
        
    }
    function page(){
        $.post('index.php?r=payment-chori/table',function(data){
            document.getElementById('initial_table').innerHTML=data;
        });
    }
    
</script>
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Please Enter PIN Code</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <input type="hidden" value="<?= $user_details['pin']?>" id="municipal_id1">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">PIN Code:</label>
            <input type="password" class="form-control" value="" placeholder="Enter PIN Code" id="typed_pin1">
          </div>
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <?= Html::SubmitButton('Confirm',['class'=>'btn btn-primary','name'=>'confirm1','id'=>'btn_submit']); ?> -->
        <button type="button" class="btn btn-primary" name="confirm1" id="btn_submit1">Confirm</button>
      </div>
    </div>
  </div>
</div>