<?php

namespace app\controllers;

use Yii;
use app\models\BankDetails;
use app\models\BankDetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BankDetailsController implements the CRUD actions for BankDetails model.
 */
class BankDetailsController extends Controller
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
     * Lists all BankDetails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BankDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BankDetails model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BankDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BankDetails();

        if ($model->load(Yii::$app->request->post())) {
            $user = \yii::$app->user->id;
            $model->fk_user_id =$user;
            $user_details = \app\models\Users::findOne(['id'=>$user]);

            Yii::$app->db->createCommand()
                ->update('bank_details',['status'=>0],
                ['fk_municipal_id'=>$user_details['fk_municipal_id']])
                ->execute();
            $model->fk_municipal_id =$user_details->fk_municipal_id;
            $model->fk_district_id=$user_details->fk_district_id;
            $model->fk_province_id=$user_details->fk_province_id;
            $model->created_date = date('Y-m-d');
            $model->status=1;
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionStatus($id){
        $helper=new Helper();
        $user_id=$helper->getUserId();
        $user_details=\app\models\Users::findone(['id'=>$user_id]);
        Yii::$app->db->createCommand()
        ->update('bank_details',['status'=>0],
        ['fk_user_id'=>$user_details['id']])
        ->execute();
        Yii::$app->db->createCommand()
        ->update('bank_details',['status'=>1],
        ['id'=>$id])
        ->execute();

        return $this->redirect(['index']);
    }
    /**
     * Updates an existing BankDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $user = \yii::$app->user->id;
            $model->fk_user_id =$user;
            $user_details = \app\models\Users::findOne(['id'=>$user]);
            $model->fk_municipal_id =$user_details->fk_municipal_id;
            $model->created_date = date('Y-m-d');
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        }
            
        

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BankDetails model.
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
     * Finds the BankDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BankDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BankDetails::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
