<?php

namespace multeback\modules\user\controllers;

use multebox\models\Faq;
use multebox\models\Paidads;
use Yii;
use multebox\models\User;
use multebox\models\SessionDetails;
use multebox\models\ImageUpload;
use multebox\models\search\User as UserSearch;
use multebox\models\search\History as HistorySearch;
use multebox\models\search\SessionDetails as UserSessionSearch;
use multebox\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use multebox\models\SendEmail;
use multebox\models\AuthAssignment;
use multebox\models\search\Paidads as PaidadsSearch;
use multebox\models\search\MulteModel;

/**
 * UserController implements the CRUD actions for User model.
 */
class PaidadsController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
		if(Yii::$app->params['user_role'] != 'admin')
		{
			throw new \yii\web\ForbiddenHttpException(Yii::t('app', 'You dont have permissions to view this page.'));
		}

        $searchModel = new PaidadsSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        //die;
		if(!empty($_REQUEST['multiple_del'])){

			$rows=$_REQUEST['selection'];
			
			if($rows)
			{
				for($i=0;$i<count($rows);$i++){

					$this->findModel($rows[$i])->delete();

				}
			}

		}
		//die;
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single PaidAds model.
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

    protected function findModel($id)
    {
        if (($model = Paidads::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
