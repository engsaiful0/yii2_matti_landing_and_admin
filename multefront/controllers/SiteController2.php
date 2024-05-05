<?php
namespace multefront\controllers;

use function GuzzleHttp\Promise\all;
use multebox\models\CurrencyConversion;
use multebox\models\Faq;
use multebox\models\Logodetails;
use Yii;
use yii\helpers\Json;
use multebox\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use multebox\models\LoginForm;
use multebox\models\Cart;
use multebox\models\Currency;
use multebox\models\Vendor;
use multebox\models\ImageUpload;
use multebox\models\SendEmail;
use yii\base\UserException;
use multebox\models\SignupForm;
use multefront\models\PasswordResetRequestForm;
use multefront\models\ResetPasswordForm;
use multebox\models\AddressModel;
use multebox\models\ContactModel;
use multebox\models\Address;
use multefront\models\Site;
use multebox\models\Contact;
use multebox\models\AuthAssignment;
use multebox\models\User;
use multebox\models\Wishlist;
use multebox\models\Comparison;
use multebox\models\Newsletter;
use multebox\models\search\MulteModel;
use multebox\models\search\UserType as UserTypeSearch;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['currencyconversion', 'signup', 'vendor-signup', 'request-password-reset'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['error', 'index', 'about', 'delivery', 'privacy', 'returns', 'tnc', 'faq', 'contact', 'convert-system-currency', 'convert-system-language', 'news-signup', 'add-to-wishlist', 'compare', 'add-to-comparelist', 'delete-compare', 'ajax-unset-news-popup'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['logout', 'wishlist', 'delete-wishlist'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }
    public function actionCurrencyconversion()
    {
        $conversion_rate=1;
        $currencycode=$_POST['currencyid'];
        $data=explode('_',$currencycode);
       $conversions= CurrencyConversion::find()
           ->where(['to' => $data[1]])->all();
       foreach ($conversions as $value)
       {
           $conversion_rate=$value->conversion_rate;
       }
     echo $data[0].'_'.$conversion_rate;

    }
    public function actionSignup()
    {
        $password = $_REQUEST['SignupForm']['password'];

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()))
        {
            if ($user = $model->signup())
            {
                //MulteModel::saveFileToServer('nophoto.jpg', $user->id.'.png', Yii::$app->params['web_folder']."/users");
                SendEmail::sendNewUserEmail($user->email,$user->first_name." ".$user->last_name, $user->username, $password);
                if (Yii::$app->getUser()->login($user))
                {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    public function actionIndex()
    {

            // die;
            $model = new Site;
            $model->full_name = $_POST['full_name'];
            $model->email = $_POST['email'];
            $model->product_or_service_link = $_POST['product_or_service_link'];
            $model->week = $_POST['week'];
            $model->price = $_POST['price'];
            $model->invoice_no = $_POST['invoice_no'];
            //print_r($model);
            if (isset($_POST['full_name'])) {
                $result = Site::find()
                    ->where(['invoice_no' => $_POST['invoice_no']])->count();
                if($result==0) {
                    $model->save();
                    unset($_POST);
                    $_POST = array();
                    Yii::$app->session->setFlash('success', 'Data has been saved successfully.');

                }
                return $this->render('index');
            } else {
                return $this->render('index');
            }

    }

    public function actionCreate()
    {

        $model = new Address;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'added' => 'yes']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    protected function findModel($id)
    {
        if (($model = Site::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

}
