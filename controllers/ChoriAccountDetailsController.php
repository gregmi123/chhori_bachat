<?php

namespace app\controllers;

use Yii;
use app\models\ChoriAccountDetails;
use app\models\ChoriAccountDetailsSearch;
use app\models\WithdrawChoriAccount;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\PaymentChori;
use app\models\OtherMonthPayment;

/**
 * ChoriAccountDetailsController implements the CRUD actions for ChoriAccountDetails model.
 */
class ChoriAccountDetailsController extends Controller
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
     * Lists all ChoriAccountDetails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $helper =new Helper();
        $searchModel = new ChoriAccountDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionWithdraw()
    {
        $helper =new Helper();
        $searchModels = new WithdrawChoriAccount();
        $dataProviders = $searchModels->search(Yii::$app->request->queryParams);
        
        
        return $this->render('withdraw', [
            'searchModels' => $searchModels,
            'dataProviders' => $dataProviders,
        ]);
    }
    public function actionDismiss()
    {
        $helper =new Helper();
        $searchModels = new WithdrawChoriAccount();
        $dataProviders = $searchModels->search(Yii::$app->request->queryParams);
        
        
        return $this->render('dismiss', [
            'searchModels' => $searchModels,
            'dataProviders' => $dataProviders,
        ]);
    }

    /**
     * Displays a single ChoriAccountDetails model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
       
       $account_details = (new \yii\db\Query())
               ->select('chori_account_details.account_no,chori_account_details.account_open_date,chori_bachat.name,'
                       . 'bank_details.bank_name')
               ->from('chori_account_details')
               ->join('JOIN','chori_bachat','chori_bachat.id=chori_account_details.fk_chori_bachat')
               ->join('JOIN','bank_details','bank_details.id=chori_account_details.bank_name')
               ->where(['chori_account_details.id'=>$id])
               ->all();
       //var_dump($account_details);die;
       
        return $this->redirect(array('//payment-chori/viewchori','id'=>$id));
    }
    public function actionViews($id)
    {
       
       $account_details = (new \yii\db\Query())
               ->select('chori_account_details.account_no,chori_account_details.account_open_date,chori_bachat.name,'
                       . 'bank_details.bank_name')
               ->from('chori_account_details')
               ->join('JOIN','chori_bachat','chori_bachat.id=chori_account_details.fk_chori_bachat')
               ->join('JOIN','bank_details','bank_details.id=chori_account_details.bank_name')
               ->where(['chori_account_details.id'=>$id])
               ->all();
       //var_dump($account_details);die;
       
        return $this->redirect(array('//payment-chori/viewchori','id'=>$id));
    }
    /**
     * Creates a new ChoriAccountDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ChoriAccountDetails();
        

        if ($model->load(Yii::$app->request->post())) {
            $user = \yii::$app->user->id;
            $model->fk_user_id = $user;
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
     * Updates an existing ChoriAccountDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $chori_bachat = \app\models\ChoriBachat::findOne(['id'=>$id]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'chori_bachat' => $chori_bachat,
        ]);
    }

    /**
     * Deletes an existing ChoriAccountDetails model.
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
     * Finds the ChoriAccountDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ChoriAccountDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ChoriAccountDetails::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
