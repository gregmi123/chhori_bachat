<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
use yii\grid\GridView;

$this->title='pdf_view';
?>

<div class="container">
    <h2><?= Html::encode($this->title) ?></h2>
    
    <table id="print">
        <tr>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
            <th>9</th>
            <th>10</th>
            <th>11</th>
            
        </tr>
        <?php foreach($data as $model) {?>
        <tr>
            <th><?= $model['name'] ?></th>
            <th><?= $model['name']  ?></th>
            <th><?= $model['dob'] ?></th>
            <th><?= $model['age'] ?></th>
            <th><?= $model['fk_caste'] ?></th>
            <th><?= $model['fk_apangata'] ?></th>
            <th><?= $model['created_date'] ?></th>
            <th><?= $model['bank_name'] ?></th>
            <th><?= $model['account_no'] ?></th>
            <th><?= $model['amount'] ?></th>
            
        </tr>
        <?php } ?>
        
    </table>
</div>
