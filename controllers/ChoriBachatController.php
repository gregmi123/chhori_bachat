<?php

namespace app\controllers;

use Yii;
use app\models\ChoriBachat;
use app\models\ChoriBachatSearch;
use app\models\ChoriBachatDelete;
use app\models\ChoriBachatSearchRequest;
use yii\web\Controller;
use app\models\Users;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use app\models\ChoriAccountDetails;
use kartik\mpdf\Pdf;
use app\models\EconomicYear;
use app\models\Province;
use app\models\District;
use app\models\Municipals;
use app\models\BankDetails;
use app\models\PaymentChori;
use app\models\Initial;
use app\models\OtherMonthPayment;
use \app\models\Ward;



/**
 * ChoriBachatController implements the CRUD actions for ChoriBachat model.
 */
class ChoriBachatController extends Controller {

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
     * Lists all ChoriBachat models.
     * @return mixed
     */

    public function actionIndex() {

        $searchModel = new ChoriBachatSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //var_dump($dataProvider);die;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDeleteList($ids) {

        $explode_ids = explode(',', $ids);
        $bank_chhori_data = ChoriBachat::findAll(['id' => $explode_ids]);

        foreach ($bank_chhori_data as $data1) {
            $data1['payment_status'] = 2;

            $data1->save(false);
        }    

        return $this->redirect(['index']);
    }

    public function actionResetList($ids) {

        $explode_ids = explode(',', $ids);
        $bank_chhori_data = ChoriBachat::findAll(['id' => $explode_ids]);

        foreach ($bank_chhori_data as $data1) {
            $data1['payment_status'] = 1;

            $data1->save(false);
        }    

        return $this->redirect(['delete-index']);
    }

