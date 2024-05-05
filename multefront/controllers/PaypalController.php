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
use PayPal\Api\PayPal;/*Paypal IPN Library*/

use yii\base\ActionFilter;
use yii\web\BadRequestHttpException;
/**
 * Site controller
 */
class PaypalController extends Controller
{



    public function actionIndex()
    {
        return $this->render('success','refresh');

    }



}
