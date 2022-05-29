<?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?> 
        <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
        <table class="table table-bordered" style="display: none;">
            <thead>
                <tr>
                    <th>सी.न.</th>
                    <th>नाम</th>
                    <th>बैंकको नाम </th>
                    <th> खाता न. </th>
                    <th> रकम रु.</th>
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
            <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
            <div class="container-items"><!-- widgetContainer -->
                <?php
                foreach ($multipleChhori as $i => $chhori):
                    $count = 1;
                    foreach ($account_opened as $j => $opened) {
                        //var_dump($opened->id);die;
                        ?>
                        <tbody
                        <?= $form->field($chhori, "[{$j}]fk_chori_bachat")->hiddenInput(['maxlength' => true, 'value' => $opened['id']])->label(false) ?>
                        <?= $form->field($chhori, "[{$j}]fk_bank_details")->hiddenInput(['maxlength' => true, 'value' => $opened['bank_id']])->label(false) ?>
                        <?= $form->field($chhori, "[{$j}]fk_chori_account_details")->hiddenInput(['maxlength' => true, 'value' => $opened['account_id']])->label(false) ?>
                            <tr>

                        <td>
                            <?= $count++; ?>
                        </td>
                        <td>
                            <?= $form->field($chhori, "[{$j}]chhori_name")->textInput(['maxlength' => true, 'readonly' => true, 'value' => $opened['name']])->label(false) ?>
                        </td>
                        <td>
                            <?= $form->field($chhori, "[{$j}]banks_name")->textInput(['maxlength' => true, 'readonly' => true, 'value' => $opened['bank_name']])->label(false) ?>
                        </td>
                        <td>
                            <?= $form->field($chhori, "[{$j}]chhori_account")->textInput(['maxlength' => true, 'readonly' => true, 'value' => $opened['account_no']])->label(false) ?>
                        </td>
                        <td>
                            <?= $form->field($chhori, "[{$j}]amount")->textInput(['maxlength' => true, 'value' => '500'])->label(false) ?>
                        </td>

                        </tr>
                        </tbody>
                        <div class="item "><!-- widgetBody -->

                            <div class="lists">
                                <?php
                                // necessary for update action.
                                if (!$model->isNewRecord) {
                                    echo Html::activeHiddenInput($model, "[{$i}]id");
                                }
                                ?>

                            <?php } ?>
                        <?php endforeach; ?>

                        <?php DynamicFormWidget::end(); ?>
                    </div>
                </div>


        </table>

        <div class="form-group">
            <?= Html::submitButton('पेश गर्नुहोस', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    