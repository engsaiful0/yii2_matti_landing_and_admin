<?php

namespace multeback\modules\product\controllers;

use Yii;

use multebox\models\Paymentlogo;
use multebox\models\search\Paymentlogo as PaymentlogoSearch;
use multebox\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ChartController implements the CRUD actions for Chart model.
 */
class PaymentlogoController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Chart models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PaymentlogoSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
//        echo '<pre>';
//        print_r($dataProvider);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Chart model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new Chart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Paymentlogo;
		$model->scenario = 'create';

        if ($model->load(Yii::$app->request->post())) 
		{
			$model->paymentlogo_file = UploadedFile::getInstance($model, 'paymentlogo_file');
			$name = uniqid($model->id).'.'.$model->paymentlogo_file->extension;
            $model->upload($name);
            $model->paymentlogo_file=$name;

//			echo '<pre>';
//			print_r($model);

			if($model->save())
			{
                Yii::$app->session->setFlash('success', 'Data has been saved successfully.');
				return $this->redirect(['index']);
			}
			else 
			{
                Yii::$app->session->setFlash('error', 'Data has not been  saved successfully.');
				return $this->render('create', [
					'model' => $model,
				]);
			}
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Chart model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$oldname = $model->paymentlogo_file;

        if ($model->load(Yii::$app->request->post())) 
		{
			$newChart = UploadedFile::getInstance($model, 'paymentlogo_file');

			if(!empty($newChart))
			{
                $model->paymentlogo_file = UploadedFile::getInstance($model, 'paymentlogo_file');
                $name = uniqid($model->id).'.'.$model->paymentlogo_file->extension;
                $model->upload($name);
                $model->paymentlogo_file=$name;
			}
			else
			{
				$model->paymentlogo_file = $oldname;
			}

			if($model->save())
			{
                Yii::$app->session->setFlash('success', 'Data has been updated successfully.');
				return $this->redirect(['index']);
			}
			else 
			{
                Yii::$app->session->setFlash('error', 'Data has not been  updated successfully.');
				return $this->render('update', [
					'model' => $model,
				]);
			}
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Chart model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete())
        {
            Yii::$app->session->setFlash('success', 'Data has been deleted successfully.');
        }else{
            Yii::$app->session->setFlash('error', 'Data has not been deleted successfully.');
        }

        return $this->redirect(['index']);
    }
    public function actionActivate($id)
    {

        $result = $this->findModel($id);
        $result->active = 1;
        $result->updated_at = time();
        $result->save();
        return $this->redirect(['index']);
    }

    public function actionDeactivate($id)
    {

        $result = $this->findModel($id);
        $result->active = 0;
        $result->updated_at = time();
        $result->save();
        return $this->redirect(['index']);
    }
    /**
     * Finds the Chart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Chart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Paymentlogo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
