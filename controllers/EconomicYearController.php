<?php

namespace app\controllers;

use Yii;
use app\models\EconomicYear;
use app\models\EconomicYearSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EconomicYearController implements the CRUD actions for EconomicYear model.
 */
class EconomicYearController extends Controller
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
     * Lists all EconomicYear models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout='province';
        $searchModel = new EconomicYearSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EconomicYear model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout='province';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionStatus($id){
        $helper=new Helper();
        $user_id=$helper->getUserId();
        $user_details=\app\models\Users::findone(['id'=>$user_id]);
        Yii::$app->db->createCommand()
        ->update('economic_year',['status'=>0],
        ['fk_province_id'=>$user_details['fk_province_id']])
        ->execute();
        Yii::$app->db->createCommand()
        ->update('economic_year',['status'=>1],
        ['id'=>$id])
        ->execute();

        return $this->redirect(['index']);
    }
    public function actionActive($id){
        $helper=new Helper();
        $user_id=$helper->getUserId();
        $user_details=\app\models\Users::findone(['id'=>$user_id]);
        Yii::$app->db->createCommand()
        ->update('economic_year',['status'=>0],
        ['fk_province_id'=>$user_details['fk_province_id']])
        ->execute();
        Yii::$app->db->createCommand()
        ->update('economic_year',['status'=>1],
        ['id'=>$id])
        ->execute();

        return $this->redirect(['index']);
    }

    /**
     * Creates a new EconomicYear model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout='province';
        $helper =new Helper();
        $user_id=$helper->getUserId();
        $user_details=\app\models\Users::findone(['id'=>$user_id]);
        $model = new EconomicYear();
        $helper =new Helper();

        if ($model->load(Yii::$app->request->post())) {
            
            $year_check=\app\models\EconomicYear::find()->where(['economic_year'=>$model->economic_year])->andWhere(['fk_province_id'=>$user_details['fk_province_id']])->one();
            if($year_check){
                Yii::$app->session->setFlash('message', 'आर्थिक वर्ष पहिले सिर्जना भैसकेको छ |');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }else{
            Yii::$app->db->createCommand()
            ->update('economic_year',['status'=>0],
            ['fk_province_id'=>$user_details['fk_province_id']])
            ->execute();

            $model->fk_province_id=$user_details['fk_province_id'];
            $model->created_date=date('Y-m-d');
            $model->status=1;
            if($model->save()){
              return $this->redirect(['view', 'id' => $model->id]); 
            }
        }
           
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EconomicYear model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->layout='province';
        $helper =new Helper();
        $user_id=$helper->getUserId();
        $user_details=\app\models\Users::findone(['id'=>$user_id]);
        $model = $this->findModel($id);
        $helper =new Helper();

        if ($model->load(Yii::$app->request->post())){
            $year_check=\app\models\EconomicYear::find()->where(['economic_year'=>$model->economic_year])->andWhere(['fk_province_id'=>$user_details['fk_province_id']])->one();
            if($year_check){
                Yii::$app->session->setFlash('message', 'आर्थिक वर्ष पहिले सिर्जना भैसकेको छ |');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }else{
            if($model->status=='1'){
                Yii::$app->db->createCommand()
                ->update('economic_year',['status'=>0],
                ['fk_province_id'=>$model->fk_province_id])
                ->execute();
            }
            if($model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
            }
        }
    }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EconomicYear model.
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
     * Finds the EconomicYear model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EconomicYear the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EconomicYear::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
