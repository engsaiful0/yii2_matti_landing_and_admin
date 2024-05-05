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
                        'actions' => ['currencyconversion', 'signup', 'validateIpn','verifyTransaction','vendor-signup', 'request-password-reset'],
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
    public  function cus_paypal_ipn() {
        if ($this->paypal->validate_ipn() == true) {

            $payment_id = $_POST['custom'];
            $payment = $this->db->get_where('package_payment', array('package_payment_id' => $payment_id))->row();
            $data['payment_details'] = json_encode($_POST);
            $data['purchase_datetime'] = time();
            $data['payment_code'] = date('Ym', $data['purchase_datetime']) . $payment_id;
            $data['payment_timestamp'] = time();
            $data['payment_type'] = 'Paypal';
            $data['payment_status'] = 'paid';
            $data['expire'] = 'no';
            $this->db->where('package_payment_id', $payment_id);
            $this->db->update('package_payment', $data);

            $prev_product_upload = $this->db->get_where('user', array('user_id' => $payment->user_id))->row()->product_upload;

            $data1['product_upload'] = $prev_product_upload + $this->db->get_where('package', array('package_id' => $payment->package_id))->row()->upload_amount;

            $package_info[] = array('current_package' => $this->crud_model->get_type_name_by_id('package', $payment->package_id),
                'package_price' => $this->crud_model->get_type_name_by_id('package', $payment->package_id, 'amount'),
                'payment_type' => $data['payment_type'],
            );
            $data1['package_info'] = json_encode($package_info);

            $this->db->where('user_id', $payment->user_id);
            $this->db->update('user', $data1);
            recache();

            /* if ($this->email_model->subscruption_email('member', $payment->member_id, $payment->package_id)) {
              //echo 'email_sent';
              } else {
              //echo 'email_not_sent';
              $this->session->set_flashdata('alert', 'not_sent');
              } */
        }
    }

    /* FUNCTION: Loads after cancelling paypal */

    public  function cus_paypal_cancel() {
        $payment_id = $this->session->userdata('payment_id');
        $this->db->where('package_payment_id', $payment_id);
        $this->db->delete('package_payment');
        recache();
        $this->session->set_userdata('payment_id', '');
        $this->session->set_flashdata('alert', 'paypal_cancel');
        redirect(base_url() . 'home/premium_package', 'refresh');
    }

    /* FUNCTION: Loads after successful paypal payment */

    function cus_paypal_success() {
        $this->session->set_flashdata('alert', 'paypal_success');
        // redirect(base_url() . 'home/invoice/'.$this->session->userdata('payment_id'), 'refresh');
        $this->session->set_userdata('payment_id', '');
        redirect(base_url() . 'home/profile/part/payment_info', 'refresh');
    }
