<?php

namespace app\controllers;

use Yii;
use app\models\Year;
use app\models\YearSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * YearController implements the CRUD actions for Year model.
 */
class YearController extends Controller
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
     * Lists all Year models.
     * @return mixed
     */
    public function actionActive($id){
        $helper=new Helper();
        $user_id=$helper->getUserId();
        $user_details=\app\models\Users::findone(['id'=>$user_id]);

        Yii::$app->db->createCommand()
        ->update('year',['status'=>1],
        ['id'=>$id])
        ->execute();

        return $this->redirect(['index']);
    }
    public function actionInactive($id){
        $helper=new Helper();
        $user_id=$helper->getUserId();
        $user_details=\app\models\Users::findone(['id'=>$user_id]);

        Yii::$app->db->createCommand()
        ->update('year',['status'=>0],
        ['id'=>$id])
        ->execute();

        return $this->redirect(['index']);
    }
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
        $searchModel = new YearSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Year model.
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
     * Creates a new Year model.
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
        $model = new Year();
        $helper=new Helper();
        if ($model->load(Yii::$app->request->post())) {

            $model->status=1;
            $model->created_date=$helper->actionNepaliDate();
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Year model.
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Year model.
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
     * Finds the Year model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Year the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Year::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
