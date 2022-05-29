<?php

namespace app\controllers;

use Yii;
use app\models\Withdraw;
use app\models\WithdrawSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WithdrawController implements the CRUD actions for Withdraw model.
 */
class WithdrawController extends Controller
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
     * Lists all Withdraw models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WithdrawSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Withdraw model.
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
     * Creates a new Withdraw model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Withdraw();
        $user_id = yii::$app->user->id;
        $user_details =\app\models\Users::findOne(['id' => $user_id]);
        if ($model->load(Yii::$app->request->post())){
            $model->created_date= date('Y-m-d');
            $model->fk_municipal =$user_details->fk_municipal_id;
            $model->fk_user_id =$user_id;
            $model->fk_province=$user_details->fk_province_id;
            $model->fk_district=$user_details->fk_district_id;
            $model->type=1;
            $model->fk_chori=$id;

            $query=\app\models\ChoriAccountDetails::find()->where(['id'=>$model->fk_account])->andWhere(['fk_user_id'=>$user_id])->andWhere(['fk_municipal_id'=>$user_details['fk_municipal_id']])->one();
            if($query){
                Yii::$app->db->createCommand()
                ->update('chori_account_details',['bank_status'=>3],
                ['id'=>$model->fk_account,'fk_user_id'=>$user_id,'fk_municipal_id'=>$user_details['fk_municipal_id']])
                ->execute();
                Yii::$app->db->createCommand()
                ->update('chori_bachat',['status'=>6],
                ['id'=>$query['fk_chori_bachat'],'fk_user_id'=>$user_id,'fk_municipal_id'=>$user_details['fk_municipal_id']])
                ->execute();
                Yii::$app->db->createCommand()
                ->update('payment_chori',['status'=>7],
                ['fk_chori_account_details'=>$model->fk_account,'fk_user_id'=>$user_id,'fk_municipal'=>$user_details['fk_municipal_id']])
                ->execute();
            }
            if($model->save()){
                return $this->redirect(['//chori-account-details/withdraw']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'id'=>$id,
        ]);
    }
    public function actionDismissCreate($id)
    {
        $model = new Withdraw();
        $user_id = yii::$app->user->id;
        $user_details =\app\models\Users::findOne(['id' => $user_id]);
        if ($model->load(Yii::$app->request->post())){
            $model->created_date= date('Y-m-d');
            $model->fk_municipal =$user_details->fk_municipal_id;
            $model->fk_user_id =$user_id;
            $model->fk_province=$user_details->fk_province_id;
            $model->fk_district=$user_details->fk_district_id;
            $model->type=2;
            $model->fk_chori=$id;

            $query=\app\models\ChoriAccountDetails::find()->where(['id'=>$model->fk_account])->andWhere(['fk_user_id'=>$user_id])->andWhere(['fk_municipal_id'=>$user_details['fk_municipal_id']])->one();
            if($query){
                Yii::$app->db->createCommand()
                ->update('chori_account_details',['bank_status'=>4],
                ['id'=>$model->fk_account,'fk_user_id'=>$user_id,'fk_municipal_id'=>$user_details['fk_municipal_id']])
                ->execute();
                Yii::$app->db->createCommand()
                ->update('chori_bachat',['status'=>7],
                ['id'=>$query['fk_chori_bachat'],'fk_user_id'=>$user_id,'fk_municipal_id'=>$user_details['fk_municipal_id']])
                ->execute();
                Yii::$app->db->createCommand()
                ->update('payment_chori',['status'=>8],
                ['fk_chori_account_details'=>$model->fk_account,'fk_user_id'=>$user_id,'fk_municipal'=>$user_details['fk_municipal_id']])
                ->execute();
            }
            if($model->save()){
                return $this->redirect(['//chori-account-details/dismiss']);
            }
        }

        return $this->render('dismiss_create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Withdraw model.
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
     * Deletes an existing Withdraw model.
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
     * Finds the Withdraw model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Withdraw the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Withdraw::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
