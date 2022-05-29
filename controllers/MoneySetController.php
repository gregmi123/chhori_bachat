<?php

namespace app\controllers;

use Yii;
use app\models\MoneySet;
use app\models\MoneySetSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Users;

/**
 * MoneySetController implements the CRUD actions for MoneySet model.
 */
class MoneySetController extends Controller
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
     * Lists all MoneySet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MoneySetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MoneySet model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionStatus($id){
        $helper=new Helper();
        $user_id=$helper->getUserId();
        $user_details=\app\models\Users::findone(['id'=>$user_id]);
        Yii::$app->db->createCommand()
        ->update('money_set',['status'=>0],
        ['fk_user_id'=>$user_details['id']])
        ->execute();
        Yii::$app->db->createCommand()
        ->update('money_set',['status'=>1],
        ['id'=>$id])
        ->execute();

        return $this->redirect(['index']);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MoneySet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MoneySet();
        $helper =new Helper();
        if ($model->load(Yii::$app->request->post())) {
            if($model->status=='1'){
                Yii::$app->db->createCommand()
                ->update('money_set',['status'=>0],
                ['fk_user_id' => $helper->getUserId(),'fk_municipal_id' => $helper->getOrganization()])
                ->execute();
            }
            $model->fk_user_id=$helper->getUserId();
            $model->fk_municipal_id =$helper->getOrganization();
            $model->created_date = date('Y-m-d');
            if($model->save()){
             return $this->redirect(['view', 'id' => $model->id]); 
            }
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MoneySet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $helper =new Helper();
        if ($model->load(Yii::$app->request->post())){
            if($model->status=='1'){
                Yii::$app->db->createCommand()
                ->update('money_set',['status'=>0],
                ['fk_user_id' => $helper->getUserId(),'fk_municipal_id' => $helper->getOrganization()])
                ->execute();
            }
            if($model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MoneySet model.
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
     * Finds the MoneySet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MoneySet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MoneySet::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
