<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use app\models\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
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
     * Lists all Users models.
     * @return mixed
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
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
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
        $model = new Users();

        if ($model->load(Yii::$app->request->post())) {

            if($model->user_type==2){
                if(empty($model->fk_municipal_id) || empty($model->fk_district_id)){
                    if(empty($model->fk_district_id)){
                        yii::$app->session->setFlash('message','District cannot be blank');
                        return $this->render('create', [
                            'model' => $model,
                            'u_id'=>2,
                        ]);
                    }
                }
            }
            if($model->user_type==3){
                if(empty($model->fk_municipal_id)){
                    yii::$app->session->setFlash('message','Municipal cannot be blank');
                    return $this->render('create', [
                        'model' => $model,
                        'u_id'=>3,
                    ]);
                }
            }
            $model->created_date = date('Y-m-d');
            $model->updated_date = date('Y-m-d');
            $model->authkey=yii::$app->security->generateRandomString();
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        }

        return $this->render('create', [
            'model' => $model,
            'u_id'=>1,
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
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
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())){
            if($model->user_type==2){
                if(empty($model->fk_municipal_id) || empty($model->fk_district_id)){
                    if(empty($model->fk_district_id)){
                        yii::$app->session->setFlash('message','District cannot be blank');
                        return $this->render('create', [
                            'model' => $model,
                            'u_id'=>2,
                        ]);
                    }
                }
            }
            if($model->user_type==3){
                if(empty($model->fk_municipal_id)){
                    yii::$app->session->setFlash('message','Municipal cannot be blank');
                    return $this->render('create', [
                        'model' => $model,
                        'u_id'=>3,
                    ]);
                }
            }
            if($model->user_type==1){
                $model->fk_municipal_id="";
                $model->fk_district_id="";
            }
            else if($model->user_type==2){
                $model->fk_municipal_id="";
            }
         $model->save(); 
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            
        ]);
    }
    
    public function actionVerification($id){
        $model=new Users();
        $user_id=yii::$app->user->id;
        $user_details=\app\models\Users::findone(['id'=>$user_id]);

        if ($model->load(Yii::$app->request->post())){
            if ($model->verify == $user_details['pin']) {
                    return $this->redirect(['profile', 'id' => $id]);
                }
            else {

                Yii::$app->session->setFlash('message', 'Password does not match !');
                return $this->render('verification', [
                    'model' => $model,
                    
                ]);
            }
        }
        return $this->render('verification', [
            'model' => $model,
            
        ]);

    }
    public function actionProfile($id)
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
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())){
            if($model->user_type==1){
                $model->fk_municipal_id="";
                $model->fk_district_id="";
                $model->fk_province_id=$user_details['fk_province_id'];
            }
            else if($model->user_type==2){
                $model->fk_municipal_id="";
                $model->fk_district_id=$user_details['fk_district_id'];
                $model->fk_province_id=$user_details['fk_province_id'];
            }else{
                $model->fk_municipal_id=$user_details['fk_municipal_id'];
                $model->fk_district_id=$user_details['fk_district_id'];
                $model->fk_province_id=$user_details['fk_province_id'];
            }
         $model->save(false);
         return $this->render('profile_update', [
            'model' => $model,
            
        ]);
        }

        return $this->render('profile_update', [
            'model' => $model,
            
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
