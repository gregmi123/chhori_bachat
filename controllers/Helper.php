<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

/**
 * Description of Helper
 *
 * @author kashi
 */
class Helper {
    //put your code here
     public function actionNepaliDate() {
        date_default_timezone_set('Asia/Kathmandu');
        $nepdate = new NepaliCalender();
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $today = $nepdate->eng_to_nep($year, $month, $day);
//print_r($cal->nep_to_eng(2065,8,8));
        //$nepali_date1 = $today['year'] . '-' . $today['month'] . '-' . $today['date'];

        $nepali_date2 = strlen($today['month']);
        $nepali_date1 = strlen($today['date']);
        if ($nepali_date2 == 1) {
            $month1 = '0' . $today['month'];
        } else {
            $month1 = $today['month'];
        }
        if ($nepali_date1 == 1) {
            $date1 = '0' . $today['date'];
        } else {
            $date1 = $today['date'];
        }
        $nepali_today = $today['year'] . '-' . $month1 . '-' . $date1;
        return $nepali_today;
    }
public function getUserId(){
    $user = \yii::$app->user->id;
    return $user;
}
 Public function getOrganization(){
     $user= \yii::$app->user->id;
     $user_details = \app\models\Users::findOne(['id'=>$user]);
     
     return $user_details->fk_municipal_id;
 }

    
}
