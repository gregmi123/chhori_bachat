<?php

namespace app\controllers;

use Yii;
use app\models\CheckPayment;
use app\models\CheckPaymentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CheckPaymentController implements the CRUD actions for CheckPayment model.
 */
class CheckPaymentController extends Controller
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
     * Lists all CheckPayment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CheckPaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CheckPayment model.
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
     * Creates a new CheckPayment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CheckPayment();
        $helper=new Helper();
        $activeChoriList = (new \yii\db\Query())
                ->select('chori_bachat.name,chori_bachat.dob,chori_bachat.tole_name,chori_bachat.birth_certificate_no,chori_bachat.birth_certificate_date,'
                        . 'chori_bachat.father_name,ward.ward_name as wname,'
                        . 'municipal.name as municipal_name,municipal.address')
                ->from('chori_bachat')
                ->join('JOIN', 'ward', 'ward.id=chori_bachat.fk_ward')
                ->join('JOIN', 'municipal', 'municipal.id=chori_bachat.fk_municipal_id')
                ->where(['chori_bachat.fk_user_id' => $helper->getUserId()])
                ->andWhere(['status' => 2])
                ->andWhere(['chori_bachat.fk_municipal_id' => $helper->getOrganization()])
                ->all();
        if ($model->load(Yii::$app->request->post())) {
            $model->created_date= date('Y-m-d');
            if($model->save()){
             return $this->redirect(['view', 'id' => $model->id]);   
            }
            
        }

        return $this->render('create', [
            'model' => $model,
            'activeChoriList'=>$activeChoriList,
        ]);
    }

    /**
     * Updates an existing CheckPayment model.
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
     * Deletes an existing CheckPayment model.
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
     * Finds the CheckPayment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CheckPayment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CheckPayment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
