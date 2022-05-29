<?php

namespace app\controllers;

use Yii;
use app\models\Ward;
use app\models\WardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;

/**
 * WardController implements the CRUD actions for Ward model.
 */
class WardController extends Controller
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
     * Lists all Ward models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    //     $user_id = \yii::$app->user->id;
    //     $user_details = \app\models\Users::findOne(['id'=>$user_id]);
    //     // $sql= Ward::find()->where(['fk_user_id'=>$user_id])->andWhere(['fk_municipal_id'=>$user_details->fk_municipal_id]);
    //     $totalCount = Yii::$app->db->createCommand('SELECT COUNT(*) FROM ward where fk_municipal_id='.$user_details['fk_municipal_id'])->queryScalar();

    // $dataProvider1 = new SqlDataProvider([
    //     'db' => Yii::$app->db,
    //     'sql' => 'SELECT * FROM ward where fk_municipal_id='.$user_details['fk_municipal_id'],
    //     'totalCount' => $totalCount,
    //     'sort' =>false,
    //     'pagination'=>array('pagesize'=>5),
        
    // ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
           
        ]);
    }

    /**
     * Displays a single Ward model.
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
     * Creates a new Ward model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ward();
        if ($model->load(Yii::$app->request->post())) {
            $user_id = \yii::$app->user->id;
            $user_details = \app\models\Users::findOne(['id'=>$user_id]);

            $ward_name=\app\models\Ward::find()->Where(['ward_name'=>$model->ward_name])->andWhere(['fk_user_id'=>$user_id])->one();
            $message=Yii::$app->session->setFlash('message','वडा पहिले सिर्जना भैसकेको छ');
            if($ward_name){
                return $this->render('create', [
                    'model' => $model,
                ]);
            }else{
            $model->created_date= date('Y-m-d');
            $model->fk_municipal_id =$user_details->fk_municipal_id;
            $model->fk_user_id =$user_id;
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
     * Updates an existing Ward model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->created_date= date('Y-m-d');
            $user_id = \yii::$app->user->id;
            $user_details = \app\models\Users::findOne(['id'=>$user_id]);
            $model->fk_municipal_id =$user_details->fk_municipal_id;
            $model->fk_user_id =$user_id;
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        }
        

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Ward model.
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
     * Finds the Ward model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ward the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ward::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