    public function actionDeleteIndex() {

        $searchModel = new ChoriBachatDelete();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //var_dump($dataProvider);die;
        return $this->render('delete_list', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDeleteChhori($ids){

        $explode_ids = explode(',', $ids);
        $bank_chhori_data = ChoriBachat::findAll(['id' => $explode_ids]);

        foreach ($bank_chhori_data as $data1) {
            Yii::$app
            ->db
            ->createCommand()
            ->delete('other_month_payment', ['fk_chori_bachat' => $data1['id']])
            ->execute();

            Yii::$app
            ->db
            ->createCommand()
            ->delete('payment_chori', ['fk_chori_bachat' => $data1['id']])
            ->execute();

            Yii::$app
            ->db
            ->createCommand()
            ->delete('withdraw', ['fk_chori' => $data1['id']])
            ->execute();

            Yii::$app
            ->db
            ->createCommand()
            ->delete('chori_account_details', ['fk_chori_bachat' => $data1['id']])
            ->execute();

            Yii::$app
            ->db
            ->createCommand()
            ->delete('chori_bachat', ['id' => $data1['id']])
            ->execute();
        } 

        return $this->redirect(['delete-index']);
    }

    public function actionRequestIndex() {

        $helper = new Helper();
        $searchModel = new ChoriBachatSearch(['status' => 3, 'fk_municipal_id' => $helper->getOrganization()]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        //var_dump($dataProvider);die;
        return $this->render('request_index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }


    public function actionSinglePayment() {
        
        

        return $this->render('first_payment', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFileUpload(){
        $model = new ChoriBachat();
        $helper=new Helper();
        $user_details=\app\models\Users::findone(['id'=>$helper->getUserId()]);
        $cheque_no=rand();

        $active_economic_year=\app\models\EconomicYear::find()->where(['fk_province_id'=>$user_details['fk_province_id']])->andWhere(['status'=>1])->one();
        $active_year=\app\models\Year::findOne(['id'=>$active_economic_year['economic_year']]);

        $eng_date = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $nepali_date = array('०','१', '२', '३', '४', '५', '६', '७', '८', '९');

        if ($model->load(Yii::$app->request->post())) {

            $initial=new Initial();

            $model->file_upload = UploadedFile::getInstance($model, 'file_upload');
            if(empty($model->file_upload)){
                Yii::$app->session->setFlash('message','कृपया फाइल अपलोड गर्नुहोस');
                return $this->render('file_upload',[
                    'model'=>$model,
                ]);
            }
            $tfile = Yii::getAlias('@webroot/files/' . uniqid() . '.' . $model->file_upload->extension);
            $model->file_upload->saveAs($tfile, false);
            $inputFile = $tfile;
            try {
                $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFile);
            } catch (yii\base\Exception $e) {
                die('error');
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            // var_dump($sheet);die;
            $transaction = Yii::$app->db->beginTransaction();
            $flag = true;
            //$errors = [];
            for ($row = 1; $row <= $highestRow; $row++) {

                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, Null, true, false);

                if ($row == 1) {
                    continue;
                }
                if($rowData[0][1]==null && $rowData[0][2]==null && $rowData[0][3]==null && $rowData[0][4]==null && $rowData[0][5]==null && $rowData[0][6]==null && $rowData[0][7]==null ){
                    continue;
                }
                if ($rowData) {
                    // var_dump($rowData[0][1]);die;
                    if($rowData[0][1]==" " || $rowData[0][1]==null || empty($rowData[0][1])){
                        Yii::$app->session->setFlash('message',$row.' row को नाम खालि छ |');
                        return $this->render('file_upload',[
                            'model'=>$model,
                        ]);
                    }
                    else if($rowData[0][5]==" " || $rowData[0][5]==null || empty($rowData[0][5])){
                        Yii::$app->session->setFlash('message',$row.' row को '.$rowData[0][1].'को जन्म मिति खालि छ |');
                        return $this->render('file_upload',[
                            'model'=>$model,
                        ]);
                    }else if($rowData[0][3]==" " || $rowData[0][5]==null || empty($rowData[0][3])){
                        Yii::$app->session->setFlash('message',$row.' row को '.$rowData[0][1].'को खाता न. खालि छ |');
                        return $this->render('file_upload',[
                            'model'=>$model,
                        ]);
                    }
                    else if($rowData[0][4]==" " || $rowData[0][5]==null || empty($rowData[0][4])){
                        Yii::$app->session->setFlash('message',$row.' row को '.$rowData[0][1].'को बैंकको नाम खालि छ |');
                        return $this->render('file_upload',[
                            'model'=>$model,
                        ]);
                    }
                    
                    $money=\app\models\MoneySet::find()->where(['status'=>1])->andWhere(['fk_user_id'=>$user_details['id']])->one();
                    
                    if(empty($money)){
                        Yii::$app->session->setFlash('message','कृपया सेट्टिङ्गमा भुक्तानी गर्नुपर्ने रकम सेट गर्नुहोस |');
                        return $this->render('file_upload',[
                            'model'=>$model,
                        ]);
                    }
                    
                    $fk_year=null;

                    
                    $address=trim($rowData[0][2]);
                    $address_array=explode(" ",$address);
                    $address_count=count($address_array);

                    if($address_count==3){
                    $ward=(str_replace($nepali_date, $eng_date,$address_array[1]));

                    $ward_name=\app\models\Ward::find()->Where(['fk_user_id'=>$user_details['id']])->andWhere(['fk_municipal_id'=>$user_details['fk_municipal_id']])->andWhere(['ward_name'=>$ward])->one();
                    if($ward_name){
                        $ward_id=$ward_name['id'];
                    }else{
                        $ward_object=new Ward();
                        $ward_object->ward_name=$ward;
                        $ward_object->fk_user_id=$user_details['id'];
                        $ward_object->fk_municipal_id=$user_details['fk_municipal_id'];
                        $ward_object->created_date=$helper->actionNepaliDate();
                        if($ward_object->save($flag==false)){
                            $ward_id=$ward_object->id;
                        }
                    }
                    }else{
                        Yii::$app->session->setFlash('message',$row.' row को '.$rowData[0][1].'को ठेगाना मिलेको छैन |');
                        return $this->render('file_upload',[
                            'model'=>$model,
                        ]);
                    }

                    $new_date=trim((str_replace($nepali_date, $eng_date,$rowData[0][5])));

                    // var_dump($new_date);die;
                    if(strlen($rowData[0][5])==5){
                        $excelDate = $new_date; 
                        $exact_date = ($excelDate - (25567 + 2)) * 86400 ;
                        $exact_date=date("Y-m-d", $exact_date);
                    }else{
                        $exact_date=$new_date;
                    }

                    if(strpos($exact_date,'/') !== false){
                        $birth_date=str_replace("/","-",$exact_date);
                        $date_array=explode("/",$exact_date);
                    } 
                    else if(strpos($exact_date,'-') !== false){
                        $birth_date=$exact_date;
                        $date_array=explode("-",$exact_date);
                    }
                    else if(strpos($exact_date,'\\') !== false){
                        $birth_date=str_replace("\\","-",$exact_date);
                        $date_array=explode("\\",$exact_date);
                    }else{
                        // var_dump("here");die;
                        Yii::$app->session->setFlash('message',$row.' row को '.$rowData[0][1].'को जन्म मिति मिलेको छैन |');
                        return $this->render('file_upload',[
                            'model'=>$model,
                        ]);
                    }
                    
                    if(!(is_numeric($date_array[0]))){
                        // var_dump($date_array);die;
                        Yii::$app->session->setFlash('message',$row.' row को '.$rowData[0][1].'को जन्म मिति मिलेको छैन |');
                        return $this->render('file_upload',[
                            'model'=>$model,
                        ]);
                    }
                    if(!(is_numeric($date_array[1]))){
                        Yii::$app->session->setFlash('message',$row.' row को '.$rowData[0][1].'को जन्म मिति मिलेको छैन |');
                        return $this->render('file_upload',[
                            'model'=>$model,
                        ]);
                    }
                    if(!(is_numeric($date_array[2]))){
                        Yii::$app->session->setFlash('message',$row.' row को '.$rowData[0][1].'को जन्म मिति मिलेको छैन |');
                        return $this->render('file_upload',[
                            'model'=>$model,
                        ]);
                    }
                    $day=10;
                    if(!(checkdate($date_array[1],$day,$date_array[0]))){
                        Yii::$app->session->setFlash('message',$row.' row को '.$rowData[0][1].'को जन्म मिति मिलेको छैन |');
                        return $this->render('file_upload',[
                            'model'=>$model,
                        ]);
                    }
                    $date_array_count=count($date_array);
                    
                    if($date_array_count!=3){
                        Yii::$app->session->setFlash('message',$row.' row को '.$rowData[0][1].'को जन्म मिति मिलेको छैन |');
                        return $this->render('file_upload',[
                            'model'=>$model,
                        ]);
                    }
                    if(empty($date_array[0])){
                        Yii::$app->session->setFlash('message',$row.' row को '.$rowData[0][1].'को जन्म मितिको वर्ष छैन |');
                        return $this->render('file_upload',[
                            'model'=>$model,
                        ]);
                    }
                    if(empty($date_array[1])){
                        Yii::$app->session->setFlash('message',$row.' row को '.$rowData[0][1].'को जन्म मितिको महिना छैन |');
                        return $this->render('file_upload',[
                            'model'=>$model,
                        ]);
                    }
                    if(empty($date_array[2])){
                        Yii::$app->session->setFlash('message',$row.' row को '.$rowData[0][1].'को जन्म मितिको दिन छैन |');
                        return $this->render('file_upload',[
                            'model'=>$model,
                        ]);
                    }
                    if($date_array[0]<100){
                        Yii::$app->session->setFlash('message',$row.' row को '.$rowData[0][1].'को जन्म मिति मिलेको छैन |');
                        return $this->render('file_upload',[
                            'model'=>$model,
                        ]);
                    }  
                    if($date_array[0]<2070){
                        $converted_date=NepaliCalender::eng_to_nep($date_array[0],$date_array[1],$date_array[2]);
                        $birth_date=$converted_date["year"]."-".$converted_date["month"]."-".$converted_date["date"];
                        $date_array=explode("-",$birth_date);
                    }
                    // var_dump($date_array);die;
                    if($date_array[1]<=3){
                        $date_array[0]=$date_array[0]-1;
                    }

                    $fiscal_month=$this->actionDateToMonth($date_array[1]);

                    $economic_year=\app\models\EconomicYear::find()->where(['fk_province_id'=>$user_details['fk_province_id']])->all();
                    foreach($economic_year as $eYear){
                        $year=\app\models\Year::findone(['id'=>$eYear['economic_year']]);
                        $first_part=explode("/",$year['economic_year']);
                        if($first_part[0]==$date_array[0]){
                            $selected_year=\app\models\EconomicYear::findone(['economic_year'=>$year['id']]);
                            $fk_year=$selected_year['id'];
                            $year_name=$year['economic_year'];
                        }
                    }
                    
                    if($fk_year==null){
                            $year_all=\app\models\Year::find()->all();
                            foreach($year_all as $yearValue){
                                $year_array=explode("/",$yearValue['economic_year']);
                                if($year_array[0]==$date_array[0]){
                                    $new_year=new EconomicYear();
                                    $new_year->economic_year=$yearValue['id'];
                                    $new_year->status=0;
                                    $new_year->created_date=$helper->actionNepaliDate();
                                    $new_year->fk_province_id=$user_details['fk_province_id'];
                                    if($new_year->save($flag==false)){
                                        $fk_year=$new_year->id;
                                        $year_name=$yearValue['economic_year'];
                                    }
                                }
                            }
                        }

                    $bank=\app\models\BankDetails::find()->Where(['fk_user_id'=>$user_details['id']])->andWhere(['bank_name'=>$rowData[0][4]])->one();
                    if(empty($bank)){
                        $bank_model=new BankDetails();
                        $bank_model->bank_name=trim($rowData[0][4]);
                        $bank_model->fk_user_id=$user_details['id'];
                        $bank_model->fk_province_id=$user_details['fk_province_id'];
                        $bank_model->fk_district_id=$user_details['fk_district_id'];
                        $bank_model->fk_municipal_id=$user_details['fk_municipal_id'];
                        $bank_model->created_date=$helper->actionNepaliDate();
                        $bank_model->status=0;
                        if($bank_model->save()){
                            $bank_id=$bank_model->id;
                        }
                    }else{
                        $bank_id=$bank['id'];
                    }

                    // var_dump($fk_year);die;
                    if($fk_year==null){
                        Yii::$app->session->setFlash('message',$row.' row को '.$rowData[0][1].'को जन्म मिति नियमित वर्षमा छैन |');
                        return $this->render('file_upload',[
                            'model'=>$model,
                        ]);
                    }

                    $find=ChoriBachat::find()
                    ->Where(['fk_per_province'=>$user_details->fk_province_id])
                    ->all();
                    $name_trim=trim($rowData[0][1]);
                    $name_array=explode(" ",$rowData[0][1]);
                    $name_count=count($name_array);
                    if($name_count==2){
                        $first_name=$name_array[0];
                        $middle_name=null;
                        $last_name=$name_array[1];
                    }else if($name_count==3){
                    $first_name=$name_array[0];
                    $middle_name=$name_array[1];
                    $last_name="";
                    for($i=2;$i<$name_count;$i++){
                        $last_name=$last_name.$name_array[$i]." ";
                    }
                }else{
                    $first_name=$rowData[0][1];
                        $middle_name=null;
                        $last_name=null;
                }
                    $chori_bachat=new ChoriBachat();
                    $chori_bachat->fk_user_id=$user_details['id'];
                    $chori_bachat->fk_municipal_id=$user_details['fk_municipal_id'];
                    $chori_bachat->name=$first_name;
                    $chori_bachat->middle_name=$middle_name;
                    $chori_bachat->last_name=$last_name;
                    $chori_bachat->dob=$birth_date;
                    if($rowData[0][6]){
                    $chori_bachat->father_name=trim($rowData[0][6]);
                    }else{
                        $chori_bachat->father_name=null; 
                    }
                    if($rowData[0][7]){
                    $chori_bachat->mother_name=trim($rowData[0][7]);
                    }else{
                        $chori_bachat->mother_name=null;
                    }
                    $chori_bachat->fk_per_province=$user_details['fk_province_id'];
                    $chori_bachat->fk_per_district=$user_details['fk_district_id'];
                    $chori_bachat->fk_per_municipal=$user_details['fk_municipal_id'];
                    $chori_bachat->fk_ward=$ward_id;
                    $chori_bachat->tole_name=$address_array[2];
                    $chori_bachat->fk_month=$fiscal_month;
                    $chori_bachat->status=5;
                    $chori_bachat->created_date=$helper->actionNepaliDate();
                    $chori_bachat->fk_economic_year=$fk_year;
                    $chori_bachat->verified_date=$birth_date;

                    //null values
                    $chori_bachat->fk_bank_details=$bank_id;
                    $chori_bachat-> image=null;
                    $chori_bachat->camera_image=null;
                    $chori_bachat->thumb_left=null;

                    $chori_bachat->left_iso_template=null;
                    $chori_bachat->left_ansi_template=null;
                    $chori_bachat->thumb_right=null;
                    $chori_bachat->iso_template=null;
                    $chori_bachat->ansi_template=null;
                    $chori_bachat->guardian_image=null;
                    $chori_bachat->email=null;
                    $chori_bachat->phone_no=null;
                    $chori_bachat->mobile_no=null;
                    $chori_bachat->birth_certificate_no=null;
                    $chori_bachat->birth_certificate_date=null;
                    $chori_bachat->fk_caste=null;
                    $chori_bachat->fk_apangata=null;
                    $chori_bachat->father_citizenship_no=null;
                    $chori_bachat->mother_citizenship_no=null;
                    $chori_bachat->check_guardian=null;
                    $chori_bachat->take_care_person=null;
                    $chori_bachat->take_care_citizenship_no=null;
                    $chori_bachat->chori_birth_certificate_doc=null;
                    $chori_bachat->parents_citizenship_doc=null;
                    $chori_bachat->mother_citizenship_doc=null;
                    $chori_bachat->woda_sifarish_doc=null;
                    $chori_bachat->sastha_certificate=null;
                    $chori_bachat->hospital_certificate=null;
                    $chori_bachat->bank_status=null;
                    
                    $chori_bachat->payment_status=1;
                    
                    $chori_count=01;
                    if($find){
                    foreach($find as $latest){
                        $uid1=$latest['unique_id'];
                    }
                    $uid=str_replace("-","/",$uid1);
                    $split_uid=explode("/",$uid);
    
                    $length=count($split_uid);
                    // var_dump($length);die;
                    if($length==4){
                        $new_count=$split_uid[3]+1;
                    }else{
                        $new_count=$split_uid[6]+1;
                    }
                    $chori_bachat->unique_id=$year_name.'/'.$user_details['fk_province_id'].'/'.$this->actionDistrictcode($user_details['fk_district_id']).'/'.$user_details['fk_municipal_id'].'/'.'1'.'/'.$new_count;
                }else{
                    $chori_bachat->unique_id=$year_name.'/'.$user_details['fk_province_id'].'/'.$this->actionDistrictcode($user_details['fk_district_id']).'/'.$user_details['fk_municipal_id'].'/'.'1'.'/'.$chori_count;
                }
                    if($chori_bachat->save($flag==false)){

                        $chori_account=new ChoriAccountDetails();
                        $chori_account->chori_unique_id=$chori_bachat->unique_id;
                        $chori_account->fk_chori_bachat=$chori_bachat->id;
                        $chori_account->fk_municipal_id=$user_details['fk_municipal_id'];
                        $chori_account->bank_name=$bank_id;
                        $chori_account->account_no=trim(str_replace($nepali_date, $eng_date,$rowData[0][3]));
                        $chori_account->account_open_date=$birth_date;
                        $chori_account->radio_status=1;
                        $chori_account->remarks=null;
                        $chori_account->fk_user_id=$user_details['id'];
                        $chori_account->bank_status=2;
                        $chori_account->created_date=$birth_date;
                        $chori_account->fk_province_id=$user_details['fk_province_id'];
                        $chori_account->fk_district_id=$user_details['fk_district_id'];
                        $chori_account->fk_year=$fk_year;
                        if($chori_account->save($flag==false)){
                            
                            $payment_model=\app\models\Initial::find()->where(['fk_user'=>$user_details['id']])->all();
                            $p_count=1;
                            if($payment_model){
                            foreach($payment_model as $payment){
                                    $payment_id=$payment['payment_id'];
                            }
                            $p_id=explode("-",$payment_id);
                            $new_id=$p_id[1]+1;
                            $new_pid=$year_name."-".$new_id;
                            }else{
                                $new_pid=$year_name."-".$p_count;
                            }
                            $initial->fk_year=$fk_year;
                            $initial->fk_province_id=$user_details['fk_province_id'];
                            $initial->fk_district=$user_details['fk_district_id'];
                            $initial->fk_municipal=$user_details['fk_municipal_id'];
                            $initial->fk_user=$user_details['id'];
                            $initial->created_date=$helper->actionNepaliDate();
                            $initial->payment_id=$new_pid;
                            $initial->status=1;
                            $initial->fk_bank=$bank_id;
                            if($initial->save($flag==false)){
                                $fk_initial=$initial->id;
                            }
                            

                            $payment_chori=new PaymentChori();
                            $payment_chori->post_date=$birth_date;
                            $payment_chori->fk_economic_year=$fk_year;
                            $payment_chori->fk_month=$fiscal_month;
                            $payment_chori->fk_chori_bachat=$chori_bachat->id;
                            $payment_chori->fk_bank_details=$bank_id;
                            $payment_chori->fk_chori_account_details=$chori_account->id;
                            $payment_chori->amount=$money['initial_payment'];
                            $payment_chori->fk_user_id=$user_details['id'];
                            $payment_chori->fk_province_id=$user_details['fk_province_id'];
                            $payment_chori->fk_district_id=$user_details['fk_district_id'];
                            $payment_chori->fk_municipal=$user_details['fk_municipal_id'];
                            $payment_chori->created_date=$helper->actionNepaliDate();
                            $payment_chori->status=6;
                            $payment_chori->bank_request=$bank_id;
                            $payment_chori->cheque_no=$cheque_no;
                            $payment_chori->fk_initial=$fk_initial;
                            if($payment_chori->save($flag==false)){
                                // if($row==3){
                                //     var_dump("hello");die;
                                // }
                                $check_year=$date_array[0];
                                $count=1;
                                $current_year=explode("/",$active_year['economic_year']);
                                $other_month_pay=\app\models\OtherMonthPayment::find()->where(['fk_user_id'=>$user_details['id']])->andWhere(['fk_year'=>$active_economic_year['id']])->all();
                                if($other_month_pay){
                                foreach($other_month_pay as $omp){
                                    $omp_economic=\app\models\EconomicYear::findone(['id'=>$omp['fk_year']]);
                                    $omp_year=\app\models\Year::findone(['id'=>$omp_economic['economic_year']]);
                                    $omp_month=$omp['fk_month'];
                                    $omp_year_array=explode("/",$omp_year['economic_year']);
                                    $omp_year_value=$omp_year_array[0];
                                }
                                while($check_year<=$omp_year_value){
                                    $economic_year_other=\app\models\EconomicYear::find()->where(['fk_province_id'=>$user_details['fk_province_id']])->all();
                                    foreach($economic_year_other as $eco_year){
                                        $year_new=\app\models\Year::findone(['id'=>$eco_year['economic_year']]);
                                        $first_part=explode("/",$year_new['economic_year']);
                                        if($first_part[0]==$check_year){
                                            $selected_economic_year=\app\models\EconomicYear::findone(['economic_year'=>$year_new['id']]);
                                            $fk_year=$selected_economic_year['id'];
                                            $year_name=$year_new['economic_year'];
                                        }
                                    }
                                    // var_dump($year_name);die;
                                    if($count==1){
                                        $value=$fiscal_month+1;
                                        $count++;
                                    }else{
                                        $value=1;
                                        $count++;
                                    }
                                    if($check_year<$omp_year_value){
                                        $end_value=12;
                                    }else{
                                        $end_value=$omp_month;
                                    }
                                        for($i=$value;$i<=$end_value;$i++){
                                                $other_payment=new OtherMonthPayment();
                                                $other_payment->fk_year=$fk_year;
                                                $other_payment->fk_month=$i;
                                                $other_payment->fk_payment_chori=$payment_chori->id;
                                                $other_payment->fk_user_id=$user_details['id'];
                                                $other_payment->fk_province_id=$user_details['fk_province_id'];
                                                $other_payment->fk_district_id=$user_details['fk_district_id'];
                                                $other_payment->fk_municipal=$user_details['fk_municipal_id'];
                                                $other_payment->created_date=$helper->actionNepaliDate();
                                                $other_payment->fk_bank=$bank_id;
                                                $other_payment->cheque_no=$cheque_no;
                                                $other_payment->fk_chori_bachat=$chori_bachat->id;
                                                $other_payment->amount=$money['previous_payment'];
                                                $other_payment->save();
                                        }
                                    $check_year++;
                                }
                            }else{
                                
                                $omp_year_value=$current_year[0]-1;
                                $omp_month=12;
                                while($check_year<=$omp_year_value){
                                    $economic_year_other=\app\models\EconomicYear::find()->where(['fk_province_id'=>$user_details['fk_province_id']])->all();
                                    foreach($economic_year_other as $eco_year){
                                        $year_new=\app\models\Year::findone(['id'=>$eco_year['economic_year']]);
                                        $first_part=explode("/",$year_new['economic_year']);
                                        if($first_part[0]==$check_year){
                                            $selected_economic_year=\app\models\EconomicYear::findone(['economic_year'=>$year_new['id']]);
                                            $fk_year=$selected_economic_year['id'];
                                            $year_name=$year_new['economic_year'];
                                        }
                                    }
                                    if($count==1){
                                        $value=$fiscal_month+1;
                                        $count++;
                                    }else{
                                        $value=1;
                                        $count++;
                                    }
                                    if($check_year<$omp_year_value){
                                        $end_value=12;
                                    }else{
                                        $end_value=$omp_month;
                                    }
                                        for($i=$value;$i<=$end_value;$i++){
                                                $other_payment=new OtherMonthPayment();
                                                $other_payment->fk_year=$fk_year;
                                                $other_payment->fk_month=$i;
                                                $other_payment->fk_payment_chori=$payment_chori->id;
                                                $other_payment->fk_user_id=$user_details['id'];
                                                $other_payment->fk_province_id=$user_details['fk_province_id'];
                                                $other_payment->fk_district_id=$user_details['fk_district_id'];
                                                $other_payment->fk_municipal=$user_details['fk_municipal_id'];
                                                $other_payment->created_date=$helper->actionNepaliDate();
                                                $other_payment->fk_bank=$bank_id;
                                                $other_payment->cheque_no=$cheque_no;
                                                $other_payment->fk_chori_bachat=$chori_bachat->id;
                                                $other_payment->amount=$money['previous_payment'];
                                                $other_payment->save($flag==false);
                                        }
                                    $check_year++;
                                }
                            }
                            // var_dump("end");die;
                                
                            }
                        }
                    }

                }
            }
                    //  var_dump($flag);die;
                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('message','Successfully Uploaded');
                        return $this->render('file_upload',[
                            'model'=>$model,
                        ]);
                    } else {
                        var_dump($flag);
                        die;
                    }
                        
                
                }
        return $this->render('file_upload',[
            'model'=>$model,
        ]);
    }

    public function actionChhoriData($id) {
        $chori_details = (new \yii\db\Query())
                ->select('chori_bachat.name,chori_bachat.id,chori_bachat.dob,chori_bachat.status,chori_bachat.birth_certificate_no,'
                        . 'chori_bachat.image,chori_bachat.guardian_image,chori_bachat.birth_certificate_date,'
                        . 'chori_bachat.father_name,chori_bachat.father_citizenship_no,chori_bachat.mother_name,'
                        . 'chori_bachat.mother_citizenship_no,chori_bachat.take_care_person,'
                        . 'chori_bachat.take_care_citizenship_no,chori_bachat.mother_citizenship_doc,chori_bachat.woda_sifarish_doc,chori_bachat.chori_birth_certificate_doc,chori_bachat.parents_citizenship_doc,'
                        . 'chori_bachat.sastha_certificate,municipals.municipal_nepali,district.district_nepali,chori_bachat.hospital_certificate,ward.ward_name,'
                        . 'chori_bachat.tole_name,chori_account_details.remarks')
                ->from('chori_bachat')
                ->join('JOIN', 'chori_account_details', 'chori_account_details.fk_chori_bachat=chori_bachat.id')
                ->join('JOIN', 'ward', 'ward.id=chori_bachat.fk_ward')
                ->join('JOIN', 'district', 'district.id=chori_bachat.fk_per_district')
                ->join('JOIN', 'municipals', 'municipals.id=chori_bachat.fk_per_municipal')
                ->where(['chori_bachat.id' => $id])
                ->all();
        // var_dump($chori_details);die;
        return $this->render('bank_remarks_doc', [
                    'model' => $this->findModel($id),
                    'chori_details' => $chori_details,
        ]);
    }

    public function actionRequestAccount() {
        $helper = new Helper();
        $searchModel = new ChoriBachatSearch(['status' => 3, 'fk_municipal_id' => $helper->getOrganization()]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('request_account_list', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionVerifiedDocument() {
        $helper = new Helper();
        $searchModel = new ChoriBachatSearch(['fk_municipal_id' => $helper->getOrganization()]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['or',
        ['status'=>5],
        ['status'=>3],
        ['status'=>2],
        ['status'=>1]
        ]);


        return $this->render('verified_chhori_list', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAccountNotverifiedChhori() {
        $helper = new Helper();
        $searchModel = new ChoriBachatSearch(['status' => 4, 'fk_municipal_id' => $helper->getOrganization()]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('account_notverified_chhori', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionChhoriInfo($id) {
        $accountDetails = new ChoriAccountDetails();
        $helper = new Helper();
        $chori_id = ChoriBachat::findOne(['id' => $id]);
        $user_details=\app\models\Users::findone(['id'=>$helper->getUserId()]);
        //var_dump($chori_id->id);die;
        $bank = \app\models\BankDetails::find()->where(['fk_user_id' =>$user_details['id'] ])->andWhere(['status'=>1])->one();
        // var_dump($bank['bank_name']);die;
        $economic_year=\app\models\EconomicYear::find()->where(['status'=>1])->andWhere(['fk_province_id'=>$user_details->fk_province_id])->one();
        $chori_details = (new \yii\db\Query())
                ->select('chori_bachat.name,chori_bachat.middle_name,chori_bachat.last_name,chori_bachat.id,chori_bachat.dob,chori_bachat.status,chori_bachat.birth_certificate_no,'
                        . 'chori_bachat.image,chori_bachat.guardian_image,chori_bachat.birth_certificate_date,chori_bachat.unique_id,'
                        . 'chori_bachat.father_name,chori_bachat.father_citizenship_no,chori_bachat.mother_name,'
                        . 'chori_bachat.mother_citizenship_no,chori_bachat.take_care_person,'
                        . 'chori_bachat.take_care_citizenship_no,chori_bachat.chori_birth_certificate_doc,chori_bachat.parents_citizenship_doc,'
                        . 'chori_bachat.sastha_certificate,chori_bachat.mother_citizenship_doc,chori_bachat.woda_sifarish_doc,municipals.municipal_nepali,district.district_nepali,chori_bachat.hospital_certificate,ward.ward_name,chori_bachat.tole_name')
                ->from('chori_bachat')
                ->join('JOIN', 'ward', 'ward.id=chori_bachat.fk_ward')
                ->join('JOIN', 'district', 'district.id=chori_bachat.fk_per_district')
                ->join('JOIN', 'municipals', 'municipals.id=chori_bachat.fk_per_municipal')
                ->where(['chori_bachat.id' => $id])
                ->andWhere(['status'=>3])
                ->all();
                
        //var_dump($chori_details);die;
        if ($accountDetails->load(Yii::$app->request->post())) {
            //var_dump($accountDetails->fk_chori_bachat);die;
            // var_dump($accountDetails->radio_status);die;
            $account_number=\app\models\ChoriAccountDetails::find()->where(['account_no'=>$accountDetails->account_no])->one();
            if (empty($accountDetails->remarks) && $accountDetails->radio_status==0) {
                //var_dump("all null");die;
                Yii::$app->session->setFlash('message', 'खाता नखुलेको कारण लेख्नुहोस !');
                return $this->render('bank_chhori_info', [
                            'model' => $this->findModel($id),
                            'accountDetails' => $accountDetails,
                            'chori_details' => $chori_details,
                            'mes'=>3,
                ]);
            }
            else if (empty($accountDetails->account_no) && $accountDetails->radio_status==1) {
                Yii::$app->session->setFlash('message', 'खाता नम्बर लेख्नुहोस !');
                //var_dump("all null");die;
                return $this->render('bank_chhori_info', [
                            'model' => $this->findModel($id),
                            'accountDetails' => $accountDetails,
                            'chori_details' => $chori_details,
                            'mes'=>1,
                ]);
            }
            else if(empty($accountDetails->account_open_date) && $accountDetails->radio_status==1){
                //var_dump("all null");die;
                Yii::$app->session->setFlash('message', 'मिति छान्नुहोस् !');
                return $this->render('bank_chhori_info',[
                            'model' => $this->findModel($id),
                            'accountDetails' => $accountDetails,
                            'chori_details' => $chori_details,
                            'mes'=>2,
                ]);
            }
            else if($bank['bank_name']==null){
                Yii::$app->session->setFlash('message', 'कृपया सेटिंगमा बैंक सेट गर्नुहोस !');
                return $this->render('bank_chhori_info',[
                            'model' => $this->findModel($id),
                            'accountDetails' => $accountDetails,
                            'chori_details' => $chori_details,
                            'mes'=>4,
                ]);
            }
            else if(substr_count($accountDetails->account_open_date,"__")>0 && $accountDetails->radio_status==1){
                Yii::$app->session->setFlash('message','कृपया मिति सच्च्याउनुहोस्');
                return $this->render('bank_chhori_info',[
                    'model' => $this->findModel($id),
                    'accountDetails' => $accountDetails,
                    'chori_details' => $chori_details,
                    'mes'=>2,
            ]);
            }
            else if($account_number){
                Yii::$app->session->setFlash('message','खाता नम्बर सिस्टममा पहिले राखिसकेको छ ');
                return $this->render('bank_chhori_info',[
                    'model' => $this->findModel($id),
                    'accountDetails' => $accountDetails,
                    'chori_details' => $chori_details,
                    'mes'=>1,
            ]);
            }
            else{
            $accountDetails->fk_chori_bachat = $chori_id->id;
            //var_dump($accountDetails->account_no);die;
            $accountDetails->bank_name = $bank['id'];
            $accountDetails->fk_user_id = $helper->getUserId();
            $accountDetails->created_date = date('Y-m-d');
            $accountDetails->fk_municipal_id = $helper->getOrganization();
            $accountDetails->fk_province_id=$user_details['fk_province_id'];
            $accountDetails->fk_district_id=$user_details['fk_district_id'];
            $accountDetails->fk_year=$economic_year['economic_year'];
            

            if (!empty($accountDetails->remarks)) {
                $chori_id->status = 4;
                $accountDetails->bank_status = 5;
                // $title="About Document";
                // $message="Your account can not be opened, reasons below".$accountDetails->remarks;
                //  $ch = curl_init();
                //         curl_setopt($ch, CURLOPT_URL, 'http://app.easy.com.np/easyApi');
                //         curl_setopt($ch, CURLOPT_HEADER, 0);
                //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                //         curl_setopt($ch, CURLOPT_POST, 1);
                //         $data = array(
                //             'key' => 'EASY5c406d30cb33d0.12577082',
                //             'source' => 'none', // for default sender ID
                //             'message' => $message,
                //             'destination' => $chori_id->mobile_no, // with or without country code
                //             'type' => 1,
                //         );

                //         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                //         $contents = curl_exec($ch);
                        
                //         Yii::$app->mailer->compose()
                //                 ->setFrom('kashigautam51@gamil.com')
                //                 ->setTo($chori_id->email)
                //                 ->setSubject($title)
                //                 ->setTextBody($title)
                //                 ->setHtmlBody('<h2>' . $message . '</h2><b>It is the system generated email. Do not reply on it. For more details contact our office.</b>')
                //                 ->send();
                
            }
            if (!empty($accountDetails->account_no && $accountDetails->account_open_date)) {
                yii::$app->db->createCommand()
                ->update('chori_bachat',['fk_bank_details'=>$bank['id']],['id'=>$chori_id->id])
                ->execute();
                $chori_id->status = 2;
                $accountDetails->bank_status = 2;
                // $title="About Document";
                // $message="Your account number is:".$accountDetails->account_no;
                //  $ch = curl_init();
                //         curl_setopt($ch, CURLOPT_URL, 'http://app.easy.com.np/easyApi');
                //         curl_setopt($ch, CURLOPT_HEADER, 0);
                //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                //         curl_setopt($ch, CURLOPT_POST, 1);
                //         $data = array(
                //             'key' => 'EASY5c406d30cb33d0.12577082',
                //             'source' => 'none', // for default sender ID
                //             'message' => $message,
                //             'destination' => $chori_id->mobile_no, // with or without country code
                //             'type' => 1,
                //         );

                //         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                //         $contents = curl_exec($ch);
                        
                //     Yii::$app->mailer->compose()
                //                 ->setFrom('kashigautam51@gamil.com')
                //                 ->setTo($chori_id->email)
                //                 ->setSubject($title)
                //                 ->setTextBody($title)
                //                 ->setHtmlBody('<h2>' . $message . '</h2><b>It is the system generated email. Do not reply on it. For more details contact our office.</b>')
                //                 ->send();    
            }
          
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if ($flag = $accountDetails->save(false)) {
                    if (!($flag = $chori_id->save(false))) {
                        $transaction->rollBack();
                    }
                }
                //var_dump($flag);die;
                if ($flag) {
                    $transaction->commit();
                    return $this->redirect(['request-account']);
                }
            } catch (\yii\db\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
        }
        if($bank['bank_name']==null){
            Yii::$app->session->setFlash('message', 'कृपया सेटिंगमा बैंक सेट गर्नुहोस !');
            return $this->render('bank_chhori_info',[
                        'model' => $this->findModel($id),
                        'accountDetails' => $accountDetails,
                        'chori_details' => $chori_details,
                        'mes'=>4,
            ]);
        }else{
        return $this->render('bank_chhori_info', [
                    'model' => $this->findModel($id),
                    'accountDetails' => $accountDetails,
                    'chori_details' => $chori_details,
                    'mes'=>0,
        ]);
        }
    }

    public function actionActiveChori() {
        $user_id = \Yii::$app->user->id;
        $user_details = Users::findOne(['id' => $user_id]);
        $activeChoriList = (new \yii\db\Query())
                ->select('chori_bachat.name,chori_bachat.dob,chori_bachat.tole_name,chori_bachat.birth_certificate_no,chori_bachat.birth_certificate_date,'
                        . 'chori_bachat.father_name,ward.ward_name as wname,'
                        . 'municipals.municipal_nepali as municipal_name')
                ->from('chori_bachat')
                ->join('JOIN', 'ward', 'ward.id=chori_bachat.fk_ward')
                ->join('JOIN', 'municipals', 'municipals.id=chori_bachat.fk_municipal_id')
                ->where(['chori_bachat.fk_user_id' => $user_id])
                ->andWhere(['status' =>3])
                ->andWhere(['chori_bachat.fk_municipal_id' => $user_details->fk_municipal_id])
                ->all();
       
        //var_dump($activeChoriList);die;
        return $this->render('active_chori_list',
                        [
                            'activeChoriList' => $activeChoriList,
        ]);
    }
public function actionCheckStatus($ids){
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $explode_ids = explode(',', $ids);
    $user = \yii::$app->user->id;
    //$user_details= Users::findOne(['id'=>$user]);
    $bank_name = \app\models\BankDetails::findOne(['fk_user_id' => $user]);
    $bank_chhori_data = ChoriBachat::findAll(['id' => $explode_ids]);
    //var_dump($bank_chhori_data);die;
    $flag = true;
    foreach ($bank_chhori_data as $data1) {
        //var_dump($data1['status']);die;
        if(!($data1['status']==1)){
            $flag = false;
        }
    }
    return $flag;
}
    public function actionBankDocs($ids) {
        $explode_ids = explode(',', $ids);
        $user = \yii::$app->user->id;
        //$user_details= Users::findOne(['id'=>$user]);
        $bank_name = \app\models\BankDetails::find()->where(['fk_user_id' => $user])->andWhere(['status'=>1])->one();
        $bank_chhori_data = ChoriBachat::findAll(['id' => $explode_ids]);
        //var_dump($bank_chhori_data);die;
        foreach ($bank_chhori_data as $data1) {
            $data1['status'] = 3;
            
            //var_dump($data1->name);die;
            $title="About Request";
            $message="Dear".$data1->name .",Your document is requested for opening bank account";
            //var_dump($data->email);die;
        //    if(){
        //       $ch = curl_init();
        //                 curl_setopt($ch, CURLOPT_URL, 'http://app.easy.com.np/easyApi');
        //                 curl_setopt($ch, CURLOPT_HEADER, 0);
        //                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //                 curl_setopt($ch, CURLOPT_POST, 1);
        //                 $data = array(
        //                     'key' => 'EASY5c406d30cb33d0.12577082',
        //                     'source' => 'none', // for default sender ID
        //                     'message' => $message,
        //                     'destination' => $data1->mobile_no, // with or without country code
        //                     'type' => 1,
        //                 );

        //                 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //                 $contents = curl_exec($ch); 
        //                 //var_dump($data->email);die;
        //                 Yii::$app->mailer->compose()
        //                         ->setFrom('kashigautam51@gamil.com')
        //                         ->setTo($data1->email)
        //                         ->setSubject($title)
        //                         ->setTextBody($title)
        //                         ->setHtmlBody('<h2>' . $message . '</h2><b>It is the system generated email. Do not reply on it. For more details contact our office.</b>')
        //                         ->send();
        //    }
        $data1->save();
        }



        return $this->render('bank_document', [
                    'model' => $this->findModel($ids),
                    'bank_chhori_data' => $bank_chhori_data,
                    'bank_name' => $bank_name,
        ]);
    }

    /**
     * Displays a single ChoriBachat model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $chori_detail = (new \yii\db\Query())
                ->select('chori_bachat.name,chori_bachat.middle_name,chori_bachat.last_name,chori_bachat.unique_id,chori_bachat.dob,chori_bachat.status,chori_bachat.birth_certificate_no,'
                        . 'chori_bachat.image,chori_bachat.guardian_image,chori_bachat.birth_certificate_date,chori_bachat.thumb_left,chori_bachat.thumb_right,'
                        . 'chori_bachat.father_name,chori_bachat.father_citizenship_no,chori_bachat.mother_name,'
                        . 'chori_bachat.mother_citizenship_no,chori_bachat.take_care_person,chori_bachat.take_care_citizenship_no,'
                        . 'chori_bachat.chori_birth_certificate_doc,chori_bachat.parents_citizenship_doc,chori_bachat.mother_citizenship_doc,'
                        . 'chori_bachat.sastha_certificate,chori_bachat.woda_sifarish_doc,municipals.municipal_nepali,district.district_nepali,chori_bachat.hospital_certificate,ward.ward_name,chori_bachat.tole_name,'
                        . 'chori_bachat.phone_no,chori_bachat.email,chori_bachat.mobile_no')
                ->from('chori_bachat')
                ->join('JOIN', 'ward', 'ward.id=chori_bachat.fk_ward')
                ->join('JOIN', 'district', 'district.id=chori_bachat.fk_per_district')
                ->join('JOIN', 'municipals', 'municipals.id=chori_bachat.fk_per_municipal')
                ->where(['chori_bachat.id' => $id])
                ->one();
            // var_dump($chori_details);die;
        //var_dump($chori_details);die;
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'chori_detail' => $chori_detail,
        ]);
    }
    public function actionDateToMonth($month){
        $result = 0;
        if($month==1){
            $result = 10;
        }else if($month==2){
             $result = 11;
        }else if($month==3){
             $result = 12;
        }else if($month==4){
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
        }
        return $result;
    }

    public function actionVerify($id) {
        $model = ChoriBachat::findOne(['id' => $id]);
        $helper = new Helper();
        //var_dump($model->name);die;
        $message = "Dear" .$model->name.",Your document is verified successfully";
        $title ="Document Verification";
        //var_dump($model->mobile_no);die;
        $model->status = 1;
        $model->verified_date=$helper->actionNepaliDate();
            // if($model->save()){
                
            //     $ch = curl_init();
            //             curl_setopt($ch, CURLOPT_URL, 'http://app.easy.com.np/easyApi');
            //             curl_setopt($ch, CURLOPT_HEADER, 0);
            //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //             curl_setopt($ch, CURLOPT_POST, 1);
            //             $data = array(
            //                 'key' => 'EASY5c406d30cb33d0.12577082',
            //                 'source' => 'none', // for default sender ID
            //                 'message' => $message,
            //                 'destination' => $model->mobile_no, // with or without country code
            //                 'type' => 1,
            //             );

            //             curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            //             $contents = curl_exec($ch);
                        
            //    Yii::$app->mailer->compose()
            //                     ->setFrom('kashigautam51@gamil.com')
            //                     ->setTo($model->email)
            //                     ->setSubject($title)
            //                     ->setTextBody($title)
            //                     ->setHtmlBody('<h2>' . $message . '</h2><b>It is the system generated email. Do not reply on it. For more details contact our office.</b>')
            //                     ->send();
            // } 
            $model->save();
            
            
        

        return $this->redirect(['view', 'id' => $id]);
    }
    
    public function actionVerified($id) {

        $model = ChoriBachat::findOne(['id' => $id]);
        $user = yii::$app->user->id;
        $user_details = Users::findOne(['id' => $user]);
        if ($model->load(Yii::$app->request->post())) {
            $model->status = 0;
            if ($model->password == $user_details['pin']) {
                if ($model->save(false)) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {

                Yii::$app->session->setFlash('message', 'Password does not match !');
                return $this->render('verification_form', [
                            'model' => $model,
                ]);
            }
        }

        return $this->render('verification_form', [
                    'model' => $model,
        ]);
    }

    public function actionBankDetails($id) {
        $account_chori = new ChoriAccountDetails();
        // $active_chori= ChoriBachat::findOne(['id'=>$id]);
        $user_id = \yii::$app->user->id;
        $user_details = Users::findOne(['id' => $user_id]);
        $chori = ChoriBachat::findOne(['id' => $id]);
        //var_dump($chori);die;
        $account_chori_list = (new \yii\db\Query())
                ->select('chori_bachat.name as cname ,chori_account_details.account_no,chori_account_details.account_open_date,'
                        . 'bank_details.bank_name')
                ->from('chori_account_details')
                ->join('JOIN', 'chori_bachat', 'chori_bachat.id=chori_account_details.fk_chori_bachat')
                ->join('JOIN', 'bank_details', 'bank_details.id=chori_account_details.bank_name')
                ->where(['chori_account_details.fk_user_id' => $user_id])
                ->andWhere(['status' => 3])
                ->andWhere(['chori_account_details.fk_municipal_id' => $user_details->fk_municipal_id])
                ->all();
            //var_dump($user_id);die;
        //var_dump($account_chori_list);die;
        if ($account_chori->load(Yii::$app->request->post())) {

            $user = \yii::$app->user->id;
            $user_details = \app\models\Users::findOne(['id' => $user]);

            // var_dump($user_details->fk_municipal_id);die;
            $account_chori->fk_municipal_id = $user_details->fk_municipal_id;
            $chori->status = 2;
            $account_chori->fk_user_id = $user;

            $account_chori->created_date = date('Y-m-d');
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if ($flag = $account_chori->save(false)) {
                    if (!($flag = $chori->save(false))) {
                        $transaction->rollBack();
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    return $this->redirect(['index', 'id' => $account_chori->id]);
                }
            } catch (\yii\db\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return $this->render('bankcreate', [
                    'account_chori' => $account_chori,
                    'account_chori_list' => $account_chori_list,
                    'chori' => $chori,
        ]);
    }

    /**
     * Creates a new ChoriBachat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDateMonth($month){
        $result = 0;
        if($month==1){
            $result = 10;
        }else if($month==2){
             $result = 11;
        }else if($month==3){
             $result = 12;
        }else if($month==4){
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
        }
        return $result;
    }
    public function actionDistrictcode($fk_district){
        $result = 0;
        if($fk_district==80){
            $result = 1;
        }else if($fk_district==79){
             $result = 2;
        }else if($fk_district==78){
             $result = 3;
        }else if($fk_district==77){
             $result = 4;
        }else if($fk_district==76){
             $result = 5;
        }else if($fk_district==75){
             $result = 6;
        }else if($fk_district==74){
             $result = 7;
        }else if($fk_district==81){
             $result = 8;
        }else if($fk_district==82){
             $result = 9;
        }else if($fk_district==83){
             $result = 10;
        }
        return $result;
    }
    public function actionCreate() {
        $model = new ChoriBachat();
        $helper =new Helper();
        $bank_id=\app\models\BankDetails::findOne(['fk_user_id'=>$helper->getUserId()]);
        //var_dump($bank_id);die;
        $today = $helper->actionNepaliDate();

        $explode_today = explode('-', $today);
        $month = $explode_today[1];
       $user_details=\app\models\Users::findone(['id'=>$helper->getUserId()]);
       
        if ($model->load(Yii::$app->request->post())) {

            $ward=\app\models\Ward::findone(['id'=>$model->fk_ward]);

            if(substr_count($model->dob,"__")>0){
                Yii::$app->session->setFlash('message','कृपया जन्म मिति सच्च्याउनुहोस्');
                return $this->render('create', [
                    'model' => $model,
                    'mes'=>1,
                ]);
            }
            else if(substr_count($model->birth_certificate_date,'__')>0){
                Yii::$app->session->setFlash('message','कृपया दर्ता मिति सच्च्याउनुहोस्');
                return $this->render('create', [
                    'model' => $model,
                    'mes'=>2,
                ]);
            }
            else{
            $year=EconomicYear::find()
            ->andWhere(['status'=>1])
            ->andWhere(['fk_province_id'=> $user_details['fk_province_id']])
            ->one();
            $active_year=\app\models\Year::findone(['id'=>$year['economic_year']]);
            $find=ChoriBachat::find()
            ->Where(['fk_per_province'=>$model->fk_per_province])
            ->all();
            $count=000001;
            if($find){
                foreach($find as $latest){
                    $uid1=$latest['unique_id'];
                }
                $uid=str_replace("-","/",$uid1);
                $split_uid=explode("/",$uid);

                $length=count($split_uid);
                // var_dump($length);die;
                if($length==4){
                    $new_count=$split_uid[3]+1;
                }else{
                    $new_count=$split_uid[6]+1;
                }
                $model->unique_id=$active_year['economic_year'].'/'.$user_details['fk_province_id'].'/'.$this->actionDistrictcode($user_details['fk_district_id']).'/'.$user_details['fk_municipal_id'].'/'.$ward['ward_name'].'/'.$new_count;
            }
            else{
                $model->unique_id=$active_year['economic_year'].'/'.$user_details['fk_province_id'].'/'.$this->actionDistrictcode($user_details['fk_district_id']).'/'.$user_details['fk_municipal_id'].'/'.$ward['ward_name'].'/'.$count;
            }
            // var_dump($model->unique_id);die;
            $user= \yii::$app->user->id;
            $model->fk_user_id = $helper->getUserId();
            $model->fk_municipal_id=$helper->getOrganization();
            // $model->fk_bank_details=$bank_id->id;
            $model->status = 0;
            $model->bank_status = 0;
            $model->payment_status=1;
            $model->created_date = $helper->actionNepaliDate();
            $model->fk_economic_year=$year['economic_year'];
            $model->fk_month=$this->actionDateToMonth($month);

            $nep_date=$helper->actionNepaliDate();
            $nep_date1=explode('-',$nep_date);
            $dob=explode('-',$model->dob);
            if((int)$nep_date1[0]>(int)$dob[0]){
                if((int)$nep_date1[1]>(int)$dob[1]){
                    $age=(int)$nep_date1[0]-(int)$dob[0];
                }else if((int)$nep_date1[1]==(int)$dob[1]){
                    if((int)$nep_date1[2]>=(int)$dob[2]){
                        $age=(int)$nep_date1[0]-(int)$dob[0];
                    }else{
                        $age=((int)$nep_date1[0]-(int)$dob[0])-(int)1;
                    }
                }else{
                    
                    $age=((int)$nep_date1[0]-(int)$dob[0])-(int)1;
                }}
                else{
                    $age=0;
                }
            $model->age=$age;
            //insert thumb left

            $tfile = 'images/' . $user . '/thumb-left';
            define('UPLOAD_DIR', $tfile);
            // check Image File is Empty form form
            if (!empty($model->thumbLeft)) {

                $image_parts2 = explode(";base64,", $model->thumbLeft);
                //var_dump($image_parts2);die;
                $image_type_aux2 = explode("image/", $image_parts2[0]);
                $image_type2 = $image_type_aux2[1];
                $image_base64_2 = base64_decode($image_parts2[1]);
                $file2 = UPLOAD_DIR . uniqid() . '.png';
                //var_dump($file2);die;
                file_put_contents($file2, $image_base64_2);
                $model->thumb_left = $file2;
                // var_dump($file2);die;
            }
            
            // insert right thumb
            //$tfile1 = 'images/' .$user . '/thumb-right';
            // define('UPLOAD_DIR', $tfile1);
            // check Image File is Empty form form
            if (!empty($model->thumbRight)) {

                $image_parts3 = explode(";base64,", $model->thumbRight);
                //var_dump($image_parts3);die;
                $image_type_aux3 = explode("image/", $image_parts3[0]);
                $image_type3 = $image_type_aux3[1];
                $image_base64_3 = base64_decode($image_parts3[1]);
                $file3 = UPLOAD_DIR . uniqid() . '.png';
                //var_dump($file2);die;
                file_put_contents($file3, $image_base64_3);
                $model->thumb_right = $file3;
                // var_dump($file2);die;
            }

            // Camera Photo child
            if (!empty($model->photo_from_camera)) {

                $image_parts2 = explode(";base64,", $model->photo_from_camera);
                $image_type_aux2 = explode("image/", $image_parts2[0]);
                $image_type2 = $image_type_aux2[1];
                $image_base64_2 = base64_decode($image_parts2[1]);
                $file2 = UPLOAD_DIR . uniqid() . '.png';
                file_put_contents($file2, $image_base64_2);
                $model->image = $file2;
                // var_dump($file2);die;
            }
            // Camera Photo guardian
            if (!empty($model->photo_from_camera_guardian)) {

                $image_parts2 = explode(";base64,", $model->photo_from_camera_guardian);
                $image_type_aux2 = explode("image/", $image_parts2[0]);
                $image_type2 = $image_type_aux2[1];
                $image_base64_2 = base64_decode($image_parts2[1]);
                $file3 = UPLOAD_DIR . uniqid() . '.png';
                file_put_contents($file3, $image_base64_2);
                $model->guardian_image = $file3;
                // var_dump($file2);die;
            }
            //insert chori image
            $asset_path = 'images/' . $user . '/chori-image/';
            $actualPath = 'images/' . $user . '/chori-image/';
            $mode = 0777;
            $recursive = true;
            if (!is_dir($asset_path)) {
                FileHelper::createDirectory($asset_path, $mode, $recursive);
                //echo "directory create successfully News";
            }
            $model->ImageFile = UploadedFile::getInstance($model, 'image');
            //var_dump($model->ImageFile);die;
            // check Image File is Empty form form
            if (!empty($model->ImageFile)) {
                $imagefileName = yii::$app->security->generateRandomString();
                $model->ImageFile->saveAs($asset_path . $imagefileName . '.' . $model->ImageFile->extension, false);
                $model->image = $actualPath . $imagefileName . '.' . $model->ImageFile->extension;
            }
            //parent photo insert
            $asset_path1 = 'images/' . $user . '/parent-photo/';
            $mode1 = 0777;
            $recursive1 = true;
            if (!is_dir($asset_path1)) {
                FileHelper::createDirectory($asset_path1, $mode1, $recursive1);
                //echo "directory create successfully News";
            }
            $model->ParentPhoto = UploadedFile::getInstance($model, 'guardian_image');
            //var_dump($model->ParentPhoto);die;
            // check Image File is Empty form form
            if (!empty($model->ParentPhoto)) {
                $imagefileName1 = yii::$app->security->generateRandomString();
                $model->ParentPhoto->saveAs($asset_path1 . $imagefileName1 . '.' . $model->ParentPhoto->extension, false);
                $model->guardian_image = $asset_path1 . $imagefileName1 . '.' . $model->ParentPhoto->extension;
            }

            //chori-birth-certificate doc insert
            $asset_path2 = 'images/' . $user . '/birth-certificate-doc/';
            $mode2 = 0777;
            $recursive2 = true;
            if (!is_dir($asset_path2)) {
                FileHelper::createDirectory($asset_path2, $mode2, $recursive2);
                //echo "directory create successfully News";
            }
            $model->BirthCertificate = UploadedFile::getInstance($model, 'chori_birth_certificate_doc');
            //var_dump($model->ParentPhoto);die;
            // check Image File is Empty form form
            if (!empty($model->BirthCertificate)) {
                $imagefileName2 = yii::$app->security->generateRandomString();
                $model->BirthCertificate->saveAs($asset_path2 . $imagefileName2 . '.' . $model->BirthCertificate->extension, false);
                $model->chori_birth_certificate_doc = $asset_path2 . $imagefileName2 . '.' . $model->BirthCertificate->extension;
            }

            //parent citizenship upload
            $asset_path3 = 'images/' . $user . '/parent-citizen-doc/';
            $mode3 = 0777;
            $recursive3 = true;
            if (!is_dir($asset_path3)) {
                FileHelper::createDirectory($asset_path3, $mode3, $recursive3);
                //echo "directory create successfully News";
            }
            $model->ParentCitizen = UploadedFile::getInstance($model, 'parents_citizenship_doc');
            //var_dump($model->ParentPhoto);die;
            // check Image File is Empty form form
            if (!empty($model->ParentCitizen)) {
                $imagefileName3 = yii::$app->security->generateRandomString();
                $model->ParentCitizen->saveAs($asset_path3 . $imagefileName3 . '.' . $model->ParentCitizen->extension, false);
                $model->parents_citizenship_doc = $asset_path3 . $imagefileName3 . '.' . $model->ParentCitizen->extension;
            }

            //sastha document upload
            $asset_path4 = 'images/' . $user . '/sastha-citizen-doc/';
            $mode4 = 0777;
            $recursive4 = true;
            if (!is_dir($asset_path4)) {
                FileHelper::createDirectory($asset_path4, $mode4, $recursive4);
                //echo "directory create successfully News";
            }
            $model->SasthaCertificate = UploadedFile::getInstance($model, 'sastha_certificate');
            //var_dump($model->ParentPhoto);die;
            // check Image File is Empty form form
            if (!empty($model->SasthaCertificate)) {
                $imagefileName4 = yii::$app->security->generateRandomString();
                $model->SasthaCertificate->saveAs($asset_path4 . $imagefileName4 . '.' . $model->SasthaCertificate->extension, false);
                $model->sastha_certificate = $asset_path4 . $imagefileName4 . '.' . $model->SasthaCertificate->extension;
            }
            //HOspital certificate

            $asset_path5 = 'images/' . $user . '/hospital-doc/';
            $mode5 = 0777;
            $recursive5 = true;
            if (!is_dir($asset_path5)) {
                FileHelper::createDirectory($asset_path5, $mode5, $recursive5);
                //echo "directory create successfully News";
            }
            $model->HospitalCertificate = UploadedFile::getInstance($model, 'hospital_certificate');
            //var_dump($model->ParentPhoto);die;
            // check Image File is Empty form form
            if (!empty($model->HospitalCertificate)) {
                $imagefileName5 = yii::$app->security->generateRandomString();
                $model->HospitalCertificate->saveAs($asset_path5 . $imagefileName5 . '.' . $model->HospitalCertificate->extension, false);
                $model->hospital_certificate = $asset_path5 . $imagefileName5 . '.' . $model->HospitalCertificate->extension;
            }
            //insert mother doc
            $asset_path6= 'images/' . $user . '/mother-citizenship-doc/';
            $mode6 = 0777;
            $recursive6 = true;
            if (!is_dir($asset_path6)) {
                FileHelper::createDirectory($asset_path6, $mode6, $recursive6);
                //echo "directory create successfully News";
            }
            $model->MotherCertificate = UploadedFile::getInstance($model, 'mother_citizenship_doc');
            //var_dump($model->ParentPhoto);die;
            // check Image File is Empty form form
            if (!empty($model->MotherCertificate)) {
                $imagefileName6 = yii::$app->security->generateRandomString();
                $model->MotherCertificate->saveAs($asset_path6 . $imagefileName6 . '.' . $model->MotherCertificate->extension, false);
                $model->mother_citizenship_doc = $asset_path6 . $imagefileName6 . '.' . $model->MotherCertificate->extension;
            }
            //insert wda  doc
            $asset_path7= 'images/' . $user . '/wda-sifarish-doc/';
            $mode7 = 0777;
            $recursive7 = true;
            if (!is_dir($asset_path7)) {
                FileHelper::createDirectory($asset_path7, $mode7, $recursive7);
                //echo "directory create successfully News";
            }
            $model->WodaSifarish = UploadedFile::getInstance($model, 'woda_sifarish_doc');
           // var_dump($model->WodaSifarish);die;
            // check Image File is Empty form form
            if (!empty($model->WodaSifarish)) {
                $imagefileName7 = yii::$app->security->generateRandomString();
                $model->WodaSifarish->saveAs($asset_path7 . $imagefileName7 . '.' . $model->WodaSifarish->extension, false);
                $model->woda_sifarish_doc = $asset_path7 . $imagefileName7 . '.' . $model->WodaSifarish->extension;
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                var_dump($model->errors);
                die;
            }
        }
    }

        return $this->render('create', [
                    'model' => $model,
                    'mes'=>0,
        ]);
    }

    /**
     * Updates an existing ChoriBachat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $helper=new Helper();
        $model = $this->findModel($id);
        $user = yii::$app->user->id;
        $oldImage = $model->image;
        $motherDoc=$model->mother_citizenship_doc;
        $parentImage = $model->parents_citizenship_doc;
        $birthCertificate = $model->chori_birth_certificate_doc;
        $parentCertificate = $model->parents_citizenship_doc;
        $sasthaCertificate = $model->sastha_certificate;
        $hospitalCertificate = $model->hospital_certificate;
        $wodaDoc=$model->woda_sifarish_doc;
        // var_dump($oldImage);die;
        if ($model->load(Yii::$app->request->post())) {
            if(substr_count($model->dob,"__")>0){
                Yii::$app->session->setFlash('message','कृपया जन्म मिति सच्च्याउनुहोस्');
                return $this->render('create', [
                    'model' => $model,
                    'mes'=>1,
                ]);
            }
            else if(substr_count($model->birth_certificate_date,'__')>0){
                Yii::$app->session->setFlash('message','कृपया दर्ता मिति सच्च्याउनुहोस्');
                return $this->render('create', [
                    'model' => $model,
                    'mes'=>2,
                ]);
            }
            $nep_date=$helper->actionNepaliDate();
            $nep_date1=explode('-',$nep_date);
            $dob=explode('-',$model->dob);
            if((int)$nep_date1[0]>(int)$dob[0]){
                if((int)$nep_date1[1]>(int)$dob[1]){
                    $age=(int)$nep_date1[0]-(int)$dob[0];
                }else if((int)$nep_date1[1]==(int)$dob[1]){
                    if((int)$nep_date1[2]>=(int)$dob[2]){
                        $age=(int)$nep_date1[0]-(int)$dob[0];
                    }else{
                        $age=((int)$nep_date1[0]-(int)$dob[0])-(int)1;
                    }
                }else{
                    
                    $age=((int)$nep_date1[0]-(int)$dob[0])-(int)1;
                }}
                else{
                    $age=0;
                }
            $model->age=$age;
            $asset_path = 'images/' . $user . '/chori-image/';
            $actualPath = 'images/' . $user . '/chori-image/';

            $mode = 0777;
            $recursive = true;
            if (!is_dir($asset_path)) {
                FileHelper::createDirectory($asset_path, $mode, $recursive);
                //echo "directory create successfully News";
            }
            $model->ImageFile = UploadedFile::getInstance($model, 'update_file');
            //var_dump($model->ImageFile);die;
            // check Image File is Empty form form
            if (!empty($model->ImageFile)) {
                $imagefileName = yii::$app->security->generateRandomString();
                $model->ImageFile->saveAs($asset_path . $imagefileName . '.' . $model->ImageFile->extension, false);
                $model->image = $actualPath . $imagefileName . '.' . $model->ImageFile->extension;
            } 
            //update parent photo
            $asset_path1 = 'images/' . $user . '/parent-photo/';
            $mode1 = 0777;
            $recursive1 = true;
            if (!is_dir($asset_path1)) {
                FileHelper::createDirectory($asset_path1, $mode1, $recursive1);
                //echo "directory create successfully News";
            }
            $model->ParentPhoto = UploadedFile::getInstance($model, 'update_parent_file');
            //var_dump($model->ParentPhoto);die;
            // check Image File is Empty form form
            if (!empty($model->ParentPhoto)) {
                $imagefileName1 = yii::$app->security->generateRandomString();
                $model->ParentPhoto->saveAs($asset_path1 . $imagefileName1 . '.' . $model->ParentPhoto->extension, false);
                $model->guardian_image = $asset_path1 . $imagefileName1 . '.' . $model->ParentPhoto->extension;
            } else {
                $model->parents_citizenship_doc = $parentImage;
            }

            $tfile = 'images/' . $user . '/thumb-left';
            define('UPLOAD_DIR', $tfile);
            // check Image File is Empty form form
            if (!empty($model->thumbLeft)) {

                $image_parts2 = explode(";base64,", $model->thumbLeft);
                // var_dump($image_parts2);die;
                $image_type_aux2 = explode("image/", $image_parts2[0]);
                $image_type2 = $image_type_aux2[1];
                $image_base64_2 = base64_decode($image_parts2[1]);
                $file2 = UPLOAD_DIR . uniqid() . '.png';
                //var_dump($file2);die;
                file_put_contents($file2, $image_base64_2);
                $model->thumb_left = $file2;
                // var_dump($file2);die;
            }
            
            // insert right thumb
            //$tfile1 = 'images/' .$user . '/thumb-right';
            // define('UPLOAD_DIR', $tfile1);
            // check Image File is Empty form form
            if (!empty($model->thumbRight)) {

                $image_parts3 = explode(";base64,", $model->thumbRight);
                //var_dump($image_parts3);die;
                $image_type_aux3 = explode("image/", $image_parts3[0]);
                $image_type3 = $image_type_aux3[1];
                $image_base64_3 = base64_decode($image_parts3[1]);
                $file3 = UPLOAD_DIR . uniqid() . '.png';
                //var_dump($file2);die;
                file_put_contents($file3, $image_base64_3);
                $model->thumb_right = $file3;
                // var_dump($file2);die;
            }   
            //camera_image_child
            if (!empty($model->photo_from_camera)) {

                $image_parts2 = explode(";base64,", $model->photo_from_camera);
                $image_type_aux2 = explode("image/", $image_parts2[0]);
                $image_type2 = $image_type_aux2[1];
                $image_base64_2 = base64_decode($image_parts2[1]);
                $file2 = UPLOAD_DIR . uniqid() . '.png';
                file_put_contents($file2, $image_base64_2);
                $model->image = $file2;
                // var_dump($file2);die;
            }
            //camera_image_guardian
            if (!empty($model->photo_from_camera_guardian)) {

                $image_parts2 = explode(";base64,", $model->photo_from_camera_guardian);
                $image_type_aux2 = explode("image/", $image_parts2[0]);
                $image_type2 = $image_type_aux2[1];
                $image_base64_2 = base64_decode($image_parts2[1]);
                $file3 = UPLOAD_DIR . uniqid() . '.png';
                file_put_contents($file3, $image_base64_2);
                $model->guardian_image = $file3;
                // var_dump($file2);die;
            }
            //birth certificate update
            $asset_path2 = 'images/' . $user . '/birth-certificate-doc/';
            $mode2 = 0777;
            $recursive2 = true;
            if (!is_dir($asset_path2)) {
                FileHelper::createDirectory($asset_path2, $mode2, $recursive2);
                //echo "directory create successfully News";
            }
            $model->BirthCertificate = UploadedFile::getInstance($model, 'chori_birth_certificate_doc');
            //var_dump($model->ParentPhoto);die;
            // check Image File is Empty form form
            if (!empty($model->BirthCertificate)) {
                $imagefileName2 = yii::$app->security->generateRandomString();
                $model->BirthCertificate->saveAs($asset_path2 . $imagefileName2 . '.' . $model->BirthCertificate->extension, false);
                $model->chori_birth_certificate_doc = $asset_path2 . $imagefileName2 . '.' . $model->BirthCertificate->extension;
            } else {
                $model->chori_birth_certificate_doc = $birthCertificate;
            }
            //parent certificate
            $asset_path3 = 'images/' . $user . '/parent-citizen-doc/';
            $mode3 = 0777;
            $recursive3 = true;
            if (!is_dir($asset_path3)) {
                FileHelper::createDirectory($asset_path3, $mode3, $recursive3);
                //echo "directory create successfully News";
            }
            $model->ParentCitizen = UploadedFile::getInstance($model, 'parents_citizenship_doc');
            //var_dump($model->ParentPhoto);die;
            // check Image File is Empty form form
            if (!empty($model->ParentCitizen)) {
                $imagefileName3 = yii::$app->security->generateRandomString();
                $model->ParentCitizen->saveAs($asset_path3 . $imagefileName3 . '.' . $model->ParentCitizen->extension, false);
                $model->parents_citizenship_doc = $asset_path3 . $imagefileName3 . '.' . $model->ParentCitizen->extension;
            } else {
                $model->parents_citizenship_doc = $parentCertificate;
            }

            //sastha certificate update
            $asset_path4 = 'images/' . $user . '/sastha-citizen-doc/';
            $mode4 = 0777;
            $recursive4 = true;
            if (!is_dir($asset_path4)) {
                FileHelper::createDirectory($asset_path4, $mode4, $recursive4);
                //echo "directory create successfully News";
            }
            $model->SasthaCertificate = UploadedFile::getInstance($model, 'sastha_certificate');
            //var_dump($model->ParentPhoto);die;
            // check Image File is Empty form form
            if (!empty($model->SasthaCertificate)) {
                $imagefileName4 = yii::$app->security->generateRandomString();
                $model->SasthaCertificate->saveAs($asset_path4 . $imagefileName4 . '.' . $model->SasthaCertificate->extension, false);
                $model->sastha_certificate = $asset_path4 . $imagefileName4 . '.' . $model->SasthaCertificate->extension;
            } else {
                $model->sastha_certificate = $sasthaCertificate;
            }
            //hospital doc update
            $asset_path5 = 'images/' . $user . '/hospital-doc/';
            $mode5 = 0777;
            $recursive5 = true;
            if (!is_dir($asset_path5)) {
                FileHelper::createDirectory($asset_path5, $mode5, $recursive5);
                //echo "directory create successfully News";
            }
            $model->HospitalCertificate = UploadedFile::getInstance($model, 'hospital_certificate');
            //var_dump($model->ParentPhoto);die;
            // check Image File is Empty form form
            if (!empty($model->HospitalCertificate)) {
                $imagefileName5 = yii::$app->security->generateRandomString();
                $model->HospitalCertificate->saveAs($asset_path5 . $imagefileName5 . '.' . $model->HospitalCertificate->extension, false);
                $model->hospital_certificate = $asset_path5 . $imagefileName5 . '.' . $model->HospitalCertificate->extension;
            } else {
                $model->hospital_certificate = $hospitalCertificate;
            }
            //mother update doc
            $asset_path6 = 'images/' . $user . '/mother-citizenship-doc/';
            $mode6 = 0777;
            $recursive6 = true;
            if (!is_dir($asset_path6)) {
                FileHelper::createDirectory($asset_path6, $mode6, $recursive6);
                //echo "directory create successfully News";
            }
            $model->MotherCertificate = UploadedFile::getInstance($model, 'mother_citizenship_doc');
            //var_dump($model->ParentPhoto);die;
            // check Image File is Empty form form
            if (!empty($model->MotherCertificate)) {
                $imagefileName6 = yii::$app->security->generateRandomString();
                $model->MotherCertificate->saveAs($asset_path6 . $imagefileName6 . '.' . $model->MotherCertificate->extension, false);
                $model->mother_citizenship_doc = $asset_path6 . $imagefileName6 . '.' . $model->MotherCertificate->extension;
            } else {
                $model->mother_citizenship_doc = $motherDoc;
            }
            
            //sifarish update doc
            $asset_path7 = 'images/' . $user . '/wda-sifarish-doc/';
            $mode7 = 0777;
            $recursive7 = true;
            if (!is_dir($asset_path7)) {
                FileHelper::createDirectory($asset_path7, $mode7, $recursive7);
                //echo "directory create successfully News";
            }
            $model->WodaSifarish = UploadedFile::getInstance($model, 'woda_sifarish_doc');
            //var_dump($model->ParentPhoto);die;
            // check Image File is Empty form form
            if (!empty($model->WodaSifarish)) {
                $imagefileName7 = yii::$app->security->generateRandomString();
                $model->WodaSifarish->saveAs($asset_path7 . $imagefileName7 . '.' . $model->WodaSifarish->extension, false);
                $model->woda_sifarish_doc = $asset_path7 . $imagefileName7 . '.' . $model->WodaSifarish->extension;
            } else {
                $model->woda_sifarish_doc = $wodaDoc;
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ChoriBachat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionProvince() {
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

    public function actionMunicipal() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
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

    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ChoriBachat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ChoriBachat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ChoriBachat::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
