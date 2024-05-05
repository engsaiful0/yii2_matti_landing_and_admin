<?php

namespace multeback\modules\product\controllers;

use Yii;
use yii\helpers\Url;
use multebox\models\Title;
use multebox\models\search\Title as TitleSearch;
use multebox\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

/**
 * TitleController implements the CRUD actions for Title model.
 */
class TitleController extends Controller
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
     * Lists all Title models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new TitleSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Title model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new Title model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Title;
        if($model->load(Yii::$app->request->post())){
            if ( $model->save()) {
                Yii::$app->session->setFlash('success', 'Data has been saved successfully.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Data has not been  saved successfully.');

            }
        }else{
            return $this->render('create', [
                'model' => $model,
            ]);
        }


    }

    /**
     * Updates an existing Title model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Data has been updated successfully.');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            Yii::$app->session->setFlash('error', 'Data has not been  updated successfully.');
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Title model.
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

    /**
     * Finds the Title model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Title the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Title::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

	public function actionActivate($id)
    {

        $result = $this->findModel($id);
		$result->active = 1;
		$result->updated_at = time();
		$result->update();
        return $this->redirect(['index']);
    }

	public function actionDeactivate($id)
    {

        $result = $this->findModel($id);
		$result->active = 0;
		$result->updated_at = time();
//		echo '<pre>';
//		var_dump($result->save());
//		die;
		$result->update();
        return $this->redirect(['index']);
    }
}
