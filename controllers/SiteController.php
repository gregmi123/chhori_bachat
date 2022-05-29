<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\data\SqlDataProvider;
use yii\data\ActiveDataProvider;
use mpdf;
use kartik\mpdf\Pdf; 

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
   public function actionIndex()
    {
        $user_id=yii::$app->user->id;
        $user_details=\app\models\Users::findone(['id'=>$user_id]);
        
        if($user_details['user_type']==1){
            $this->layout='province';
            
        }
        else if($user_details['user_type']==2){
            $this->layout='district';
        }
        else if($user_details['user_type']==3){
            $this->layout='main';
        }else{
            $this->layout='superadmin';
        }

        $district=\app\models\District::find()->where(['fk_province'=>$user_details['fk_province_id']])->all();
        $municipals=\app\models\Municipals::find()->where(['fk_district'=>$user_details['fk_district_id']])->all();
        if(\yii::$app->user->id ==null){
            return $this->redirect(['site/login']);
        }
        $year = \app\models\EconomicYear::find()->andWhere(['status' => 1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
        if($user_details['user_type']==1){

            $helper = new Helper();
        $user_id=yii::$app->user->id;
        $user_details=\app\models\Users::findone(['id'=>$user_id]);
        $sum=0;
        $finalArray_initial = array();
        $title1=[];
        array_push($title1,"आर्थिक वर्ष","रकम");
        array_push($finalArray_initial,$title1);

        $finalArray_other = array();
        $title2=[];
        array_push($title2,"आर्थिक वर्ष","रकम");
        array_push($finalArray_other,$title2);
       
        
        // $account_details_other = (new \yii\db\Query())
        //     ->select('other_month_payment.id,SUM(other_month_payment.amount) as other_total,district.district_nepali as district_name')
        //     ->from('other_month_payment')
        //     ->where(['other_month_payment.fk_province_id'=>$user_details['fk_province_id']])
        //     ->where(['other_month_payment.fk_year'=>$year['economic_year']])
        //     ->join('LEFT JOIN', 'district', 'district.id=other_month_payment.fk_district_id')
        //     ->groupBy('other_month_payment.fk_district_id')
        //     ->all();
        // $account_details_initial=(new \yii\db\Query())
        //     ->select('payment_chori.id,payment_chori.fk_district_id,SUM(payment_chori.amount) as initial_amount,district.district_nepali as district_name')
        //     ->from('payment_chori')
        //     ->where(['payment_chori.fk_province_id'=>$user_details['fk_province_id']])
        //     ->where(['payment_chori.fk_economic_year'=>$year['economic_year']])
        //     ->join('LEFT JOIN', 'district', 'district.id=payment_chori.fk_district_id')
        //     ->groupBy('payment_chori.fk_district_id')
        //     ->all();
            //var_dump($account_details_other);die;
            // var_dump($account_details_initial);die;
            $account_details_initial=(new \yii\db\Query())
                ->select('SUM(payment_chori.amount) as sum,payment_chori.fk_economic_year')
                ->from('payment_chori')
                ->where(['payment_chori.fk_province_id'=>$user_details['fk_province_id']])
                ->groupBy('payment_chori.fk_economic_year')
                ->all();
            // $account_details_initial=[];
            // var_dump($account_details_initial);die;
            $sum_initial=0;
            $sum_other=0;
            foreach($account_details_initial as $acc){
                $pie1=[];
                $year_name=\app\models\Year::findone(['id'=>$acc['fk_economic_year']]);
                $sum_initial=$sum_initial+$acc['sum'];
                $totalCasteWiseAmount_initial =$acc['sum'];
                array_push($pie1,$year_name['economic_year']);
                array_push($pie1,$totalCasteWiseAmount_initial);
                array_push($finalArray_initial,$pie1);
        
        }
        // $account_details_other=\app\models\OtherMonthPayment::find()->where(['fk_municipal'=>$user_details['fk_municipal_id']])->groupBy('fk_year')->all();
        $account_details_other=(new \yii\db\Query())
                ->select('SUM(other_month_payment.amount) as other_sum,other_month_payment.fk_year')
                ->from('other_month_payment')
                ->where(['other_month_payment.fk_province_id'=>$user_details['fk_province_id']])
                ->groupBy('other_month_payment.fk_year')
                ->all();
        foreach($account_details_other as $other){
            $pie2=[];
            $other_year_name=\app\models\Year::findone(['id'=>$other['fk_year']]);
            $sum_other=$sum_other+$other['other_sum'];
            $totalCasteWiseAmount_other =$other['other_sum'];
            array_push($pie2,$other_year_name['economic_year']);
            array_push($pie2,$totalCasteWiseAmount_other);
            array_push($finalArray_other,$pie2);
    
    }
        //var_dump($finalArray_initial);die;
      $casteWiseChartData_initial = json_encode($finalArray_initial,JSON_NUMERIC_CHECK);
      $casteWiseChartData_other = json_encode($finalArray_other,JSON_NUMERIC_CHECK);

            return $this->render('proindex',[
                'district'=>$district,
                'casteWiseChartData_initial'=>$casteWiseChartData_initial,
                'casteWiseChartData_other'=>$casteWiseChartData_other,
                'sum_initial'=>$sum_initial,
                'sum_other'=>$sum_other,

            ]);
        }
        else if($user_details['user_type']==2){
           

        $helper = new Helper();
        $user_id=yii::$app->user->id;
        $user_details=\app\models\Users::findone(['id'=>$user_id]);
        $sum=0;
        $finalArray_initial = array();
        $title1=[];
        array_push($title1,"आर्थिक वर्ष","रकम");
        array_push($finalArray_initial,$title1);

        $finalArray_other = array();
        $title2=[];
        array_push($title2,"आर्थिक वर्ष","रकम");
        array_push($finalArray_other,$title2);
       
        
        // $account_details_other = (new \yii\db\Query())
        //     ->select('other_month_payment.id,SUM(other_month_payment.amount) as other_total,municipals.municipal_nepali as municipal_name')
        //     ->from('other_month_payment')
        //     ->where(['other_month_payment.fk_district_id'=>$user_details['fk_district_id']])
        //     ->where(['other_month_payment.fk_year'=>$year['economic_year']])
        //     ->join('LEFT JOIN', 'municipals', 'municipals.id=other_month_payment.fk_municipal')
        //     ->groupBy('other_month_payment.fk_municipal')
        //     ->all();
        // $account_details_initial=(new \yii\db\Query())
        //     ->select('payment_chori.id,payment_chori.fk_district_id,SUM(payment_chori.amount) as initial_amount,municipals.municipal_nepali as municipal_name')
        //     ->from('payment_chori')
        //     ->where(['payment_chori.fk_district_id'=>$user_details['fk_district_id']])
        //     ->where(['payment_chori.fk_economic_year'=>$year['economic_year']])
        //     ->join('LEFT JOIN', 'municipals', 'municipals.id=payment_chori.fk_municipal')
        //     ->groupBy('payment_chori.fk_municipal')
        //     ->all();
            //var_dump($account_details_other);die;
            //var_dump($account_details_initial);die;
            $account_details_initial=(new \yii\db\Query())
            ->select('SUM(payment_chori.amount) as sum,payment_chori.fk_economic_year')
            ->from('payment_chori')
            ->where(['payment_chori.fk_district_id'=>$user_details['fk_district_id']])
            ->groupBy('payment_chori.fk_economic_year')
            ->all();
        // $account_details_initial=[];
        // var_dump($account_details_initial);die;
        $sum_initial=0;
        $sum_other=0;
        foreach($account_details_initial as $acc){
            $pie1=[];
            $year_name=\app\models\Year::findone(['id'=>$acc['fk_economic_year']]);
            $sum_initial=$sum_initial+$acc['sum'];
            $totalCasteWiseAmount_initial =$acc['sum'];
            array_push($pie1,$year_name['economic_year']);
            array_push($pie1,$totalCasteWiseAmount_initial);
            array_push($finalArray_initial,$pie1);
    
    }
    // $account_details_other=\app\models\OtherMonthPayment::find()->where(['fk_municipal'=>$user_details['fk_municipal_id']])->groupBy('fk_year')->all();
    $account_details_other=(new \yii\db\Query())
            ->select('SUM(other_month_payment.amount) as other_sum,other_month_payment.fk_year')
            ->from('other_month_payment')
            ->where(['other_month_payment.fk_district_id'=>$user_details['fk_district_id']])
            ->groupBy('other_month_payment.fk_year')
            ->all();
    foreach($account_details_other as $other){
        $pie2=[];
        $other_year_name=\app\models\Year::findone(['id'=>$other['fk_year']]);
        $sum_other=$sum_other+$other['other_sum'];
        $totalCasteWiseAmount_other =$other['other_sum'];
        array_push($pie2,$other_year_name['economic_year']);
        array_push($pie2,$totalCasteWiseAmount_other);
        array_push($finalArray_other,$pie2);

}
        //var_dump($finalArray_initial);die;
      $casteWiseChartData_initial = json_encode($finalArray_initial,JSON_NUMERIC_CHECK);
      $casteWiseChartData_other = json_encode($finalArray_other,JSON_NUMERIC_CHECK);
      $municipals=\app\models\Municipals::find()->where(['fk_district'=>$user_details['fk_district_id']])->all();
       



            return $this->render('disindex',[
                'municipals'=>$municipals,
                'casteWiseChartData_initial'=>$casteWiseChartData_initial,
                'casteWiseChartData_other'=>$casteWiseChartData_other,
                'sum_initial'=>$sum_initial,
                'sum_other'=>$sum_other,
            ]);
        }
        else if($user_details['user_type']==3){
            $helper = new Helper();
        $user_id=yii::$app->user->id;
        $user_details=\app\models\Users::findone(['id'=>$user_id]);
        $sum=0;
        $finalArray_initial = array();
        $title1=[];
        array_push($title1,"आर्थिक वर्ष","रकम");
        array_push($finalArray_initial,$title1);

        $finalArray_other = array();
        $title2=[];
        array_push($title2,"आर्थिक वर्ष","रकम");
        array_push($finalArray_other,$title2);
       
        // $account_details_other=[];
        // $account_details_other = (new \yii\db\Query())
        //     ->select('chori_bachat.id,chori_bachat.fk_caste,other_month_payment.id,SUM(other_month_payment.amount) as other_total,caste.name as caste_name')
        //     ->from('chori_bachat')
        //     ->where(['chori_bachat.fk_per_municipal'=>$user_details['fk_municipal_id']])
        //     ->join('LEFT JOIN','other_month_payment','other_month_payment.fk_chori_bachat=chori_bachat.id')
        //     ->join('LEFT JOIN', 'caste', 'caste.id=chori_bachat.fk_caste')
        //     ->where(['other_month_payment.fk_year'=>$year['economic_year']])
        //     ->groupBy('chori_bachat.fk_caste')
        //     ->all();
        // //var_dump($account_details_other);die;
        // $account_details_initial=(new \yii\db\Query())
        //     ->select('chori_bachat.id,chori_bachat.fk_apangata,payment_chori.id,payment_chori.fk_district_id,SUM(payment_chori.amount) as initial_amount,caste.name as caste_name')
        //     ->from('chori_bachat')
        //     ->where(['chori_bachat.fk_per_municipal'=>$user_details['fk_municipal_id']])
        //     ->join('LEFT JOIN','payment_chori','payment_chori.fk_chori_bachat=chori_bachat.id')
        //     ->join('LEFT JOIN', 'caste', 'caste.id=chori_bachat.fk_caste')
        //     ->where(['payment_chori.fk_economic_year'=>$year['economic_year']])
        //     ->groupBy('chori_bachat.fk_caste')
        //     ->all();
        // $account_details_initial=(new \yii\db\Query())
        //     ->select('chori_bachat.id,chori_bachat.fk_apangata,payment_chori.id,payment_chori.fk_district_id,SUM(payment_chori.amount) as initial_amount,apangata.name as apangata_name')
        //     ->from('chori_bachat')
        //     ->where(['chori_bachat.fk_per_municipal'=>$user_details['fk_municipal_id']])
        //     ->join('LEFT JOIN','payment_chori','payment_chori.fk_chori_bachat=chori_bachat.id')
        //     ->join('LEFT JOIN', 'apangata', 'apangata.id=chori_bachat.fk_apangata')
        //     ->groupBy('chori_bachat.fk_apangata')
        //     ->all();
            //var_dump($account_details_other);die;
            //var_dump($account_details_initial);die;
            $account_details_initial=(new \yii\db\Query())
                ->select('SUM(payment_chori.amount) as sum,payment_chori.fk_economic_year')
                ->from('payment_chori')
                ->where(['payment_chori.fk_user_id'=>$user_details['id']])
                ->groupBy('payment_chori.fk_economic_year')
                ->all();
            // $account_details_initial=[];
            // var_dump($account_details_initial);die;
            $sum_initial=0;
            $sum_other=0;
            foreach($account_details_initial as $acc){
                $pie1=[];
                $year_name=\app\models\Year::findone(['id'=>$acc['fk_economic_year']]);
                $sum_initial=$sum_initial+$acc['sum'];
                $totalCasteWiseAmount_initial =$acc['sum'];
                array_push($pie1,$year_name['economic_year']);
                array_push($pie1,$totalCasteWiseAmount_initial);
                array_push($finalArray_initial,$pie1);
        
        }
        // $account_details_other=\app\models\OtherMonthPayment::find()->where(['fk_municipal'=>$user_details['fk_municipal_id']])->groupBy('fk_year')->all();
        $account_details_other=(new \yii\db\Query())
                ->select('SUM(other_month_payment.amount) as other_sum,other_month_payment.fk_year')
                ->from('other_month_payment')
                ->where(['other_month_payment.fk_user_id'=>$user_details['id']])
                ->groupBy('other_month_payment.fk_year')
                ->all();
        foreach($account_details_other as $other){
            $pie2=[];
            $other_year_name=\app\models\Year::findone(['id'=>$other['fk_year']]);
            $sum_other=$sum_other+$other['other_sum'];
            $totalCasteWiseAmount_other =$other['other_sum'];
            array_push($pie2,$other_year_name['economic_year']);
            array_push($pie2,$totalCasteWiseAmount_other);
            array_push($finalArray_other,$pie2);
    
    }
        //var_dump($finalArray_initial);die;
      $casteWiseChartData_initial = json_encode($finalArray_initial,JSON_NUMERIC_CHECK);
      $casteWiseChartData_other = json_encode($finalArray_other,JSON_NUMERIC_CHECK);
   
       



            return $this->render('index',[
            
                'casteWiseChartData_initial'=>$casteWiseChartData_initial,
                'casteWiseChartData_other'=>$casteWiseChartData_other,
                'sum_initial'=>$sum_initial,
                'sum_other'=>$sum_other,
            ]);
        }
        else{
            return $this->render('superadmin');
        }
        
    }
    public function actionPromunicipal($dis_id){
        $user_id=yii::$app->user->id;
        $user_details=\app\models\Users::findone(['id'=>$user_id]);
        $year = \app\models\EconomicYear::find()->andWhere(['status' => 1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
        if($user_details['user_type']==1){
        $this->layout='province_district';
        }
        else if($user_details['user_type']==2){
            $this->layout='district';
        }
        $sum=0;
        $finalArray_initial = array();
        $title1=[];
        array_push($title1,"आर्थिक वर्ष","रकम");
        array_push($finalArray_initial,$title1);

        $finalArray_other = array();
        $title2=[];
        array_push($title2,"आर्थिक वर्ष","रकम");
        array_push($finalArray_other,$title2);
       
        
        // $account_details_other = (new \yii\db\Query())
        //     ->select('other_month_payment.id,SUM(other_month_payment.amount) as other_total,municipals.municipal_nepali as municipal_name')
        //     ->from('other_month_payment')
        //     ->where(['other_month_payment.fk_district_id'=>$dis_id])
        //     ->where(['other_month_payment.fk_year'=>$year['economic_year']])
        //     ->join('LEFT JOIN', 'municipals', 'municipals.id=other_month_payment.fk_municipal')
        //     ->groupBy('other_month_payment.fk_municipal')
        //     ->all();
        // $account_details_initial=(new \yii\db\Query())
        //     ->select('payment_chori.id,SUM(payment_chori.amount) as initial_amount,municipals.municipal_nepali as municipal_name')
        //     ->from('payment_chori')
        //     ->where(['payment_chori.fk_district_id'=>$dis_id])
        //     ->where(['payment_chori.fk_economic_year'=>$year['economic_year']])
        //     ->join('LEFT JOIN', 'municipals', 'municipals.id=payment_chori.fk_municipal')
        //     ->groupBy('payment_chori.fk_municipal')
        //     ->all();
        $account_details_initial=(new \yii\db\Query())
        ->select('SUM(payment_chori.amount) as sum,payment_chori.fk_economic_year')
        ->from('payment_chori')
        ->where(['payment_chori.fk_district_id'=>$dis_id])
        ->groupBy('payment_chori.fk_economic_year')
        ->all();
    // $account_details_initial=[];
    // var_dump($account_details_initial);die;
    $sum_initial=0;
    $sum_other=0;
    foreach($account_details_initial as $acc){
        $pie1=[];
        $year_name=\app\models\Year::findone(['id'=>$acc['fk_economic_year']]);
        $sum_initial=$sum_initial+$acc['sum'];
        $totalCasteWiseAmount_initial =$acc['sum'];
        array_push($pie1,$year_name['economic_year']);
        array_push($pie1,$totalCasteWiseAmount_initial);
        array_push($finalArray_initial,$pie1);

}
// $account_details_other=\app\models\OtherMonthPayment::find()->where(['fk_municipal'=>$user_details['fk_municipal_id']])->groupBy('fk_year')->all();
$account_details_other=(new \yii\db\Query())
        ->select('SUM(other_month_payment.amount) as other_sum,other_month_payment.fk_year')
        ->from('other_month_payment')
        ->where(['other_month_payment.fk_district_id'=>$dis_id])
        ->groupBy('other_month_payment.fk_year')
        ->all();
foreach($account_details_other as $other){
    $pie2=[];
    $other_year_name=\app\models\Year::findone(['id'=>$other['fk_year']]);
    $sum_other=$sum_other+$other['other_sum'];
    $totalCasteWiseAmount_other =$other['other_sum'];
    array_push($pie2,$other_year_name['economic_year']);
    array_push($pie2,$totalCasteWiseAmount_other);
    array_push($finalArray_other,$pie2);

}
        //var_dump($finalArray_initial);die;
      $casteWiseChartData_initial = json_encode($finalArray_initial,JSON_NUMERIC_CHECK);
      $casteWiseChartData_other = json_encode($finalArray_other,JSON_NUMERIC_CHECK);
      $municipal_id=\app\models\Municipals::find()->where(['fk_district'=>$dis_id])->all();
      return $this->render('promunicipal',[
          'municipal_id'=>$municipal_id,
          'casteWiseChartData_initial'=>$casteWiseChartData_initial,
          'casteWiseChartData_other'=>$casteWiseChartData_other,
          'sum_initial'=>$sum_initial,
          'sum_other'=>$sum_other,

        ]);

        
        
        $municipal_id=\app\models\Municipals::find()->where(['fk_district'=>$dis_id])->all();
        return $this->render('promunicipal',['municipal_id'=>$municipal_id]);
    }
    public function actionMunicipalDash($mun_id){
        $user_id =yii::$app->user->id;
        $user_details =\app\models\Users::findone(['id'=>$user_id]);
        $year =\app\models\EconomicYear::find()->andWhere(['status' => 1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
        
        $this->layout='municipal_dashboard';
        
        $sum=0;
        $finalArray_initial = array();
        $title1=[];
        array_push($title1,"आर्थिक वर्ष","रकम");
        array_push($finalArray_initial,$title1);

        $finalArray_other = array();
        $title2=[];
        array_push($title2,"आर्थिक वर्ष","रकम");
        array_push($finalArray_other,$title2);
       
        
        // $account_details_other = (new \yii\db\Query())
        //     ->select('chori_bachat.id,chori_bachat.fk_caste,other_month_payment.id,SUM(other_month_payment.amount) as other_total,caste.name as caste_name')
        //     ->from('chori_bachat')
        //     ->where(['chori_bachat.fk_per_municipal'=>$mun_id])
        //     ->join('LEFT JOIN','other_month_payment','other_month_payment.fk_chori_bachat=chori_bachat.id')
        //     ->join('LEFT JOIN', 'caste', 'caste.id=chori_bachat.fk_caste')
        //     ->where(['other_month_payment.fk_year'=>$year['economic_year']])
        //     ->groupBy('chori_bachat.fk_caste')
        //     ->all();
        // //var_dump($account_details_other);die;
        // $account_details_initial=(new \yii\db\Query())
        //     ->select('chori_bachat.id,chori_bachat.fk_apangata,payment_chori.id,payment_chori.fk_district_id,SUM(payment_chori.amount) as initial_amount,caste.name as caste_name')
        //     ->from('chori_bachat')
        //     ->where(['chori_bachat.fk_per_municipal'=>$mun_id])
        //     ->join('LEFT JOIN','payment_chori','payment_chori.fk_chori_bachat=chori_bachat.id')
        //     ->join('LEFT JOIN', 'caste', 'caste.id=chori_bachat.fk_caste')
        //     ->where(['payment_chori.fk_economic_year'=>$year['economic_year']])
        //     ->groupBy('chori_bachat.fk_caste')
        //     ->all();
        $account_details_initial=(new \yii\db\Query())
        ->select('SUM(payment_chori.amount) as sum,payment_chori.fk_economic_year')
        ->from('payment_chori')
        ->where(['payment_chori.fk_municipal'=>$mun_id])
        ->groupBy('payment_chori.fk_economic_year')
        ->all();
    // $account_details_initial=[];
    // var_dump($account_details_initial);die;
    $sum_initial=0;
    $sum_other=0;
    foreach($account_details_initial as $acc){
        $pie1=[];
        $year_name=\app\models\Year::findone(['id'=>$acc['fk_economic_year']]);
        $sum_initial=$sum_initial+$acc['sum'];
        $totalCasteWiseAmount_initial =$acc['sum'];
        array_push($pie1,$year_name['economic_year']);
        array_push($pie1,$totalCasteWiseAmount_initial);
        array_push($finalArray_initial,$pie1);

}
// $account_details_other=\app\models\OtherMonthPayment::find()->where(['fk_municipal'=>$user_details['fk_municipal_id']])->groupBy('fk_year')->all();
$account_details_other=(new \yii\db\Query())
        ->select('SUM(other_month_payment.amount) as other_sum,other_month_payment.fk_year')
        ->from('other_month_payment')
        ->where(['other_month_payment.fk_municipal'=>$mun_id])
        ->groupBy('other_month_payment.fk_year')
        ->all();
foreach($account_details_other as $other){
    $pie2=[];
    $other_year_name=\app\models\Year::findone(['id'=>$other['fk_year']]);
    $sum_other=$sum_other+$other['other_sum'];
    $totalCasteWiseAmount_other =$other['other_sum'];
    array_push($pie2,$other_year_name['economic_year']);
    array_push($pie2,$totalCasteWiseAmount_other);
    array_push($finalArray_other,$pie2);

}
        //var_dump($finalArray_initial);die;
      $casteWiseChartData_initial = json_encode($finalArray_initial,JSON_NUMERIC_CHECK);
      $casteWiseChartData_other = json_encode($finalArray_other,JSON_NUMERIC_CHECK);
    //   $municipal_id=\app\models\Municipals::find()->where(['fk_district'=>$dis_id])->all();
      return $this->render('municipal_dash',[
        //   'municipal_id'=>$municipal_id,
          'casteWiseChartData_initial'=>$casteWiseChartData_initial,
          'casteWiseChartData_other'=>$casteWiseChartData_other,
          'sum_initial'=>$sum_initial,
          'sum_other'=>$sum_other,
          'mun_id'=>$mun_id,
          'user_id'=>$user_id,
          'user_details'=>$user_details,

        ]);

        
        
        // $municipal_id=\app\models\Municipals::find()->where(['fk_district'=>$dis_id])->all();
        // return $this->render('promunicipal',['municipal_id'=>$municipal_id]);
    }
    public function actionMunicipalLoginReport(){
        $model= new \app\models\OtherMonthPayment();
        $helper = new Helper();
        $user_id=yii::$app->user->id;
        $user_details=\app\models\Users::findone(['id'=>$user_id]);
        
        $account_details = (new \yii\db\Query())
        ->select('chori_bachat.id,chori_bachat.age,chori_bachat.fk_economic_year,chori_bachat.fk_caste,chori_bachat.fk_apangata,'
            . 'chori_bachat.dob,chori_bachat.fk_ward,chori_bachat.created_date,chori_bachat.mobile_no,chori_bachat.tole_name,'
            . 'chori_bachat.father_name,chori_bachat.fk_per_district,chori_bachat.fk_ward,chori_bachat.fk_per_municipal,'
            . 'chori_bachat.name,chori_bachat.middle_name,chori_bachat.last_name,chori_account_details.id as account_id,payment_chori.id as pid,payment_chori.amount,
            bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name')
                ->from('chori_bachat')
                ->join('LEFT JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
                ->join('LEFT JOIN', 'bank_details', 'bank_details.id=chori_bachat.fk_bank_details')
                ->join('LEFT JOIN', 'payment_chori', 'payment_chori.fk_chori_bachat=chori_bachat.id')
                ->where(['chori_bachat.fk_user_id' => $user_details['id']])
                ->andWhere(['or',
                ['chori_account_details.bank_status'=>2],
                ['chori_account_details.bank_status'=>3],
                ['chori_account_details.bank_status'=>4]])
                ->andWhere(['chori_bachat.payment_status' => 1])
                ->orderBy(['chori_bachat.created_date'=>SORT_DESC]);
        
    //var_dump($totalCount);die;

            $dataProvider1 = new ActiveDataProvider([
                'query'=>$account_details,
                'sort' =>false,
                'pagination' => [
                    'pageSize' => 30,
                ],
            ]);
            
            if ($model->load(Yii::$app->request->post())){
                $today=$helper->actionNepaliDate();
                    $today_year=explode("-",$today);
                    $age_from=$model->age_from;
                    $age_to=$model->age_to; 
                    
                   
                $account_details = (new \yii\db\Query())
                ->select('chori_bachat.id,chori_bachat.middle_name,chori_bachat.last_name,chori_bachat.fk_ward,chori_bachat.age,chori_bachat.fk_economic_year,chori_bachat.fk_caste,chori_bachat.fk_apangata,chori_bachat.dob,chori_bachat.created_date,chori_bachat.mobile_no,chori_bachat.tole_name,chori_bachat.father_name,chori_bachat.fk_per_district,chori_bachat.fk_ward,chori_bachat.fk_per_municipal,chori_bachat.name,chori_account_details.id as account_id,payment_chori.id as pid,payment_chori.amount,bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name')
            ->from('chori_bachat')
            ->Join('LEFT JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
            ->Join('LEFT JOIN', 'bank_details', 'bank_details.id=chori_bachat.fk_bank_details')
            ->Join('LEFT JOIN', 'payment_chori', 'payment_chori.fk_chori_bachat=chori_bachat.id')
            ->where(['chori_bachat.fk_per_municipal' => $user_details['fk_municipal_id']])
            ->andWhere(['or',
                ['chori_account_details.bank_status'=>2],
                ['chori_account_details.bank_status'=>3],
                ['chori_account_details.bank_status'=>4]])
            ->orderBy(['chori_bachat.created_date'=>SORT_DESC])
            ->andFilterWhere(['chori_bachat.fk_per_province'=>$model->province_search])
            ->andFilterWhere(['chori_bachat.fk_per_district'=>$model->district_search])
            ->andFilterWhere(['chori_bachat.fk_caste'=>$model->caste_search])
            ->andFilterWhere(['chori_bachat.fk_apangata'=>$model->apangata_search])
            ->andFilterWhere(['chori_bachat.fk_economic_year'=>$model->year_search])
            ->andFilterWhere(['chori_bachat.fk_ward'=>$model->ward_search])
            ->andFilterWhere(['between','chori_bachat.created_date',$model->from_date,$model->to_date])
            ->andFilterWhere(['between','chori_bachat.age',$model->age_from,$model->age_to]);
            

            // $totalCount = count($account_details);
            $dataProvider1 = new ActiveDataProvider([
                
                // 'sql' => 'SELECT chori_bachat.id,chori_bachat.fk_economic_year,chori_bachat.fk_caste,chori_bachat.fk_apangata,
                // chori_bachat.dob,chori_bachat.created_date,chori_bachat.mobile_no,chori_bachat.tole_name,
                // chori_bachat.father_name,chori_bachat.fk_per_district,chori_bachat.fk_ward,chori_bachat.fk_per_municipal,
                // chori_bachat.name,chori_account_details.id as account_id,payment_chori.id as pid,payment_chori.amount,
                // bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name
                // FROM chori_bachat 
                // LEFT JOIN payment_chori on payment_chori.fk_chori_bachat=chori_bachat.id
                // LEFT JOIN bank_details on bank_details.id=chori_bachat.fk_bank_details
                // LEFT JOIN chori_account_details on chori_account_details.fk_chori_bachat=chori_bachat.id
                // Where chori_bachat.fk_per_province LIKE '.'"'.$model['province_search'].'"'.' AND 
                // chori_bachat.fk_per_district LIKE '.'"'.$model['district_search'].'"'.' AND
                // chori_bachat.fk_caste LIKE '.'"'.$model['caste_search'].'"'.' AND
                
                

                // chori_bachat.fk_per_municipal='.$user_details['fk_municipal_id'],
                
                
                // 'totalCount' => $totalCount,
                // 'sort' =>false,
                'query'=>$account_details,
                'sort' =>false,
                'pagination' => [
                    'pageSize' => '',
                ],
                
                
            ]);
            
                    
            }
            // $pages = new \yii\data\Pagination(['totalCount' => $account_details->count(), 'pageSize'=>10]);
            //     $models = $account_details->offset($pages->offset)
            //     ->limit($pages->limit)
            //     ->all();
                
        return $this->render('test_municipal_login_report',[
            'account_details'=>$account_details,
            'model'=>$model,
            'dataProvider'=>$dataProvider1,
            'helper'=>$helper,
  
        ]);
    }
    public function actionPdf(){
        $user_id=yii::$app->user->id;
        $user_details=\app\models\Users::findone(['id'=>$user_id]);
        
        
        $account_details = (new \yii\db\Query())
        ->select('chori_bachat.id,chori_bachat.age,chori_bachat.fk_economic_year,chori_bachat.fk_caste,chori_bachat.fk_apangata,'
            . 'chori_bachat.dob,chori_bachat.created_date,chori_bachat.mobile_no,chori_bachat.tole_name,'
            . 'chori_bachat.father_name,chori_bachat.fk_per_district,chori_bachat.fk_ward,chori_bachat.fk_per_municipal,'
            . 'chori_bachat.name,chori_account_details.id as account_id,payment_chori.id as pid,payment_chori.amount,
            bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name')
                ->from('chori_bachat')
                ->join('LEFT JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
                ->join('LEFT JOIN', 'bank_details', 'bank_details.id=chori_bachat.fk_bank_details')
                ->join('LEFT JOIN', 'payment_chori', 'payment_chori.fk_chori_bachat=chori_bachat.id')
                ->where(['chori_bachat.fk_per_municipal' => $user_details['fk_municipal_id']])
                ->orderBy(['chori_bachat.created_date'=>SORT_DESC]);
        $data=$account_details->all();
    //var_dump($totalCount);die;

            $dataProvider1 = new ActiveDataProvider([
                'query'=>$account_details
            ]);
     
        $html=$this->renderPartial('pdf_view',['data'=>$data]);
        $mpdf=new \Mpdf\Mpdf(['mode'=>'UTF-8','format'=>'A4-P','autoScriptToLang'=>true,'autoLangtoFont'=>true]);
        // $mpdf->showImageErrors=true;
        $mpdf->setDisplayMode('fullpage','two');
        $mpdf->list_indent_first_level=0;
        $mpdf->writeHtml($html);
        $mpdf->output();
        exit;
    }
    public function actionMunicipalReport($mun_id){
        $model= new \app\models\OtherMonthPayment();
        $helper = new Helper();
        $user_id=yii::$app->user->id;
        $user_details=\app\models\Users::findone(['id'=>$user_id]);
        $this->layout='municipal_dashboard';
        
        
        $account_details = (new \yii\db\Query())
        ->select('chori_bachat.id,chori_bachat.age,chori_bachat.fk_economic_year,chori_bachat.fk_caste,chori_bachat.fk_apangata,chori_bachat.dob,chori_bachat.created_date,chori_bachat.mobile_no,chori_bachat.tole_name,chori_bachat.father_name,chori_bachat.fk_per_district,chori_bachat.fk_ward,chori_bachat.fk_per_municipal,chori_bachat.name,chori_account_details.id as account_id,payment_chori.id as pid,payment_chori.amount,bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name')
                ->from('chori_bachat')
                ->join('LEFT JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
                ->join('LEFT JOIN', 'bank_details', 'bank_details.id=chori_bachat.fk_bank_details')
                ->join('LEFT JOIN', 'payment_chori', 'payment_chori.fk_chori_bachat=chori_bachat.id')
                ->where(['chori_bachat.fk_per_municipal' => $mun_id])
                ->andWhere(['or',
                ['chori_account_details.bank_status'=>2],
                ['chori_account_details.bank_status'=>3],
                ['chori_account_details.bank_status'=>4]])
                ->orderBy(['chori_bachat.created_date'=>SORT_DESC]);
                $dataProvider1=new ActiveDataProvider([
                    'query'=>$account_details,
                    'sort'=>false,
                    'pagination'=>['pagesize'=>30],
                ]);

            if ($model->load(Yii::$app->request->post())){
                $today=$helper->actionNepaliDate();
                    $today_year=explode("-",$today);
                     
                    
                $account_details = (new \yii\db\Query())
                ->select('chori_bachat.id,chori_bachat.age,chori_bachat.fk_economic_year,chori_bachat.fk_caste,chori_bachat.fk_apangata,chori_bachat.dob,chori_bachat.created_date,chori_bachat.mobile_no,chori_bachat.tole_name,chori_bachat.father_name,chori_bachat.fk_per_district,chori_bachat.fk_ward,chori_bachat.fk_per_municipal,chori_bachat.name,chori_account_details.id as account_id,payment_chori.id as pid,payment_chori.amount,bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name')
            ->from('chori_bachat')
            ->Join('LEFT JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
            ->Join('LEFT JOIN', 'bank_details', 'bank_details.id=chori_bachat.fk_bank_details')
            ->Join('LEFT JOIN', 'payment_chori', 'payment_chori.fk_chori_bachat=chori_bachat.id')
            ->where(['chori_bachat.fk_per_municipal' => $mun_id])
            ->andWhere(['or',
            ['chori_account_details.bank_status'=>2],
            ['chori_account_details.bank_status'=>3],
            ['chori_account_details.bank_status'=>4]])
            ->orderBy(['chori_bachat.created_date'=>SORT_DESC])
            ->andFilterWhere(['chori_bachat.fk_per_province'=>$model->province_search])
            ->andFilterWhere(['chori_bachat.fk_per_district'=>$model->district_search])
            ->andFilterWhere(['chori_bachat.fk_caste'=>$model->caste_search])
            ->andFilterWhere(['chori_bachat.fk_apangata'=>$model->apangata_search])
            ->andFilterWhere(['chori_bachat.fk_economic_year'=>$model->year_search])
            ->andFilterWhere(['between','chori_bachat.created_date',$model->from_date,$model->to_date])
            ->andFilterWhere(['between','chori_bachat.age',$model->age_from,$model->age_to]);
            
            $dataProvider1=new ActiveDataProvider([
                'query'=>$account_details,
                'sort'=>false,
                'pagination'=>['pagesize'=>''],
            ]);
                    
            }
                
        return $this->render('municipal_report',[
            'mun_id'=>$mun_id,
            'dataProvider'=>$dataProvider1,
            'model'=>$model,
        ]);
    }
    public function actionDistrictReport($dis_id){
        $model= new \app\models\OtherMonthPayment();
        $helper = new Helper();
        $user_id=yii::$app->user->id;
        $user_details=\app\models\Users::findone(['id'=>$user_id]);
        if($user_details['user_type']==1){
            $this->layout='province_district';
        }
        else if($user_details['user_type']==2){
            $this->layout='district';
        }
        $account_details = (new \yii\db\Query())
        ->select('chori_bachat.id,chori_bachat.age,chori_bachat.fk_economic_year,chori_bachat.fk_caste,chori_bachat.fk_apangata,chori_bachat.dob,chori_bachat.created_date,chori_bachat.mobile_no,chori_bachat.tole_name,chori_bachat.father_name,chori_bachat.fk_per_district,chori_bachat.fk_ward,chori_bachat.fk_per_municipal,chori_bachat.name,chori_account_details.id as account_id,payment_chori.id as pid,payment_chori.amount,bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name')
                ->from('chori_bachat')
                ->join('LEFT JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
                ->join('LEFT JOIN', 'bank_details', 'bank_details.id=chori_bachat.fk_bank_details')
                ->join('LEFT JOIN', 'payment_chori', 'payment_chori.fk_chori_bachat=chori_bachat.id')
                ->where(['chori_bachat.fk_per_district' => $dis_id])
                ->andWhere(['or',
                ['chori_account_details.bank_status'=>2],
                ['chori_account_details.bank_status'=>3],
                ['chori_account_details.bank_status'=>4]])
                ->orderBy(['chori_bachat.created_date'=>SORT_DESC]);
        $dataProvider1=new ActiveDataProvider([
            'query'=>$account_details,
            'sort'=>false,
            'pagination'=>['pagesize'=>30],
        ]);
                
        
            if ($model->load(Yii::$app->request->post())){
                $today=$helper->actionNepaliDate();
                    $today_year=explode("-",$today);
              
                    
                    
                        
                        //var_dump($age_from_date,$age_to_date,$today_year);die;
                        $account_details = (new \yii\db\Query())
                ->select('chori_bachat.id,chori_bachat.age,chori_bachat.fk_economic_year,chori_bachat.fk_caste,chori_bachat.fk_apangata,chori_bachat.dob,chori_bachat.created_date,chori_bachat.mobile_no,chori_bachat.tole_name,chori_bachat.father_name,chori_bachat.fk_per_district,chori_bachat.fk_ward,chori_bachat.fk_per_municipal,chori_bachat.name,chori_account_details.id as account_id,payment_chori.id as pid,payment_chori.amount,bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name')
            ->from('chori_bachat')
            ->Join('LEFT JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
            ->Join('LEFT JOIN', 'bank_details', 'bank_details.id=chori_bachat.fk_bank_details')
            ->Join('LEFT JOIN', 'payment_chori', 'payment_chori.fk_chori_bachat=chori_bachat.id')
            ->where(['chori_bachat.fk_per_district' => $dis_id])
            ->andWhere(['or',
            ['chori_account_details.bank_status'=>2],
            ['chori_account_details.bank_status'=>3],
            ['chori_account_details.bank_status'=>4]])
            ->orderBy(['chori_bachat.created_date'=>SORT_DESC])
            ->andFilterWhere(['chori_bachat.fk_per_province'=>$model->province_search])
            ->andFilterWhere(['chori_bachat.fk_per_municipal'=>$model->local_level])
            ->andFilterWhere(['chori_bachat.fk_caste'=>$model->caste_search])
            ->andFilterWhere(['chori_bachat.fk_apangata'=>$model->apangata_search])
            ->andFilterWhere(['chori_bachat.fk_economic_year'=>$model->year_search])
            ->andFilterWhere(['between','chori_bachat.created_date',$model->from_date,$model->to_date])
            ->andFilterWhere(['between','chori_bachat.age',$model->age_from,$model->age_to]);
            
            $dataProvider1=new ActiveDataProvider([
                'query'=>$account_details,
                'sort'=>false,
                'pagination'=>['pagesize'=>''],
                
            ]);
                    
                   

            }
        
                
        return $this->render('district_report',[
            'dis_id'=>$dis_id,
            'dataProvider'=>$dataProvider1,
            'model'=>$model,
        ]);
    }
    public function actionProvinceReport(){
        $model= new \app\models\OtherMonthPayment();
        $helper = new Helper();
        $user_id=yii::$app->user->id;
        $user_details=\app\models\Users::findone(['id'=>$user_id]);
        if($user_details['user_type']==1){
            $this->layout='province';
        }
        else if($user_details['user_type']==2){
            $this->layout='district';
        }
        $account_details = (new \yii\db\Query())
                ->select('chori_bachat.id,chori_bachat.age,chori_bachat.fk_economic_year,chori_bachat.fk_caste,chori_bachat.fk_apangata,chori_bachat.dob,chori_bachat.created_date,chori_bachat.mobile_no,chori_bachat.tole_name,chori_bachat.father_name,chori_bachat.fk_per_district,chori_bachat.fk_ward,chori_bachat.fk_per_municipal,chori_bachat.name,chori_account_details.id as account_id,payment_chori.id as pid,payment_chori.amount,bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name')
                ->from('chori_bachat')
                ->join('LEFT JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
                ->join('LEFT JOIN', 'bank_details', 'bank_details.id=chori_bachat.fk_bank_details')
                ->join('LEFT JOIN', 'payment_chori', 'payment_chori.fk_chori_bachat=chori_bachat.id')
                ->where(['chori_bachat.fk_per_province' => $user_details['fk_province_id']])
                ->andWhere(['or',
                ['chori_account_details.bank_status'=>2],
                ['chori_account_details.bank_status'=>3],
                ['chori_account_details.bank_status'=>4]])
                ->orderBy(['chori_bachat.created_date'=>SORT_DESC]);
        
        $dataProvider1= new ActiveDataProvider([
            'query'=>$account_details,
            'sort'=>false,
            'pagination'=>['pagesize'=>30],

        ]);
                if ($model->load(Yii::$app->request->post())){
                    //var_dump((int)$model->age_search);die;
                    
                    $today=$helper->actionNepaliDate();
                    $today_year=explode("-",$today);
               
                    
                   
                        $account_details = (new \yii\db\Query())
                        ->select('chori_bachat.id,chori_bachat.age,chori_bachat.fk_economic_year,chori_bachat.fk_caste,chori_bachat.fk_apangata,chori_bachat.dob,chori_bachat.created_date,chori_bachat.mobile_no,chori_bachat.tole_name,chori_bachat.father_name,chori_bachat.fk_per_district,chori_bachat.fk_ward,chori_bachat.fk_per_municipal,chori_bachat.name,chori_account_details.id as account_id,payment_chori.id as pid,payment_chori.amount,bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name')
                    ->from('chori_bachat')
                    ->Join('LEFT JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
                    ->Join('LEFT JOIN', 'bank_details', 'bank_details.id=chori_bachat.fk_bank_details')
                    ->Join('LEFT JOIN', 'payment_chori', 'payment_chori.fk_chori_bachat=chori_bachat.id')
                    ->where(['chori_bachat.fk_per_province' => $user_details['fk_province_id']])
                    ->andWhere(['or',
                    ['chori_account_details.bank_status'=>2],
                    ['chori_account_details.bank_status'=>3],
                    ['chori_account_details.bank_status'=>4]])
                    ->orderBy(['chori_bachat.created_date'=>SORT_DESC])
                    ->andFilterWhere(['chori_bachat.fk_per_district'=>$model->district_search])
                    ->andFilterWhere(['chori_bachat.fk_per_municipal'=>$model->local_level])
                    ->andFilterWhere(['chori_bachat.fk_caste'=>$model->caste_search])
                    ->andFilterWhere(['chori_bachat.fk_apangata'=>$model->apangata_search])
                    ->andFilterWhere(['chori_bachat.fk_economic_year'=>$model->year_search])
                    ->andFilterWhere(['between','chori_bachat.created_date',$model->from_date,$model->to_date])
                    ->andFilterWhere(['between','chori_bachat.age',$model->age_from,$model->age_to]);
                    
                    
                    $dataProvider1= new ActiveDataProvider([
                        'query'=>$account_details,
                        'sort'=>false,
                        'pagination'=>['pagesize'=>''],
                    ]);

                }
                   
                
        return $this->render('province_report',[
            'model'=>$model,
            'dataProvider'=>$dataProvider1,

        ]);
    }
    
    public function actionDistrictLoginReport(){
        $model= new \app\models\OtherMonthPayment();
        $helper = new Helper();
        $user_id=yii::$app->user->id;
        $user_details=\app\models\Users::findone(['id'=>$user_id]);
        if($user_details['user_type']==1){
            $this->layout='province';
        }
        else if($user_details['user_type']==2){
            $this->layout='district';
        }
        $account_details = (new \yii\db\Query())
                ->select('chori_bachat.id,chori_bachat.age,chori_bachat.fk_economic_year,chori_bachat.fk_caste,chori_bachat.fk_apangata,chori_bachat.dob,chori_bachat.created_date,chori_bachat.mobile_no,chori_bachat.tole_name,chori_bachat.father_name,chori_bachat.fk_per_district,chori_bachat.fk_ward,chori_bachat.fk_per_municipal,chori_bachat.name,chori_account_details.id as account_id,payment_chori.id as pid,payment_chori.amount,bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name')
                ->from('chori_bachat')
                ->join('LEFT JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
                ->join('LEFT JOIN', 'bank_details', 'bank_details.id=chori_bachat.fk_bank_details')
                ->join('LEFT JOIN', 'payment_chori', 'payment_chori.fk_chori_bachat=chori_bachat.id')
                ->where(['chori_bachat.fk_per_district' => $user_details['fk_district_id']])
                ->andWhere(['or',
                ['chori_account_details.bank_status'=>2],
                ['chori_account_details.bank_status'=>3],
                ['chori_account_details.bank_status'=>4]])
                ->orderBy(['chori_bachat.created_date'=>SORT_DESC]);
                $dataProvider1=new ActiveDataProvider([
                    'query'=>$account_details,
                    'sort'=>false,
                    'pagination'=>['pagesize'=>30],
                ]);
            
                if ($model->load(Yii::$app->request->post())){
                    $today=$helper->actionNepaliDate();
                    $today_year=explode("-",$today);
                    
                   
                    $account_details = (new \yii\db\Query())
                    ->select('chori_bachat.id,chori_bachat.age,chori_bachat.fk_economic_year,chori_bachat.fk_caste,chori_bachat.fk_apangata,chori_bachat.dob,chori_bachat.created_date,chori_bachat.mobile_no,chori_bachat.tole_name,chori_bachat.father_name,chori_bachat.fk_per_district,chori_bachat.fk_ward,chori_bachat.fk_per_municipal,chori_bachat.name,chori_account_details.id as account_id,payment_chori.id as pid,payment_chori.amount,bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name')
                    ->from('chori_bachat')
                    ->Join('LEFT JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
                    ->Join('LEFT JOIN', 'bank_details', 'bank_details.id=chori_bachat.fk_bank_details')
                    ->Join('LEFT JOIN', 'payment_chori', 'payment_chori.fk_chori_bachat=chori_bachat.id')
                    ->where(['chori_bachat.fk_per_district' => $user_details['fk_district_id']])
                    ->andWhere(['or',
                    ['chori_account_details.bank_status'=>2],
                    ['chori_account_details.bank_status'=>3],
                    ['chori_account_details.bank_status'=>4]])
                    ->orderBy(['chori_bachat.created_date'=>SORT_DESC])
                    ->andFilterWhere(['chori_bachat.fk_per_province'=>$model->province_search])
                    ->andFilterWhere(['chori_bachat.fk_per_municipal'=>$model->local_level])
                    ->andFilterWhere(['chori_bachat.fk_caste'=>$model->caste_search])
                    ->andFilterWhere(['chori_bachat.fk_apangata'=>$model->apangata_search])
                    ->andFilterWhere(['chori_bachat.fk_economic_year'=>$model->year_search])
                    ->andFilterWhere(['between','chori_bachat.created_date',$model->from_date,$model->to_date])
                    ->andFilterWhere(['between','chori_bachat.age',$model->age_from,$model->age_to]);
                   
                    $dataProvider1=new ActiveDataProvider([
                        'query'=>$account_details,
                        'sort'=>false,
                        'pagination'=>['pagesize'=>''],
                    ]);
                    
                }
                
        return $this->render('district_login_report',[
            'dataProvider'=>$dataProvider1,
            'model'=>$model,
        ]);
    }

    public function actionDistrictDrop(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        // var_dump($out);die;
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                
                $out = \app\models\District::getDistrict($cat_id);
         
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                return ['output' => $out, 'selected' => ''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }
    public function actionLocalDrop(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        // var_dump($out);die;
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                
                $out = \app\models\Municipals::getMunicipals($cat_id);
         
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                return ['output' => $out, 'selected' => ''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout='login_layout';   
        if (!Yii::$app->user->isGuest) {
           
            return $this->redirect(['site/login']);
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
