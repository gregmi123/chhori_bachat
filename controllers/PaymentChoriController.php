<?php

namespace app\controllers;

use Yii;
use app\models\PaymentChori;
use app\models\PaymentChoriSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Model;
use app\models\OtherMonthPayment;
use app\models\MoneySet;



/**
 * PaymentChoriController implements the CRUD actions for PaymentChori model.
 */
class PaymentChoriController extends Controller {
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    /**
     * Lists all PaymentChori models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PaymentChoriSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //var_dump($dataProvider);die;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PaymentChori model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {


        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionFindChori($cal_month, $new_year) {
        //$cal_month = $month - 1;
        $model = new PaymentChori();
        $helper = new Helper();
        $today = $helper->actionNepaliDate();
        $explode_today = explode('-', $today);
        $year = $explode_today[0];
        $month = $explode_today[1];
        
        //var_dump($first_payment);die;
        $bank_id = \app\models\BankDetails::findone(['fk_municipal_id' => $helper->getOrganization()]);
        $economicYear= \app\models\EconomicYear::find()->where(['status'=>1])->one();
        $economic_year_id=$economicYear->id;
        //var_dump($economic_year_id);die;
        $account_opened = (new \yii\db\Query())
                ->select('chori_bachat.id,chori_bachat.name,chori_account_details.id as account_id,bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name')
                ->from('chori_bachat')
                ->join('JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
                ->join('JOIN', 'bank_details', 'bank_details.id=chori_account_details.bank_name')
                ->join('JOIN', 'payment_chori', 'payment_chori.fk_chori_bachat=chori_bachat.id')
                ->where(['chori_bachat.status' => 5])
                ->andWhere(['chori_bachat.fk_user_id' => $helper->getUserId()])
                ->andWhere(['chori_bachat.fk_municipal_id' => $helper->getOrganization()])
                ->andWhere(['chori_bachat.payment_status' => 1])
                ->andWhere(['payment_chori.fk_month' => $cal_month])
                ->andWhere(['payment_chori.fk_economic_year' => $new_year])
                ->all();
        //var_dump($account_opened);die;

        //$month_id= \yii\helpers\ArrayHelper::map(\app\models\Month::find()->all(), 'id', 'month_name');
        //var_dump($month_id->id);die;
        $multipleChhori = [new PaymentChori()];
        if ($model->load(Yii::$app->request->post())) {
            $multipleChhori = Model::createMultiple(PaymentChori::classname());
            //var_dump($multipleChhori);die;

            Model::loadMultiple($multipleChhori, Yii::$app->request->post());
            //var_dump($multipleChhori->fk_economic_year);die;
            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                                ActiveForm::validateMultiple($multipleChhori),
                                ActiveForm::validate($model)
                );
            }
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                //var_dump($multipleChhori);die;
                foreach ($multipleChhori as $modelAddress) {

                    if($modelAddress->fk_chori_bachat) {


                        $xori = \app\models\ChoriBachat::findOne(['id' => $modelAddress->fk_chori_bachat]);

                        if ($xori) {


                            if ($xori->save()) {
                                $flag = true;
                            } else {
                                $flag = false;
                            }
                        }
                        // var_dump($modelAddress->amount);die;
                        $modelAddress->fk_economic_year = $economic_year_id;
                        $modelAddress->fk_month = $this->actionDateToMonth($month);
                        $modelAddress->fk_bank_details = $bank_id->id;
                        $modelAddress->post_date = $helper->actionNepaliDate();
                        $modelAddress->fk_user_id = $helper->getUserId();
                        $modelAddress->fk_municipal = $helper->getOrganization();
                        $modelAddress->created_date = date('Y-m-d');
                        $modelAddress->date = date('Y-m-d');

                        if (!($flag = $modelAddress->save(false))) {
                            $transaction->rollBack();
                            break;
                        }
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    return $this->redirect(['index']);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }




        return $this->render('find-chori', [
                    'model' => $model,
                    'account_opened' => $account_opened,
                    'multipleChhori' => empty($multipleChhori) ? [new PaymentChori()] : $multipleChhori,
        ]);
    }
    public function actionDepositview(){
        $model = new PaymentChori();
        return $this->render('deposit_view',
    [
        'model'=>$model,
    ]);
    }
    public function actionMultifind(){
        $model = new PaymentChori();
        return $this->render('multiple_find',
    [
        'model'=>$model,
    ]);
    }
    public function actionViewchori($id){
        
        return $this->render('view_payment',
    [
        'id'=>$id,
    ]);
    }
    public function actionMulti($month, $year ,$method){
        if($method==1){
            $new_month=$month;
            $multi_month=0;
        }else{
            if($month==1){
                $new_month=1;
                $multi_month=4;
            }
            else if($month==2){
                $new_month=5;
                $multi_month=8;
            }
            else if($month==3){
                $new_month=9;
                $multi_month=12;
            }
        }
        return $this->redirect(array('multiple','month'=>$new_month,'multi_month'=>$multi_month,'year'=>$year));

    }
    public function actionDeposit($month, $year ,$method){
        if($method==1){
            $new_month=$month;
            $multi_month=0;
        }else{
            if($month==1){
                $new_month=1;
                $multi_month=4;
            }
            else if($month==2){
                $new_month=5;
                $multi_month=8;
            }
            else if($month==3){
                $new_month=9;
                $multi_month=12;
            }
            else{
                $new_month=10;
                $multi_month=12;
            }
        }
        return $this->redirect(array('deposit-multiple','month'=>$new_month,'year'=>$year,'add_month'=>$multi_month));

    }

    public function actionInitialDeposit($initial_id){
        $user_id = yii::$app->user->id;
        $user_details = \app\models\Users::findOne(['id' => $user_id]);
        $payment_chori=\app\models\PaymentChori::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal' => $user_details->fk_municipal_id])->andWhere(['fk_initial' => $initial_id]);
        $pages = new \yii\data\Pagination(['totalCount' => $payment_chori->count(),'pageSize'=>20]);
        $models = $payment_chori->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        return $this->render('initial_deposit',[
            'user_id'=>$user_id,
            'user_details'=>$user_details,
            'models'=>$models,
            'pages'=>$pages,
            'initial_id'=>$initial_id,
        ]);
    }
    


//        $helper= new Helper();
//        $account_opened = (new \yii\db\Query())
//                ->select('chori_bachat.id,chori_bachat.name,chori_account_details.id as account_id,bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name')
//                ->from('chori_bachat')
//                ->join('JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
//                ->join('JOIN', 'bank_details', 'bank_details.id=chori_bachat.fk_bank_details')
//                ->join('JOIN','payment_chori','payment_chori.fk_chori_bachat=chori_bachat.id')
//                ->where(['chori_bachat.status' => 5])
//                ->andWhere(['chori_bachat.fk_user_id' => $helper->getUserId()])
//                ->andWhere(['chori_bachat.fk_municipal_id' => $helper->getOrganization()])
//                ->andWhere(['payment_chori.fk_month'=>$month])
//                ->andWhere(['payment_chori.fk_economic_year'=>$year])
//                ->all();
    

    /**
     * Creates a new PaymentChori model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionConvertFiscalYear($month){
        $helper = new Helper();
        $user_details=\app\models\Users::findone(['id'=>$helper->getUserId()]);
        $year = \app\models\EconomicYear::find()->andWhere(['status' => 1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
        $economic_year=\app\models\Year::find()->where(['id'=>$year['economic_year']])->one();
        $split_year=explode('/',$economic_year['economic_year']);
        //var_dump($split_year);die;
        $result=0;
        $month=(int)$month;
        if($month==1){
            $result = $split_year[0];
        }else if($month==2){
             $result = $split_year[0];
        }else if($month==3){
             $result = $split_year[0];
        }else if($month==4){
             $result = $split_year[0];
        }else if($month==5){
             $result = $split_year[0];
        }else if($month==6){
             $result = $split_year[0];
        }else if($month==7){
             $result = $split_year[0];
        }else if($month==8){
             $result = $split_year[0];
        }else if($month==9){
             $result = $split_year[0];
        }else if($month==10){
             $result = '20'.$split_year[1];
        }else if($month==11){
             $result = '20'.$split_year[1];
        }else if($month==12){
             $result = '20'.$split_year[1];
        }
        return $result;
    }
    public function actionMultiAll($month,$multi_month,$year) {
       
        $model = new PaymentChori();
        $helper = new Helper();
        $economic_year=\app\models\EconomicYear::find()->where(['id'=>$year])->one();
        $final_date=array();
        if(!($multi_month==0)){
        $converted_month=$this->actionDateToMonth($multi_month);
        $converted_year=$this->actionConvertFiscalYear($multi_month);
        if($converted_month<10){
        array_push($final_date,$converted_year.'-'.'0'.$converted_month.'-'.'32');
        }
        else{
            array_push($final_date,$converted_year.'-'.$converted_month.'-'.'32');
        }
        // var_dump($final_date);die;
    }else{
        $converted_month=$this->actionDateToMonth($month);
        $converted_year=$this->actionConvertFiscalYear($month);
        if($converted_month<10){
        array_push($final_date,$converted_year.'-'.'0'.$converted_month.'-'.'32');
        }
        else{
            array_push($final_date,$converted_year.'-'.$converted_month.'-'.'32');
        }
        
    }
    
        $user_details=\app\models\Users::findone(['id'=>$helper->getUserId()]);
        $bank_id = \app\models\BankDetails::findone(['fk_municipal_id' => $helper->getOrganization()]);
        //var_dump($final_date[0]);die;
        //var_dump($final_date);die;
        $models = (new \yii\db\Query())
                ->select('chori_bachat.id,chori_bachat.dob,chori_bachat.middle_name,chori_bachat.last_name,chori_bachat.birth_certificate_date,chori_bachat.unique_id,chori_bachat.verified_date,chori_bachat.name,chori_account_details.account_open_date,chori_account_details.id as account_id,payment_chori.id as pid,bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name')
                ->from('chori_bachat')
                ->join('JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
                ->join('JOIN', 'bank_details', 'bank_details.id=chori_account_details.bank_name')
                ->join('JOIN', 'payment_chori', 'payment_chori.fk_chori_bachat=chori_bachat.id')
                ->Where(['chori_bachat.status' => 5])
                // ->andWhere(['<=','chori_bachat.verified_date',$final_date[0]])
                ->andWhere(['or',['payment_chori.status' => 6],['payment_chori.status' => 7]])
                ->andWhere(['chori_account_details.bank_status'=>2])
                ->andWhere(['chori_bachat.fk_user_id' => $helper->getUserId()])
                ->andWhere(['chori_bachat.fk_municipal_id' => $helper->getOrganization()])
                ->andWhere(['chori_bachat.payment_status' => 1])
                ->orderBy(['id'=>SORT_DESC])
                ->all();
                
                //var_dump($account_opened);die; 
                
                
            
                

        $multipleChhori = [new OtherMonthPayment()];
        return $this->renderPartial('multiple_form_all', [
                    'model' => $model,
                    'multipleChhori' => empty($multipleChhori) ? [new OtherMonthPayment()] : $multipleChhori,
                    'month'=>$month,
                    'multi_month'=>$multi_month,
                    'year'=>$year,
                    'models' => $models,
                    'final_date'=>$final_date,

                    
        ]);
    }
    public function actionMultiple($month,$multi_month,$year) {
       
        $model = new PaymentChori();
        $helper = new Helper();
        $economic_year=\app\models\EconomicYear::find()->where(['id'=>$year])->one();
        $final_date=array();
        if(!($multi_month==0)){
        $converted_month=$this->actionDateToMonth($multi_month);
        $converted_year=$this->actionConvertFiscalYear($multi_month);
        if($converted_month<10){
        array_push($final_date,$converted_year.'-'.'0'.$converted_month.'-'.'32');
        }
        else{
            array_push($final_date,$converted_year.'-'.$converted_month.'-'.'32');
        }
    
    }else{
        $converted_month=$this->actionDateToMonth($month);
        $converted_year=$this->actionConvertFiscalYear($month);
        if($converted_month<10){
        array_push($final_date,$converted_year.'-'.'0'.$converted_month.'-'.'32');
        }
        else{
            array_push($final_date,$converted_year.'-'.$converted_month.'-'.'32');
        }
        
    }
        
        // var_dump($final_date);die;


        
        $user_details=\app\models\Users::findone(['id'=>$helper->getUserId()]);
        $bank_id = \app\models\BankDetails::findone(['fk_municipal_id' => $helper->getOrganization()]);
        //var_dump($final_date[0]);die;
        //var_dump($final_date);die;
        $account_opened = (new \yii\db\Query())
                ->select('chori_bachat.id,chori_bachat.middle_name,chori_bachat.last_name,chori_bachat.dob,chori_bachat.unique_id,chori_bachat.verified_date,chori_bachat.name,chori_account_details.id as account_id,payment_chori.id as pid,bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name,chori_account_details.account_open_date')
                ->from('chori_bachat')
                ->join('JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
                ->join('JOIN', 'bank_details', 'bank_details.id=chori_account_details.bank_name')
                ->join('JOIN', 'payment_chori', 'payment_chori.fk_chori_bachat=chori_bachat.id')
                ->Where(['chori_bachat.status' => 5])
                // ->andWhere(['<=','chori_bachat.verified_date',$final_date[0]])
                ->andWhere(['or',['payment_chori.status' => 6],['payment_chori.status' => 7]])
                ->andWhere(['chori_account_details.bank_status'=>2])
                ->andWhere(['chori_bachat.fk_user_id' => $helper->getUserId()])
                ->andWhere(['chori_bachat.fk_municipal_id' => $helper->getOrganization()])
                ->andWhere(['chori_bachat.payment_status' => 1])
                ->orderBy(['id'=>SORT_DESC]);
                
                //var_dump($account_opened);die; 
                
                $pages = new \yii\data\Pagination(['totalCount' => $account_opened->count(), 'pageSize'=>20]);
                $models = $account_opened->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
            
                // var_dump($models);die;

        $multipleChhori = [new OtherMonthPayment()];
        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(array('confirm','month'=>$month,'year'=>$year,'multi_month'=>$multi_month));
        }
        return $this->render('multiplecreate', [
                    'model' => $model,
                    'account_opened' => $account_opened,
                    'multipleChhori' => empty($multipleChhori) ? [new OtherMonthPayment()] : $multipleChhori,
                    'month'=>$month,
                    'multi_month'=>$multi_month,
                    'year'=>$year,
                    'models' => $models,
                    'pages' => $pages,
                    'final_date'=>$final_date,

                    
        ]);
    }
    public function actionDepositAll($month, $year,$add_month){
        $model = new PaymentChori();
        $helper = new Helper();
        $user_details=\app\models\Users::findone(['id'=>$helper->getUserId()]);
        $economic_year=\app\models\EconomicYear::find()->where(['status'=>1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
        $bank_id = \app\models\BankDetails::findone(['fk_municipal_id' => $helper->getOrganization()]);

        //var_dump($bank_id->id);die;
        $models = (new \yii\db\Query())
                ->select('chori_bachat.id,chori_bachat.middle_name,chori_bachat.last_name,chori_bachat.unique_id,chori_bachat.dob,chori_bachat.tole_name,chori_bachat.father_name,chori_bachat.mobile_no,chori_bachat.created_date,chori_bachat.fk_per_district,chori_bachat.fk_per_municipal,chori_bachat.fk_ward,chori_bachat.verified_date,chori_bachat.name,chori_account_details.id as account_id,payment_chori.id as pid,payment_chori.fk_chori_bachat,bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name')
                ->from('chori_bachat')
                ->join('JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
                ->join('JOIN', 'bank_details', 'bank_details.id=chori_account_details.bank_name')
                ->join('JOIN', 'payment_chori', 'payment_chori.fk_chori_bachat=chori_bachat.id')
                ->Where(['chori_bachat.status' => 5])
                ->andWhere(['payment_chori.status' => 7])
                ->andWhere(['chori_account_details.bank_status'=>2])
                ->andWhere(['chori_bachat.fk_user_id' => $helper->getUserId()])
                ->andWhere(['chori_bachat.fk_municipal_id' => $helper->getOrganization()])
                ->andWhere(['chori_bachat.payment_status' => 1])
                ->orderBy(['id'=>SORT_DESC])
                ->all();
                $multipleChhori = [new OtherMonthPayment()];
        return $this->renderPartial('deposit_multiple_all', [
                    'model' => $model,
                    'multipleChhori' => empty($multipleChhori) ? [new OtherMonthPayment()] : $multipleChhori,
                    'month'=>$month,
                    'year'=>$year,
                    'add_month'=>$add_month,
                    'models' => $models,
              
        ]);
    }
    public function actionDepositMultiple($month, $year,$add_month){
        $model = new PaymentChori();
        $helper = new Helper();
        $user_details=\app\models\Users::findone(['id'=>$helper->getUserId()]);
        $economic_year=\app\models\EconomicYear::find()->where(['status'=>1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
        $bank_id = \app\models\BankDetails::findone(['fk_municipal_id' => $helper->getOrganization()]);

        //var_dump($bank_id->id);die;
        $account_opened = (new \yii\db\Query())
                ->select('chori_bachat.id,chori_bachat.middle_name,chori_bachat.last_name,chori_bachat.unique_id,chori_bachat.dob,chori_bachat.tole_name,chori_bachat.father_name,chori_bachat.mobile_no,chori_bachat.created_date,chori_bachat.fk_per_district,chori_bachat.fk_per_municipal,chori_bachat.fk_ward,chori_bachat.verified_date,chori_bachat.name,chori_account_details.id as account_id,payment_chori.id as pid,payment_chori.fk_chori_bachat,bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name')
                ->from('chori_bachat')
                ->join('JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
                ->join('JOIN', 'bank_details', 'bank_details.id=chori_account_details.bank_name')
                ->join('JOIN', 'payment_chori', 'payment_chori.fk_chori_bachat=chori_bachat.id')
                ->Where(['chori_bachat.status' => 5])
                ->andWhere(['payment_chori.status' => 7])
                ->andWhere(['chori_account_details.bank_status'=>2])
                ->andWhere(['chori_bachat.fk_user_id' => $helper->getUserId()])
                ->andWhere(['chori_bachat.fk_municipal_id' => $helper->getOrganization()])
                ->andWhere(['chori_bachat.payment_status' => 1])
                ->orderBy(['id'=>SORT_DESC]);
                

                $pages = new \yii\data\Pagination(['totalCount' => $account_opened->count(), 'pageSize'=>20]);
                $models = $account_opened->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        //var_dump($account_opened);die;


        $multipleChhori = [new OtherMonthPayment()];
        if ($model->load(Yii::$app->request->post())) {
            
        }




        return $this->render('deposit_multiple', [
                    'model' => $model,
                    'account_opened' => $account_opened,
                    'multipleChhori' => empty($multipleChhori) ? [new OtherMonthPayment()] : $multipleChhori,
                    'month'=>$month,
                    'year'=>$year,
                    'add_month'=>$add_month,
                    'models' => $models,
                    'pages'=>$pages,
                    
        ]);
    }
    
    public function actionCheckUpdate($month,$year,$add_month){

        $model=new OtherMonthPayment();
        $user_id = yii::$app->user->id;
        $user_details = \app\models\Users::findOne(['id' => $user_id]);
        $update_month=$month;
        if ($model->load(Yii::$app->request->post())) {
            if(empty($model->bank)){
                Yii::$app->session->setFlash('message', 'बैंक सेलेक्ट गर्नुहोस !');
                return $this->render('check_update',[
                    'month'=>$month,
                    'year'=>$year,
                    'add_month'=>$add_month,
                    'model' => $model,
                    'mes'=>1,
                ]);
            }
            // else if(empty($model->check_update)){
                
            //     Yii::$app->session->setFlash('message', 'चेक नम्बर लेख्नुहोस !');
            //     return $this->render('check_update',[
            //         'month'=>$month,
            //         'year'=>$year,
            //         'add_month'=>$add_month,
            //         'model' => $model,
            //         'mes'=>0,
            //     ]);
            // }
            else{
            while($update_month<=$add_month){
                yii::$app->db->createcommand()
                ->update('other_month_payment',['fk_bank'=>$model->bank,'cheque_no'=>$model->check_update],[
                    'fk_user_id' => $user_id,'fk_municipal' => $user_details['fk_municipal_id'],'fk_province_id'=>$user_details['fk_province_id'],'fk_year'=> $year,'fk_month'=>$update_month
                ])
                ->execute();
                $update_month=$update_month+1;
            }
            return $this->redirect(['deposit-multiple','month'=>$month,'year'=>$year,'add_month'=>$add_month,]);
        }
        }
        // var_dump($)
        return $this->render('check_update',[
            'month'=>$month,
            'year'=>$year,
            'add_month'=>$add_month,
            'model' => $model,
            'mes'=>2,
        ]);
    }
    public function actionCheckUpdateInitial($initial_id){

        $model=new PaymentChori();
        $user_id = yii::$app->user->id;
        $user_details = \app\models\Users::findOne(['id' => $user_id]);
        if ($model->load(Yii::$app->request->post())) {
            if(empty($model->bank_list)){
                Yii::$app->session->setFlash('message', 'बैंक सेलेक्ट गर्नुहोस !');
                return $this->render('check_update_initial',[
                    'model' => $model,
                    'mes'=>1,
                    'initial_id'=>$initial_id,
                ]);
            }
            // else if(empty($model->cheque)){
                
            //     Yii::$app->session->setFlash('message', 'चेक नम्बर लेख्नुहोस !');
            //     return $this->render('check_update_initial',[
            //         'model' => $model,
            //         'mes'=>0,
            //         'initial_id'=>$initial_id,
            //     ]);
            // }
            else{
                yii::$app->db->createcommand()
                ->update('payment_chori',['fk_bank_details'=>$model->bank_list,'cheque_no'=>$model->cheque],[
                    'fk_user_id' => $user_id,'fk_municipal' => $user_details['fk_municipal_id'],'fk_province_id'=>$user_details['fk_province_id'],'fk_initial'=>$initial_id
                ])
                ->execute();
                yii::$app->db->createcommand()
                ->update('initial',['fk_bank'=>$model->bank_list],[
                    'fk_user' => $user_id,'fk_municipal' => $user_details['fk_municipal_id'],'fk_province_id'=>$user_details['fk_province_id'],'id'=>$initial_id
                ])
                ->execute();
            
            return $this->redirect(['initial-deposit','initial_id'=>$initial_id]);
        }
        }
        // var_dump($)
        return $this->render('check_update_initial',[
            'model' => $model,
            'mes'=>2,
            'initial_id'=>$initial_id,
        ]);
    }

    public function actionConfirmAll($month, $year,$multi_month){
        $model = new PaymentChori();
        $helper = new Helper();
        $economic_year=\app\models\EconomicYear::find()->where(['id'=>$year])->one();
        $final_date=array();
        if($multi_month){
        $converted_month=$this->actionDateToMonth($multi_month);
        $converted_year=$this->actionConvertFiscalYear($multi_month);
        if($converted_month<10){
        array_push($final_date,$converted_year.'-'.'0'.$converted_month.'-'.'32');
        }
        else{
            array_push($final_date,$converted_year.'-'.$converted_month.'-'.'32');
        }
    
    }else{
        $converted_month=$this->actionDateToMonth($month);
        $converted_year=$this->actionConvertFiscalYear($month);
        if($converted_month<10){
        array_push($final_date,$converted_year.'-'.'0'.$converted_month.'-'.'32');
        }
        else{
            array_push($final_date,$converted_year.'-'.$converted_month.'-'.'32');
        }
        
    }
        $user_details=\app\models\Users::findone(['id'=>$helper->getUserId()]);
        $bank_id = \app\models\BankDetails::findone(['fk_municipal_id' => $helper->getOrganization()]);

        //var_dump($bank_id->id);die;
        $models = (new \yii\db\Query())
                ->select('chori_bachat.id,chori_bachat.middle_name,chori_bachat.last_name,chori_bachat.unique_id,chori_bachat.dob,chori_bachat.tole_name,chori_account_details.account_open_date,chori_bachat.father_name,chori_bachat.mobile_no,chori_bachat.created_date,chori_bachat.fk_per_district,chori_bachat.fk_per_municipal,chori_bachat.fk_ward,chori_bachat.verified_date,chori_bachat.name,chori_account_details.id as account_id,payment_chori.id as pid,payment_chori.fk_chori_bachat,bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name')
                ->from('chori_bachat')
                ->join(' JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
                ->join(' JOIN', 'bank_details', 'bank_details.id=chori_account_details.bank_name')
                ->join(' JOIN', 'payment_chori', 'payment_chori.fk_chori_bachat=chori_bachat.id')
                ->Where(['chori_bachat.status' => 5])
                // ->andWhere(['<=','chori_bachat.verified_date',$final_date[0]])
                ->andWhere(['or',['payment_chori.status' => 6],['payment_chori.status' => 7]])
                ->andWhere(['chori_account_details.bank_status'=>2])
                ->andWhere(['chori_bachat.fk_user_id' => $helper->getUserId()])
                ->andWhere(['chori_bachat.fk_municipal_id' => $helper->getOrganization()])
                ->andWhere(['chori_bachat.payment_status' => 1])
                ->orderBy(['id'=>SORT_DESC])
                ->all();

                $multipleChhori = [new OtherMonthPayment()];

        return $this->renderPartial('confirm_multiple_all', [
                    'model' => $model,
                    'models' => $models,
                    'multipleChhori' => empty($multipleChhori) ? [new OtherMonthPayment()] : $multipleChhori,
                    'month'=>$month,
                    'year'=>$year,
                    'multi_month'=>$multi_month,
                    'final_date'=>$final_date[0],
                    
        ]);
        
    }
    public function actionConfirm($month, $year,$multi_month){
        // var_dump($month);die;
        $model = new PaymentChori();
        $helper = new Helper();
        $economic_year=\app\models\EconomicYear::find()->where(['id'=>$year])->one();
        $final_date=array();
        if($multi_month){
        $converted_month=$this->actionDateToMonth($multi_month);
        $converted_year=$this->actionConvertFiscalYear($multi_month);
        if($converted_month<10){
        array_push($final_date,$converted_year.'-'.'0'.$converted_month.'-'.'32');
        }
        else{
            array_push($final_date,$converted_year.'-'.$converted_month.'-'.'32');
        }
        // var_dump($final_date);die;
    }else{
        $converted_month=$this->actionDateToMonth($month);
        $converted_year=$this->actionConvertFiscalYear($month);
        if($converted_month<10){
        array_push($final_date,$converted_year.'-'.'0'.$converted_month.'-'.'32');
        }
        else{
            array_push($final_date,$converted_year.'-'.$converted_month.'-'.'32');
        }
        
    }
        $user_details=\app\models\Users::findone(['id'=>$helper->getUserId()]);
        $bank_id = \app\models\BankDetails::findone(['fk_municipal_id' => $helper->getOrganization()]);

        //var_dump($bank_id->id);die;
        $account_opened = (new \yii\db\Query())
                ->select('chori_bachat.id,chori_bachat.middle_name,chori_bachat.last_name,chori_bachat.unique_id,chori_bachat.birth_certificate_date,chori_bachat.dob,chori_bachat.tole_name,chori_bachat.father_name,chori_bachat.mobile_no,chori_bachat.created_date,chori_bachat.fk_per_district,chori_bachat.fk_per_municipal,chori_bachat.fk_ward,chori_bachat.verified_date,chori_bachat.name,chori_account_details.id as account_id,chori_account_details.account_open_date,payment_chori.id as pid,payment_chori.fk_chori_bachat,bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name')
                ->from('chori_bachat')
                ->join(' JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
                ->join(' JOIN', 'bank_details', 'bank_details.id=chori_account_details.bank_name')
                ->join(' JOIN', 'payment_chori', 'payment_chori.fk_chori_bachat=chori_bachat.id')
                ->Where(['chori_bachat.status' => 5])
                // ->andWhere(['<=','chori_bachat.verified_date',$final_date[0]])
                ->andWhere(['or',['payment_chori.status' => 6],['payment_chori.status' => 7]])
                ->andWhere(['chori_account_details.bank_status'=>2])
                ->andWhere(['chori_bachat.fk_user_id' => $helper->getUserId()])
                ->andWhere(['chori_bachat.fk_municipal_id' => $helper->getOrganization()])
                ->andWhere(['chori_bachat.payment_status' => 1])
                ->orderBy(['id'=>SORT_DESC]);
                
        //var_dump($account_opened);die;


        $multipleChhori = [new OtherMonthPayment()];
        if ($model->load(Yii::$app->request->post())) {
            if(empty($model->bank_list)){
                Yii::$app->session->setFlash('message', 'बैंक सेलेक्ट गर्नुहोस !');
                $pages = new \yii\data\Pagination(['totalCount' => $account_opened->count(), 'pageSize'=>20]);
                $models = $account_opened->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
                return $this->render('confirm_multiple', [
                            'model' => $model,
                            'models' => $models,
                            'pages'=>$pages,
                            'account_opened' => $account_opened,
                            'multipleChhori' => empty($multipleChhori) ? [new OtherMonthPayment()] : $multipleChhori,
                            'month'=>$month,
                            'year'=>$year,
                            'multi_month'=>$multi_month,
                            'final_date'=>$final_date[0],
                            'mes'=>1,
                            // 'check_date'=>$final_date,
                            
                ]);
            }
            else if(empty($model->cheque)){
                Yii::$app->session->setFlash('message', 'चेक नम्बर लेख्नुहोस !');
                $pages = new \yii\data\Pagination(['totalCount' => $account_opened->count(), 'pageSize'=>20]);
                $models = $account_opened->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
                return $this->render('confirm_multiple', [
                            'model' => $model,
                            'models' => $models,
                            'pages'=>$pages,
                            'account_opened' => $account_opened,
                            'multipleChhori' => empty($multipleChhori) ? [new OtherMonthPayment()] : $multipleChhori,
                            'month'=>$month,
                            'year'=>$year,
                            'multi_month'=>$multi_month,
                            'final_date'=>$final_date[0],
                            'mes'=>0,
                            // 'check_date'=>$final_date,
                            
                ]);
            }
            else{
            $add_month=(int)($model->add_month);// add_month ending month
            $fk_month=(int)$model->fk_month; //fk_month starting month
            $final_date1=array();
            $converted_month1=$this->actionDateToMonth($add_month);
            $converted_year1=$this->actionConvertFiscalYear($add_month);
            if($converted_month1<10){
            array_push($final_date1,$converted_year1.'-'.'0'.$converted_month1.'-'.'32');
            }
            else{
                array_push($final_date1,$converted_year1.'-'.$converted_month1.'-'.'32');
            }
            
            


            
            //var_dump($multipleChhori->fk_economic_year);die;
            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                                ActiveForm::validateMultiple($multipleChhori),
                                ActiveForm::validate($model)
                );
            }
            
            if($add_month){
                while($fk_month <= $add_month){

                    // var_dump($add_month);die;
          
            $multipleChhori = Model::createMultiple(OtherMonthPayment::classname());
        //var_dump($multipleChhori);die;

            Model::loadMultiple($multipleChhori, Yii::$app->request->post());
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                foreach ($multipleChhori as $modelAddress) {  
                    if($modelAddress->fk_payment_chori==null){
                        break;
                    }
                    $verified_year=explode('-',$modelAddress->verified);
                    $verified_year_month=$verified_year[1];
                    $insert_year=explode('-',$final_date1[0]);
                    $new_verified_month=$this->actionNormaltoFiscal($verified_year_month);
                    $final_verified_month=array();
                    if($new_verified_month<10){
                        array_push($final_verified_month,'0'.$new_verified_month);
                    }else{
                        array_push($final_verified_month,$new_verified_month);
                    }
                
                $chhori_name=\app\models\ChoriBachat::findone(['id'=>$modelAddress->fk_chori_bachat]);

                // var_dump($chhori_name['name']);die;   
                // var_dump($fk_month);die;   
                if((int)$verified_year[0]==(int)$insert_year[0]){ 
                    if($final_verified_month[0]<10){
                
                if((int)$final_verified_month[0] > (int)$fk_month){
                    $modelAddress->amount=0;
                }else{
                    $modelAddress->amount=$modelAddress->amount;
                    Yii::$app->db->createCommand()
                    ->update('payment_chori',['status'=>7],
                    ['fk_user_id' => $helper->getUserId(),'fk_municipal' => $helper->getOrganization(),'id'=>$modelAddress->fk_payment_chori])
                    ->execute();
                    $modelAddress->created_date=$helper->actionNepaliDate();
                    // var_dump($modelAddress->amount);die;
                    $modelAddress->fk_user_id = $helper->getUserId();
                    $modelAddress->fk_municipal = $helper->getOrganization();
                    $modelAddress->fk_month = $fk_month;
                    $modelAddress->fk_year = $year;
                    $modelAddress->fk_bank=$model->bank_list;
                    $modelAddress->cheque_no=$model->cheque;
                    $modelAddress->fk_province_id=$user_details['fk_province_id'];
                    $modelAddress->fk_district_id=$user_details['fk_district_id'];
                                if (!($flag = $modelAddress->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }

                } 
            }
                else{
                        $modelAddress->amount=$modelAddress->amount;
                        Yii::$app->db->createCommand()
                        ->update('payment_chori',['status'=>7],
                        ['fk_user_id' => $helper->getUserId(),'fk_municipal' => $helper->getOrganization(),'id'=>$modelAddress->fk_payment_chori])
                        ->execute();
                        $modelAddress->created_date=$helper->actionNepaliDate();
                        // var_dump($modelAddress->amount);die;
                        $modelAddress->fk_user_id = $helper->getUserId();
                        $modelAddress->fk_municipal = $helper->getOrganization();
                        $modelAddress->fk_month = $fk_month;
                        $modelAddress->fk_year = $year;
                        $modelAddress->fk_bank=$model->bank_list;
                        $modelAddress->cheque_no=$model->cheque;
                        $modelAddress->fk_province_id=$user_details['fk_province_id'];
                        $modelAddress->fk_district_id=$user_details['fk_district_id'];
                                    if (!($flag = $modelAddress->save(false))) {
                                        $transaction->rollBack();
                                        break;
                                    }
                    
                }
            }
            else if((int)$verified_year[0]<(int)$insert_year[0]){
                // var_dump($chhori_name['name']);die;
                // var_dump("3 condition");die;
                $modelAddress->amount=$modelAddress->amount;
                Yii::$app->db->createCommand()
                ->update('payment_chori',['status'=>7],
                ['fk_user_id' => $helper->getUserId(),'fk_municipal' => $helper->getOrganization(),'id'=>$modelAddress->fk_payment_chori])
                ->execute();
                $modelAddress->created_date=$helper->actionNepaliDate();
                // var_dump($modelAddress->amount);die;
                $modelAddress->fk_user_id = $helper->getUserId();
                $modelAddress->fk_municipal = $helper->getOrganization();
                $modelAddress->fk_month = $fk_month;
                $modelAddress->fk_year = $year;
                $modelAddress->fk_bank=$model->bank_list;
                $modelAddress->cheque_no=$model->cheque;
                $modelAddress->fk_province_id=$user_details['fk_province_id'];
                $modelAddress->fk_district_id=$user_details['fk_district_id'];
                            if (!($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                            }

                
            }else{
                // var_dump($chhori_name['name']);die;
                continue;
            }
                        
            // var_dump('forloop 1 end');die;   
                       
                    } 
                    $fk_month=$fk_month + 1;
                    //var_dump($add_month) ;die;
                    //var_dump($fk_month);die;
                    
                    $transaction->commit();
                    
            }
        
             catch (Exception $e) {
                $transaction->rollBack();
            }
                        
                        
                        
                    
                    
                    
                    
    
        }
    
        return $this->redirect(array('confirm','month'=>$month,'year'=>$year,'multi_month'=>$multi_month));
    }
    else{
        $multipleChhori = Model::createMultiple(OtherMonthPayment::classname());
            //var_dump($multipleChhori);die;

        Model::loadMultiple($multipleChhori, Yii::$app->request->post());
        $transaction = \Yii::$app->db->beginTransaction();
        try{
        foreach ($multipleChhori as $modelAddress) {
            if($modelAddress->fk_payment_chori==null){
                break;
            }
            $nextpay= OtherMonthPayment::find()
                    ->andWhere(['fk_user_id' => $helper->getUserId()])
                    ->andWhere(['fk_municipal' => $helper->getOrganization()])
                    ->andWhere(['fk_month' => $month])
                    ->andWhere(['fk_year' => $year])
                    ->andWhere(['fk_payment_chori'=>$modelAddress->fk_payment_chori])
                    ->all();
                    Yii::$app->db->createCommand()
                            ->update('payment_chori',['status'=>7],
                            ['fk_user_id' => $helper->getUserId(),'fk_municipal' => $helper->getOrganization(),'id'=>$modelAddress->fk_payment_chori])
                            ->execute();
                    if($nextpay){
                            Yii::$app->db->createCommand()
                            ->update('other_month_payment',['amount'=>$modelAddress->amount],
                            ['fk_user_id' => $helper->getUserId(),'fk_municipal' => $helper->getOrganization(),'fk_month' => $month,'fk_year' => $year,'fk_payment_chori'=>$modelAddress->fk_payment_chori])
                            ->execute();
                        
                    }
                    else{
            //var_dump($multipleChhori);die;
                if($modelAddress->amount){
                $modelAddress->amount=$modelAddress->amount;}
                else if($modelAddress->amount=='0'){
                    break;
                }
                else{
                    break;
                }
                    $modelAddress->created_date=$helper->actionNepaliDate();
                    // var_dump($modelAddress->amount);die;
                    $modelAddress->fk_user_id = $helper->getUserId();
                    $modelAddress->fk_municipal = $helper->getOrganization();
                    $modelAddress->fk_month = $month;
                    $modelAddress->fk_year = $year;
                    $modelAddress->fk_bank=$model->bank_list;
                    $modelAddress->cheque_no=$model->cheque;
                    $modelAddress->fk_province_id=$user_details['fk_province_id'];
                    $modelAddress->fk_district_id=$user_details['fk_district_id'];
                    if (!($flag = $modelAddress->save(false))) {
                        $transaction->rollBack();
                        break;
                    }
                    }
                }
                
            
                    $transaction->commit();
                    return $this->redirect(array('confirm','month'=>$month,'year'=>$year,'multi_month'=>$multi_month));
                
                
    }
    catch (Exception $e) {
        $transaction->rollBack();
    }
    }
            }
}
        $pages = new \yii\data\Pagination(['totalCount' => $account_opened->count(), 'pageSize'=>20]);
        $models = $account_opened->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        return $this->render('confirm_multiple', [
                    'model' => $model,
                    'models' => $models,
                    'pages'=>$pages,
                    'account_opened' => $account_opened,
                    'multipleChhori' => empty($multipleChhori) ? [new OtherMonthPayment()] : $multipleChhori,
                    'month'=>$month,
                    'year'=>$year,
                    'multi_month'=>$multi_month,
                    'final_date'=>$final_date[0],
                    'mes'=>2,
                    // 'check_date'=>$final_date,
                    
        ]);
    }  

    public function actionTable(){

        $model = new PaymentChori();
        $helper = new Helper();
        $bank_id = \app\models\BankDetails::findone(['fk_municipal_id' => $helper->getOrganization()]);
        $user_details=\app\models\Users::findone(['id'=>$helper->getUserId()]);
        $economic_year=\app\models\EconomicYear::find()->where(['status'=>1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
        //var_dump($bank_id->id);die;
        $models = (new \yii\db\Query())
                ->select('chori_bachat.id,chori_bachat.unique_id,chori_bachat.fk_month as month,chori_account_details.account_open_date,chori_account_details.fk_year,chori_bachat.name,chori_account_details.id as account_id,bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name')
                ->from('chori_bachat')
                ->join('JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
                ->join('JOIN', 'bank_details', 'bank_details.id=chori_account_details.bank_name')
                ->where(['chori_bachat.status'=>2])
                ->andWhere(['chori_account_details.bank_status'=>2])
                ->andWhere(['chori_bachat.fk_user_id' => $helper->getUserId()])
                ->andWhere(['chori_bachat.fk_municipal_id' => $helper->getOrganization()])
                ->andWhere(['chori_bachat.payment_status' => 1])
                ->all();
                
            
            return $this->renderPartial('all_form', [
                'model' => $model,
                'multipleChhori' => empty($multipleChhori) ? [new PaymentChori()] : $multipleChhori,
                'models'=>$models,
                
                
                
    ]);
        //var_dump($account_opened['bank_id']);die;


        $multipleChhori = [new PaymentChori()];
    }
    public function actionReport($initial_id){
        $user_id = yii::$app->user->id;
        $user_details = \app\models\Users::findOne(['id' => $user_id]);
        $models=\app\models\PaymentChori::find()->where(['fk_user_id' => $user_id])->andWhere(['fk_municipal' => $user_details->fk_municipal_id])->andWhere(['fk_initial' => $initial_id])->all();
        
        return $this->renderPartial('initial_deposit_all',[
            'user_id'=>$user_id,
            'user_details'=>$user_details,
            'models'=>$models,
            'initial_id'=>$initial_id,
        ]);
    }
    public function actionInitialVerified(){
        $model = new PaymentChori();
        $user = yii::$app->user->id;
        $user_details = \app\models\Users::findOne(['id' => $user]);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->pin == $user_details['authkey']) {
                
                return $this->redirect(['create']);
                
            } else {

                Yii::$app->session->setFlash('message', 'Password does not match !');
                return $this->render('initial_verified', [
                            'model' => $model,
                ]);
            }
        }
        return $this->render('initial_verified', [
            'model' => $model,
        ]);
    }
    public function actionMultipleVerified(){
        $model = new PaymentChori();
        $user = yii::$app->user->id;
        $user_details = \app\models\Users::findOne(['id' => $user]);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->pin == $user_details['authkey']) {
                
                return $this->redirect(['multifind']);
                
            } else {

                Yii::$app->session->setFlash('message', 'Password does not match !');
                return $this->render('initial_verified', [
                            'model' => $model,
                ]);
            }
        }
        return $this->render('initial_verified', [
            'model' => $model,
        ]);
    }
    
    public function actionCreate() {
        $model = new PaymentChori();
        $helper = new Helper();
        $bank_id = \app\models\BankDetails::find()->where(['fk_municipal_id' => $helper->getOrganization()])->andWhere(['status'=>1])->one();
        $user_details=\app\models\Users::findone(['id'=>$helper->getUserId()]);
        $economic_year=\app\models\EconomicYear::find()->where(['status'=>1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
        $submit_year=\app\models\Year::findone(['id'=>$economic_year['economic_year']]);
        $money=\app\models\MoneySet::find()->where(['fk_user_id' => $user_details['id']])->andWhere(['fk_municipal_id' => $user_details->fk_municipal_id])->andWhere(['status'=>1])->one();
        // var_dump($money['initial_payment']);die;
        $account_opened = (new \yii\db\Query())
                ->select('chori_bachat.id,chori_bachat.middle_name,chori_bachat.last_name,chori_bachat.unique_id,chori_bachat.fk_month as month,chori_bachat.name,chori_account_details.id as account_id,bank_details.id as bank_id,chori_account_details.account_no,chori_account_details.account_open_date,chori_account_details.fk_year,bank_details.bank_name')
                ->from('chori_bachat')
                ->join('JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
                ->join('JOIN', 'bank_details', 'bank_details.id=chori_account_details.bank_name')
                ->where(['chori_bachat.status'=>2])
                ->andWhere(['chori_account_details.bank_status'=>2])
                ->andWhere(['chori_bachat.fk_user_id' => $helper->getUserId()])
                ->andWhere(['chori_bachat.payment_status' => 1])
                ->andWhere(['chori_bachat.fk_municipal_id' => $helper->getOrganization()]);
                
            $pages = new \yii\data\Pagination(['totalCount' => $account_opened->count(),'pageSize'=>20]);
            $models = $account_opened->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
            
        // var_dump($account_opened);die;


        $multipleChhori = [new PaymentChori()];
        $today = $helper->actionNepaliDate();

        $explode_today = explode('-', $today);
     
        $year = $explode_today[0];
        $month = $explode_today[1];
        if ($model->load(Yii::$app->request->post())) {
            if(empty($model->bank_request)){
                Yii::$app->session->setFlash('message', 'बैंक सेलेक्ट गर्नुहोस !');
                return $this->render('create', [
                    'model' => $model,
                    'account_opened' => $account_opened,
                    'multipleChhori' => empty($multipleChhori) ? [new PaymentChori()] : $multipleChhori,
                    'models'=>$models,
                    'pages'=>$pages,
                    'bank'=>1,
             ]);
            }
            else if(empty($model->cheque_no)){
                Yii::$app->session->setFlash('message', 'चेक नम्बर लेख्नुहोस !');
                return $this->render('create', [
                    'model' => $model,
                    'account_opened' => $account_opened,
                    'multipleChhori' => empty($multipleChhori) ? [new PaymentChori()] : $multipleChhori,
                    'models'=>$models,
                    'pages'=>$pages,
                    'bank'=>0,
             ]);
            }
            else if(($money['initial_payment']==null)){
                Yii::$app->session->setFlash('message', 'कृपया सेटिंगमा पहिलो महिनाको भुक्तान गर्ने रकम सेट गर्नुहोस !');
                return $this->render('create', [
                    'model' => $model,
                    'account_opened' => $account_opened,
                    'multipleChhori' => empty($multipleChhori) ? [new PaymentChori()] : $multipleChhori,
                    'models'=>$models,
                    'pages'=>$pages,
                    'bank'=>3,
             ]);
            }
            else{
            $multipleChhori = Model::createMultiple(PaymentChori::classname());
            //var_dump($multipleChhori);die;
            Model::loadMultiple($multipleChhori, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                                ActiveForm::validateMultiple($multipleChhori),
                                ActiveForm::validate($model)
                );
            }
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $initial_year=\app\models\Initial::find()->where(['fk_year'=>$economic_year['economic_year']])->andWhere(['fk_user'=>$user_details['id']])->andWhere(['fk_municipal'=>$user_details['fk_municipal_id']])->all();
                $initial=new \app\models\Initial();
                $initial->fk_year=$economic_year['economic_year'];
                $initial->fk_province_id=$user_details['fk_province_id'];
                $initial->fk_user=$user_details['id'];
                $initial->fk_municipal=$user_details['fk_municipal_id'];
                $initial->fk_district=$user_details['fk_district_id'];
                $initial->created_date=$helper->actionNepaliDate();
                $initial->fk_bank=$model->bank_request;
                $initial->status=1;
                if(!$initial_year){
                    // $initial->payment_id=$submit_year.'-'.000;
                }
                $count=000001;
                if($initial_year){
                    foreach($initial_year as $latest){
                        $uid=$latest['payment_id'];
                    }
                    $split_uid=explode("-",$uid);
                    $new_count=$split_uid[1]+1;
                    $initial->payment_id=$submit_year['economic_year'].'-'.$new_count;
                }
                else{
                    $initial->payment_id=$submit_year['economic_year'].'-'.$count;
                }
                if($flag=$initial->save(false)){
                // var_dump($initial->id);die;
                foreach ($multipleChhori as $modelAddress) {
                    if ($modelAddress->fk_chori_bachat) {

                        $payment_check=PaymentChori::findone(['fk_chori_bachat'=>$modelAddress->fk_chori_bachat]);
                        if(empty($payment_check)){
                        $xori = \app\models\ChoriBachat::findOne(['id' => $modelAddress->fk_chori_bachat]);
                        $economicYear= \app\models\EconomicYear::find()->where(['status'=>1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
                        $economic_year_id=$economicYear->economic_year;
                        Yii::$app->db->createCommand()
                        ->update('chori_bachat',['status'=>5],
                        ['id'=>$modelAddress->fk_chori_bachat])
                        ->execute();
                        // var_dump($modelAddress->amount);die;
                        $modelAddress->fk_economic_year = $economic_year_id;
                        //var_dump($modelAddress->fk_month);die;
                        $modelAddress->fk_bank_details = $model->bank_request;
                        // $modelAddress->post_date = $helper->actionNepaliDate();
                        $modelAddress->fk_user_id = $helper->getUserId();
                        $modelAddress->fk_municipal = $helper->getOrganization();
                        // $modelAddress->created_date = $helper->actionNepaliDate();
                        $modelAddress->date = $helper->actionNepaliDate();
                        $modelAddress->status=6;
                        $modelAddress->bank_request=$model->bank_request;
                        $modelAddress->cheque_no=$model->cheque_no;
                        $modelAddress->fk_province_id=$user_details['fk_province_id'];
                        $modelAddress->fk_district_id=$user_details['fk_district_id'];
                        $modelAddress->fk_initial=$initial->id;


                        if (!($flag = $modelAddress->save(false))) {
                            $transaction->rollBack();
                            break;
                        }
                      }
                    }
                }
            }
                if ($flag) {
                    $transaction->commit();
                    return $this->redirect(['create']);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
        }

        if(($money['initial_payment']==null)){
            Yii::$app->session->setFlash('message', 'कृपया सेटिंगमा भुक्तान गर्ने रकम सेट गर्नुहोस !');
            return $this->render('create', [
                'model' => $model,
                'account_opened' => $account_opened,
                'multipleChhori' => empty($multipleChhori) ? [new PaymentChori()] : $multipleChhori,
                'models'=>$models,
                'pages'=>$pages,
                'bank'=>3,
         ]);
        }else{
        return $this->render('create', [
                    'model' => $model,
                    'account_opened' => $account_opened,
                    'multipleChhori' => empty($multipleChhori) ? [new PaymentChori()] : $multipleChhori,
                    'models'=>$models,
                    'pages'=>$pages,
                    'bank'=>2,
                    
                    
        ]);
        }
    }

    /**
     * Updates an existing PaymentChori model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PaymentChori model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionDateToMonth($month){
        $result = 0;
        if($month==1){
            $result = 4;
        }else if($month==2){
             $result = 5;
        }else if($month==3){
             $result = 6;
        }else if($month==4){
             $result = 7;
        }else if($month==5){
             $result = 8;
        }else if($month==6){
             $result = 9;
        }else if($month==7){
             $result = 10;
        }else if($month==8){
             $result = 11;
        }else if($month==9){
             $result = 12;
        }else if($month==10){
             $result = 1;
        }else if($month==11){
             $result = 2;
        }else if($month==12){
             $result = 3;
        }
        return $result;
    }

    public function actionNormaltoFiscal($month){
        $result = 0;
        if($month==4){
            $result = 1;
        }else if($month==5){
             $result = 2;
        }else if($month==6){
             $result = 3;
        }else if($month==7){
             $result = 4;
        }else if($month==8){
             $result = 5;
        }else if($month==9){
             $result = 6;
        }else if($month==10){
             $result = 7;
        }else if($month==11){
             $result = 8;
        }else if($month==12){
             $result = 9;
        }else if($month==1){
             $result = 10;
        }else if($month==2){
             $result = 11;
        }else if($month==3){
             $result = 12;
        }
        return $result;
    }

    /**
     * Finds the PaymentChori model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PaymentChori the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PaymentChori::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
