<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ChoriAccountDetails */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chori Account Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
//var_dump($bankName);die;
?>
<div class="chori-account-details-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php foreach($account_details as $details){ ?>
        
    
    <table class="table table-responsive table-bordered">
        <tr>
            <th>
               छोरी को नाम  
            </th>
            <td>
               <?= $details['name'] ?>
            </td>
        </tr>
        <tr>
           <th>
             बैंक
            </th>
            <td>
              <?= $details['bank_name'] ?>
            </td> 
        </tr>
        <tr>
            <th>
               खाता न. 
            </th>
            <td>
               <?= $details['account_no'] ?>  
            </td>
        </tr>
        <tr>
            <th>
                खाता खुलेको मिति 
            </th>
            <td>
                <?= $details['account_open_date'] ?> 
            </td>
        </tr>
        <thead>
            
            
        
            
   </table>
    <?php } ?>
</div>