public function actionVerifyTransaction($data) {
    $paypalUrl='https://www.paypal.com/cgi-bin/webscr';
    //$paypalUrl = 'https://www.paypal.com/webapps/hermes?token=1SE59348P1094653S&useraction=commit&mfid=1604433203303_38970a052d363';
    $req = 'cmd=_notify-validate';
        foreach ($data as $key => $value) {
            $value = urlencode(stripslashes($value));
            $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value); // IPN fix
            $req .= "&$key=$value";
        }

        $ch = curl_init($paypalUrl);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
        $res = curl_exec($ch);

        if (!$res) {
            $errno = curl_errno($ch);
            $errstr = curl_error($ch);
            curl_close($ch);
            throw new Exception("cURL error: [$errno] $errstr");
        }

        $info = curl_getinfo($ch);

        // Check the http response
        $httpCode = $info['http_code'];
        if ($httpCode != 200) {
            throw new Exception("PayPal responded with http code $httpCode");
        }

        curl_close($ch);

        return $res === 'VERIFIED';
    }
    function actionValidateIpn() {

        //if($type == 'sandbox') {
          //  $this->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        ///} else if($type == 'original') {
            $paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
       // }
        # STEP 1: Read POST data

        # reading posted data from directly from $_POST causes serialization
        # issues with array data in POST
        # reading raw POST data from input stream instead.
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval)
        {
            $keyval = explode ('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }
        # read the post from PayPal system and add 'cmd'
        $req = 'cmd=_notify-validate';
        if(function_exists('get_magic_quotes_gpc'))
        {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value)
        {
            if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1)
            {
                $value = urlencode(stripslashes($value));
            }
            else
            {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }


        # STEP 2: Post IPN data back to paypal to validate

        $ch = curl_init($paypal_url);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close','User-Agent: Servie Ads'));


        # In wamp like environments that do not come bundled with root authority certificates,
        # please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
        # of the certificate as shown below.
        # curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
        if( !($res = curl_exec($ch)) ) {
            curl_close($ch);
            $this->write_log('curl error');
            exit;
        }
        curl_close($ch);
        //print_r($res);
        //die;
        # STEP 3: Inspect IPN validation result and act accordingly

        if (strcmp ($res, "VERIFIED") == 0)
        {
            return true;
            # assign posted variables to local variables
            #$uniqid 			= $_POST['custom'];
            #$item_number 		= $_POST['item_number'];
            #$payment_status 	= $_POST['payment_status'];
            #$payment_amount 	= $_POST['mc_gross'];
            #$payment_currency 	= $_POST['mc_currency'];
            #$txn_id 			= $_POST['txn_id'];
            #$txn_type 			= $_POST['txn_type'];
            #$receiver_email 	= $_POST['receiver_email'];
            #$payer_email 		= $_POST['payer_email'];
            # check whether the payment_status is Completed
            # check that txn_id has not been previously processed
            # check that receiver_email is your Primary PayPal email
            # check that payment_amount/payment_currency are correct


        }
        else if (strcmp ($res, "INVALID") == 0)
        {
            return false;
        }

    }
    public function actionIndex()
    {


        // die;

        //print_r($model);
        if (isset($_POST['full_name'])) {
            /*                     * **TRANSFERRING USER TO PAYPAL TERMINAL*** */
            $this->paypal->add_field('rm', 2);
            $this->paypal->add_field('cmd', '_xclick');
            $this->paypal->add_field('business', 'serviceads.uk@gmail.com');
            $this->paypal->add_field('item_name',$_POST['week']);
            $this->paypal->add_field('amount', $_POST['week']);
            $this->paypal->add_field('currency_code', 'USD');
            $this->paypal->add_field('custom', $payment_id);

            $this->paypal->add_field('notify_url', base_url() . 'home/cus_paypal_ipn');
            $this->paypal->add_field('cancel_return', base_url() . 'home/cus_paypal_cancel');
            $this->paypal->add_field('return', base_url() . 'home/cus_paypal_success');

            // submit the fields to paypal
            $this->paypal->submit_paypal_post();

          // var_dump($this->actionValidateIpn());
            //die;

// For test payments we want to enable the sandbox mode. If you want to put live
// payments through then this setting needs changing to `false`.
            $enableSandbox = false;

// Database settings. Change these for your database configuration.
//            $dbConfig = [
//                'host' => 'localhost',
//                'username' => 'root',
//                'password' => '',
//                'name' => 'paypal_payment'
//            ];

// PayPal settings. Change these to your account details and the relevant URLs
// for your site.
            $paypalConfig = [
                'email' => 'serviceads.uk@gmail.com',
                'return_url' => 'http://example.com/payment-successful.html',
                'cancel_url' => 'http://example.com/payment-cancelled.html',
                'notify_url' => 'http://example.com/payments.php'
            ];
            $paypalUrl='https://www.paypal.com/cgi-bin/webscr';
            //$paypalUrl = 'https://www.paypal.com/webapps/hermes?token=1SE59348P1094653S&useraction=commit&mfid=1604433203303_38970a052d363';

// Product being purchased.
            $itemName = $_POST['product_or_service_link'];
            $itemAmount = $_POST['price'];
// Include Functions
           // require 'functions.php';

// Check if paypal request or response
            if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])) {
                // Grab the post data so that we can set up the query string for PayPal.
                // Ideally we'd use a whitelist here to check nothing is being injected into
                // our post data.
                $data = [];
                foreach ($_POST as $key => $value) {
                    $data[$key] = stripslashes($value);
                }
                // Set the PayPal account.
                $data['business'] = $paypalConfig['email'];
                // Set the PayPal return addresses.
                $data['return'] = stripslashes($paypalConfig['return_url']);
                $data['cancel_return'] = stripslashes($paypalConfig['cancel_url']);
                $data['notify_url'] = stripslashes($paypalConfig['notify_url']);
                // Set the details about the product being purchased, including the amount
                // and currency so that these aren't overridden by the form data.
                $data['full_name'] = $_POST['full_name'];
                $data['email'] = $_POST['email'];
                $data['product_or_service_link'] = $_POST['product_or_service_link'];
                $data['week'] = $_POST['week'];
                $data['price'] = $_POST['price'];
                $data['week'] = $_POST['week'];
                $data['invoice_no'] = $_POST['invoice_no'];
                $data['currency_code'] = 'USD';

                // Add any custom fields for the query string.
                //$data['custom'] = USERID;
                // Build the query string from the data.
                $queryString = http_build_query($data);
                // Redirect to paypal IPN
                header('location:' . $paypalUrl . '?' . $queryString);
                exit();

            } else {
                // Handle the PayPal response.
                // Create a connection to the database.
                // Assign posted variables to local data array.

                // We need to verify the transaction comes from PayPal and check we've not
                // already processed the transaction before adding the payment to our
                // database.
                if ($this->actionVerifyTransaction($_POST)) {
                    $model = new Site;
                    $model->full_name = $_POST['full_name'];
                    $model->email = $_POST['email'];
                    $model->product_or_service_link = $_POST['product_or_service_link'];
                    $model->week = $_POST['week'];
                    $model->price = $_POST['price'];
                    $model->invoice_no = $_POST['invoice_no'];
                    $result = Site::find()
                        ->where(['invoice_no' => $_POST['invoice_no']])->count();
                    if($result==0) {
                        $model->save();
                        unset($_POST);
                        $_POST = array();
                        Yii::$app->session->setFlash('success', 'Data has been saved successfully.');
                    }
                    return $this->render('index');
                }
            }

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
