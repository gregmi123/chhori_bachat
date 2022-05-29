<?php

namespace app\controllers;

use Yii;
use app\models\Dismiss;
use app\models\DismissSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DismissController implements the CRUD actions for Dismiss model.
 */
class DismissController extends Controller
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
     * Lists all Dismiss models.
     * @return mixed
     */
    public function actionIndex()
    {
        $user_id = \yii::$app->user->id;
        $user_details = \app\models\Users::findOne(['id'=>$user_id]);

        $searchModel = new DismissSearch(['type'=>2,'fk_user_id'=>$user_id,'fk_municipal_id'=>$user_details->fk_municipal_id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      //  $dataProvider->query->where(['type'=>2])->where(['fk_user_id'=>$user_id])->andWhere(['fk_municipal_id'=>$user_details->fk_municipal_id]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionDepositIndex()
    {
        $user_id = \yii::$app->user->id;
        $user_details = \app\models\Users::findOne(['id'=>$user_id]);

        $searchModel = new DismissSearch(['type'=>1,'fk_user_id'=>$user_id,'fk_municipal_id'=>$user_details->fk_municipal_id]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      //  $dataProvider->query->where(['type'=>1]);
        return $this->render('deposit_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Dismiss model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if($model->type==2){
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }else{
            return $this->render('deposit_view', [
                'model' => $this->findModel($id),
            ]);
    }
    }
    /**
     * Creates a new Dismiss model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dismiss();
        //2=>dismiss,1=>deposit
        if ($model->load(Yii::$app->request->post())) {
            $model->created_date= date('Y-m-d');
            $user_id = \yii::$app->user->id;
            $user_details = \app\models\Users::findOne(['id'=>$user_id]);
            $model->fk_municipal_id =$user_details->fk_municipal_id;
            $model->fk_user_id =$user_id;
            $model->type=2;
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionDepositCreate()
    {
        $model = new Dismiss();

        if ($model->load(Yii::$app->request->post())) {
            $model->created_date= date('Y-m-d');
            $user_id = \yii::$app->user->id;
            $user_details = \app\models\Users::findOne(['id'=>$user_id]);
            $model->fk_municipal_id =$user_details->fk_municipal_id;
            $model->fk_user_id =$user_id;
            $model->type=1;
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('deposit_create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Dismiss model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Dismiss model.
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
     * Finds the Dismiss model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dismiss the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dismiss::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
