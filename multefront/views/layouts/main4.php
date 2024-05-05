
<?php

/* @var $this \yii\web\View */
/* @var $content string */

use kartik\growl\Growl;
use kartik\widgets\ActiveForm;
use multebox\models\Banner;
use multebox\models\Logodetails;
use multebox\models\Title;
use multefront\assets\AppAsset;
use multefront\assets\AppAssetRTL;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use multebox\widgets\Alert;
use multebox\models\ProductBrand;
use multebox\models\ProductCategory;
use multebox\models\ProductSubCategory;
use multebox\models\ProductSubSubCategory;
use multebox\models\Cart;
use multebox\models\Inventory;
use multebox\models\File;
use multebox\models\Social;
use multebox\models\Glocalization;
use multebox\models\CurrencyConversion;
use multebox\models\search\MulteModel;
use yii\helpers\Json;

if(Yii::$app->params['RTL_THEME'] == 'Yes' || $_SESSION['RTL_THEME'] == 'Yes')
    AppAssetRTL::register($this);
else
    AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <!-- Basic page needs -->
    <meta charset="<?= Yii::$app->charset ?>">
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <![endif]-->
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(Yii::$app->params['APPLICATION_NAME']) ?></title>
    <?php $this->head() ?>
    <meta name="description" content="Mult-e-Cart: Multivendor ecommerce system">
    <meta name="keywords" content="bootstrap, ecommerce, fashion, layout, responsive, multecart"/>
    <!-- Mobile specific metas  , -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    if(Yii::$app->controller->route == 'product/default/detail')
    {
        $invent = Inventory::findOne($_GET['inventory_id']);
        $fdet = File::find()->where("entity_type='product' and entity_id='$invent->product_id'")->orderBy("id asc")->all();
        ?>
        <meta property="og:title" content="<?=$invent->product_name?>">
        <meta property="og:image" content="<?=Yii::$app->params['web_url']?>/<?=$fdet[0]->new_file_name?>">
        <meta property="og:image:type" content="image/jpeg/jpg/png">
        <meta property="og:image:width" content="250">
        <meta property="og:image:height" content="250">
        <?php
    }
    ?>
    <!-- Favicon  -->
    <link rel="shortcut icon" type="image/x-icon" href="<?=Yii::$app->params['web_url']?>/logo/front_favicon.ico">

    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700italic,700,400italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Arimo:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Dosis:400,300,200,500,600,700,800' rel='stylesheet' type='text/css'>
    <?php
    $css_color= Yii::$app->params['FRONTEND_THEME_COLOR'];
    ?>
    <?php include_once("script.php"); ?>
    <?php include_once("css.php"); ?>
    <style>
        #myProgress {
            width: 100%;
            /*background-color: re;*/
            margin: 0 auto;
        }

        #myBar {
            width: 0%;
            height: 30px;
            background-color: red;
            text-align: center;
            line-height: 30px;
            color: white;
        }
        @media only screen and (max-width: 700px) {
            .banner_image
            {
                height: 300px!important;
            }

            .left_comment
            {
                padding-top: 15px!important;
            }
            .right_comment
            {
                padding-top: 15px!important;
            }
            .paymentlogo_file
            {
                width:99%;
                margin: 0 auto;
            }
            .ref_chart_row
            {
                width: 100%!important;

            }

        }
    </style>

    <meta charset="UTF-8">

    <link rel="apple-touch-icon" type="image/png" href="https://static.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png" />
    <meta name="apple-mobile-web-app-title" content="CodePen">

    <link rel="shortcut icon" type="image/x-icon" href="https://static.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico" />

    <link rel="mask-icon" type="" href="https://static.codepen.io/assets/favicon/logo-pin-8f3771b1072e3c38bd662872f6b673a722f4b3ca2421637d5596661b4e2132cc.svg" color="#111" />
    <style>
        .audio-progress {
            height: .5rem;
            width: 100%;
            background-color: #C0C0C0;
        }
        .audio-progress .bar {
            height: 100%;
            background-color: #E95F74;
        }

        #audio-progress-handle {
            display: block;
            position:absolute;
            z-index: 1;
            margin-top: -5px;
            margin-left: -10px;
            width: 10px;
            height: 10px;
            border: 4px solid #D3D5DF;
            border-top-color: #D3D5DF;
            border-right-color: #D3D5DF;
            transform: rotate(45deg);
            border-radius: 100%;
            background-color: #fff;
            box-shadow: 0 1px 6px rgba(0, 0, 0, .2);
            cursor:pointer;
        }

        .draggable {
            float: left; margin: 0 10px 10px 0;
        }
    </style>

    <script>
        window.console = window.console || function(t) {};
    </script>



    <script>
        if (document.location.search.match(/type=embed/gi)) {
            window.parent.postMessage("resize", "*");
        }
    </script>


</head>

<div id="page">



    <?php $this->beginBody() ?>

    <?php
    if(Yii::$app->controller->route == 'site/index')
    {
        ?>
        <div class="se-pre-con"></div>
        <?php
    }
    ?>

    <!-- end mobile menu -->
    <div id="page">
        <?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
            <?php
//    echo print_r($message);
//    die;
            if(!empty($message)):
                echo Growl::widget([
                    'type' => Growl::TYPE_WARNING,

                    'icon' => 'glyphicon glyphicon-exclamation-sign',
                    'body' => $message,
                    'showSeparator' => true,
                    'delay' => 1000,
                    'pluginOptions' => [
                        'showProgressbar' => true,
                        'placement' => [
                            'from' => 'top',
                            'align' => 'right',
                        ]
                    ]
                ]);
            endif;
            ?>

        <?php endforeach;
        Yii::$app->session->setFlash('success',null,true);
        ?>

        <!-- Header -->
        <header>
            <div class="header-container">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-8 col-md-8 col-xs-8">
                            <!-- Header Logo -->
                            <div class="logo">
                                <a target="_blank" title="<?=Yii::$app->params['APPLICATION_NAME']?>" href="https://serviceads.co.uk">
                                    <img style="margin-left: 10px;float: left " alt="responsive theme logo" src="<?=Yii::$app->params['web_url']?>/logo/front_logo.png" class="img-logo"></a>
                            </div>
                            <!-- End Header Logo -->
                        </div>

                        <script>
                            function currency_conversion(currency_id){
                                // alert(currency_id);
                                $.ajax({
                                    url: '<?=Url::to(['/site/currencyconversion'])?>',
                                    type: 'post',
                                    data: {
                                        currencyid: currency_id,
                                        // searchby:$("#searchby").val() ,
                                        _csrf : '<?=Yii::$app->request->getCsrfToken()?>'
                                    },
                                    success: function (data) {
                                        // alert(data);
                                        $response=data.split('_');
                                        $("#symbol").val($response[0]);
                                        $("#conversion_value").val($response[1]);
                                    }
                                });
                            }
                        </script>

                        <div class="col-sm-4 col-md-4 col-xs-4" top-cart">
                        <div  class="logo pull-right">

                            <select onchange="currency_conversion(this.value)" name="currency_id" id="currency_id" class="form-control">
                                <?php
                                $currency = \multebox\models\Currency::find()->all();
                                foreach ($currency as $value)
                                {
                                    ?>
                                    <option value="<?php echo $value->currency_symbol.'_'.$value->currency_code?>"><?php echo $value->currency_symbol?> - <?php echo $value->currency_code?></option>
                                    <?php
                                }
                                ?>

                            </select>

                        </div>
                    </div>
                </div>
            </div>
    </div>
    </header>
    <div class="container-fluid" id="banner">
        <div class="row">
            <div class="col-md-12">
                <?php
                $banners =Banner::find()->where("active = 1")->all();
                foreach ($banners as $value)
                {
                    ?>
                    <img class="banner_image" style="width: 100%;height: 450px; " alt="responsive theme logo" src="<?=Yii::$app->params['web_url']?>/banner/<?php echo $value->banner_file?>">
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="container-fluid" id="title">
        <div class="row" style="min-height: 80px;">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?php
                $titless =Title::find()->where("active = 1")->all();
                foreach ($titless as $value)
                {
                    ?>
                    <p style="font-size:25px;font-weight: bold;text-align: center;padding-top: 20px;line-height: normal;  "><?php echo $value->title_name?></p>

                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="container-fluid" id="logo-details">
        <div class="row" id="logo_details" >
            <?php
            $logodetails =Logodetails::find()->where("active = 1")->all();
            foreach ($logodetails as $value)
            {
                ?>
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <p class="left_comment" style="text-align: center;font-size: 18px;padding-top: 88px"><?php echo $value->left_comment ?></p>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <img style="width: 100%;height: 155px; " alt="Details " title="<?php echo $value->logo_title ?>" src="<?=Yii::$app->params['web_url']?>/logodetails_file/<?php echo $value->logodetails_file?>">
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <p class="right_comment" style="text-align: center;font-size: 18px;padding-top: 88px"><?php echo $value->right_comment ?></p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="container-fluid" id="logo-details">
        <div class="row" style="height: 100px ">
            <div class="col-md-4 col-sm-12 col-xs-12"></div>
            <div class="col-md-4 col-sm-12 col-xs-12" style="margin-left: 5px; margin-right: 5px;">
                <?php $form = ActiveForm::begin(['id' => 'contact-form', 'options' => ['method' => 'post', 'action' => 'site/create']]); ?>
                <?php
                $id =\multefront\models\Site::find()->count();
                ?>
                <input type="hidden" name="invoice_no" value="<?php echo 'invoice#'.$id?>">
                <input type="hidden" name="_csrf" value="<?php echo $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>">
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" autocomplete="off" class="form-control" id="full_name" name="full_name" required aria-describedby="full_name" placeholder="Enter Full Name">

                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" autocomplete="off"  required class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter Email">

                </div>
                <div class="form-group">
                    <label for="full_name">Product or Service link?</label>
                    <input type="text" autocomplete="off"  required class="form-control" name="product_or_service_link" id="product_or_service_link" required aria-describedby="product_or_service_link" placeholder="Enter Product or Service Link">

                </div>
                <div class="row" style="height: 100px;width: 100%;margin: 0 auto "
                <div class="form-group" >
                    <label style="" for="ad_duration">Ad Duration</label>
                    <div id="myProgress" >

                        <div id="myBar"></div>
                        <input type="hidden" id="symbol" value="$">
                        <input type="hidden" id="conversion_value" value="1">

                        <input type="hidden" id="oneWeekValue" value="25">
                        <input type="hidden" id="twoWeekValue" value="50">
                        <input type="hidden" id="threeWeekValue" value="75">
                        <input type="hidden" id="fourWeekValue" value="100">

                        <input autocomplete="off" id="oneWeek"   type="radio" name="week" value="1" onclick="move(this.id)">&nbsp;1 Week &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input autocomplete="off" id="twoWeek" type="radio" name="week" value="2" onclick="move(this.id)">&nbsp;2 Weeks&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input autocomplete="off" id="threeWeek" type="radio" name="week" value="3" onclick="move(this.id)">&nbsp;3 Weeks&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input autocomplete="off" id="fourWeek" type="radio" name="week" value="4" onclick="move(this.id)">&nbsp;4 Weeks

                    </div>
                </div>

                <script>
                    var i = 0;
                    function move(id) {
                        var symbol=$('#symbol').val();
                        var conversion_value=$('#conversion_value').val();
                        var value=0;
                        if(id=='oneWeek')
                        {
                            value=$('#oneWeekValue').val();
                        }else if(id=='twoWeek')
                        {
                            value=$('#twoWeekValue').val();
                        }else if(id=='threeWeek')
                        {
                            value=$('#threeWeekValue').val();
                        }else if(id=='fourWeek')
                        {
                            value=$('#fourWeekValue').val();
                        }
                        if (i == 0) {
                            i = 1;
                            var elem = document.getElementById("myBar");
                            var width = 0;
                            var id = setInterval(frame, 15);
                            function frame() {
                                if (width >= value) {
                                    //clearInterval(id);
                                    i = 0;
                                } else {
                                    width++;
                                    elem.style.width = width + "%";
                                    if(width==25)
                                    {
                                        elem.innerHTML = 1  + " week";
                                        document.getElementById("price").value=80*Number(conversion_value);
                                        document.getElementById("price_show").innerHTML=80*Number(conversion_value)+symbol;

                                    }else if(width==50)
                                    {
                                        elem.innerHTML = 2  + " weeks";
                                        document.getElementById("price").value=160*Number(conversion_value);
                                        document.getElementById("price_show").innerHTML=160*Number(conversion_value)+symbol;
                                    }
                                    else if(width==75)
                                    {
                                        elem.innerHTML = 3  + " weeks";
                                        document.getElementById("price").value=240*Number(conversion_value);
                                        document.getElementById("price_show").innerHTML=240*Number(conversion_value)+symbol;
                                    }
                                    else if(width==100)
                                    {
                                        elem.innerHTML = 4  + " weeks";
                                        document.getElementById("price").value=320*Number(conversion_value);
                                        document.getElementById("price_show").innerHTML=320*Number(conversion_value)+symbol;
                                    }
                                    else {
                                        elem.innerHTML = width  + "%";
                                    }

                                }
                            }
                        }
                    }
                </script>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1 col-sm-1 col-xs-1">
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <p id="price_show" style="text-align: center;font-size: large;font-weight: bold;padding-top: 15px;"></p>
                            <input autocomplete="off"  type="hidden" readonly class="form-control" id="price" name="price" required aria-describedby="product_or_service_link" placeholder="price..">

                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <button type="submit" style="background-color: red;color: white " class="btn btn-lg center-block ">PayPal</button>
                        </div>
                    </div>

                </div>


                <?php
                ActiveForm::end();
                ?>

            </div>
            <div class="col-md-4 col-sm-12 col-xs-12"></div>
        </div>
    </div>
</div>
<div id="audio-player-container">
    <div class="audio-progress" id="audio-progress">
        <div id="draggable-point" style="left:75%;position:absolute;" class="draggable ui-widget-content">
            <div id="audio-progress-handle"></div>
        </div>
        <div id="audio-progress-bar" class="bar" style="width:75%">
        </div>
        <p style="text-align:center">1-4 Weeks</p>
        <p id="price" style="text-align:center">fdfd</p>

    </div>
</div>

<div id="posX"></div>
<script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-157cd5b220a5c80d4ff8e0e70ac069bffd87a61252088146915e8726e5d9f147.js"></script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>

<script id="rendered-js" >
    $('#draggable-point').draggable({
        axis: 'x',
        containment: "#audio-progress" });


    $('#draggable-point').draggable({
        drag: function () {
            var offset = $(this).offset();
            var xPos = 100 * parseFloat($(this).css("left")) / parseFloat($(this).parent().css("width")) + "%";
            //$('#price').innerHTML=100;
            document.getElementById("price").innerHTML=xPos;
            //alert(xPos);
            $('#audio-progress-bar').css({
                'width': xPos });

        } });
    //# sourceURL=pen.js
</script>


    <div class="container-fluid" style=" margin-top: 60px">
        <div class="row paymentlogo_file" >
            <div class="col-md-4 col-sm-12 col-xs-12"></div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                <?php
                $paymentlogos =\multebox\models\search\Paymentlogo::find()->where("active = 1")->all();
                foreach ($paymentlogos as $value)
                {
                    ?>
                    <img class="" style="width:100%;" alt="Chart" title="<?php echo $value->paymentlogo_title ?>" src="<?=Yii::$app->params['web_url']?>/paymentlogo_file/<?php echo $value->paymentlogo_file?>">

                    <?php
                }
                ?>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12"></div>
        </div>

    </div>
    <div class="container-fluid" style=" margin-top: 40px"><?php
        $charts =\multebox\models\search\Chart::find()->where("active = 1")->all();
        foreach ($charts as $value)
        {
            ?>
            <div class="row">
                <div class="col-md-3 col-sm-12 col-xs-12"></div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <img class="" style="width: 100%" alt="Chart" title="<?php echo $value->chart_title ?>" src="<?=Yii::$app->params['web_url']?>/chart_file/<?php echo $value->chart_file?>">
                </div>
                <div class="col-md-3 col-sm-12 col-xs-12"></div>
            </div>
            <div class="row ref_chart_row"  style="width: 85%;margin: 0 auto; ">
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <img style="width: 100%; " alt="Chart" title="<?php echo $value->chart_title ?>" src="<?=Yii::$app->params['web_url']?>/chart_file/<?php echo $value->chart_file_ref_image1?>">
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <img style="width: 100%; " alt="Chart" title="<?php echo $value->chart_title ?>" src="<?=Yii::$app->params['web_url']?>/chart_file/<?php echo $value->chart_file_ref_image2?>">
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <img style="width: 100%;" alt="Chart" title="<?php echo $value->chart_title ?>" src="<?=Yii::$app->params['web_url']?>/chart_file/<?php echo $value->chart_file_ref_image3?>">
                </div>
            </div>
            <?php
        }
        ?>



    </div>
    <div class="container-fluid" style=" margin-top: 40px">
        <div class="row" style="width: 80%;margin: 0 auto ">
            <div class="col-xs-12">
                <div class="page-title">
                    <h2 style=" text-align: center"><?=Yii::t('app', 'FAQ')?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3" ></div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="panel-group accordion-faq" id="faq-accordion">
                    <?php
                    $faqs =\multebox\models\Faq::find()->where("active = 1")->all();
                    foreach ($faqs as $value)
                    {
                    ?>
                    <div class="panel">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#faq-accordion" href="#question<?php echo $value->id?>">
                                <span class="arrow-down"><i class="fa fa-angle-down"></i></span></span> <span class="arrow-up"><i class="fa fa-angle-up"></i>
                                        </span>
                                <?php echo $value->faq_title?> </a>
                        </div>
                        <div id="question<?php echo $value->id?>" class="panel-collapse collapse">
                            <div class="panel-body">
                                <?php echo $value->faq_details?>
                            </div>
                        </div>
                        <?php
                        }
                        ?>

                    </div>
                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-3" ></div>
        </div>
    </div>
</div>
</div>
<div style="width: 100% "  >
    <div class="row">
        <div class="MuiGrid-root jss806 MuiGrid-container MuiGrid-justify-xs-center">
            <div class="col-md-12 col-sm-12">
                <div class="MuiGrid-root jss807 MuiGrid-container MuiGrid-align-items-xs-center MuiGrid-align-content-xs-center MuiGrid-justify-xs-center">
                    <div class="MuiGrid-root jss822 MuiGrid-item MuiGrid-grid-xs-11 MuiGrid-grid-sm-11 MuiGrid-grid-md-11 MuiGrid-grid-lg-11 MuiGrid-grid-xl-11">
                        <img width="160" height="22" src="https://servicead.fra1.cdn.digitaloceanspaces.com/homeimages/footer-logo.png" alt="footerLogo" class="LogoFooter">
                    </div>
                </div>
                <div class="MuiGrid-root MuiGrid-container MuiGrid-align-items-xs-center MuiGrid-justify-xs-center" style="width:93%;padding:10px;min-height: 70px">

                    <div class="MuiGrid-root jss814 MuiGrid-item MuiGrid-grid-xs-12 MuiGrid-grid-sm-12 MuiGrid-grid-md-5 MuiGrid-grid-lg-4 MuiGrid-grid-xl-4">
                        <ul class="MuiList-root MuiList-padding" role="menu" tabindex="-1">
                            <li  class="MuiButtonBase-root MuiListItem-root MuiMenuItem-root MuiMenuItem-gutters MuiListItem-gutters MuiListItem-button" tabindex="0" role="menuitem" aria-disabled="false">
                                <a target="_blank" style="color: white!important;font-size: 16px" href="https://serviceads.co.uk/terms&condition">Terms &amp; Condition</a><span class="MuiTouchRipple-root"></span></li>
                            <li style="color: white!important;" class="MuiButtonBase-root MuiListItem-root MuiMenuItem-root MuiMenuItem-gutters MuiListItem-gutters MuiListItem-button" tabindex="-1" role="menuitem" aria-disabled="false">
                                <a target="_blank" style="color: white!important;font-size: 16px" href="https://serviceads.co.uk/AboutUs">About us</a><span class="MuiTouchRipple-root"></span></li>
                            <li style="color: white!important;" class="MuiButtonBase-root MuiListItem-root MuiMenuItem-root MuiMenuItem-gutters MuiListItem-gutters MuiListItem-button" tabindex="-1" role="menuitem" aria-disabled="false">
                                <a target="_blank" style="color: white!important;font-size: 16px" href="https://serviceads.co.uk/contactus">Contact us</a>
                                <span class="MuiTouchRipple-root"></span></li>
                            <li style="color: white!important;" class="MuiButtonBase-root MuiListItem-root MuiMenuItem-root MuiMenuItem-gutters MuiListItem-gutters MuiListItem-button" tabindex="-1" role="menuitem" aria-disabled="false">
                                <a target="_blank" style="color: white!important;font-size: 16px" href="https://serviceads.co.uk/Privacy&Policy">Privacy &amp; Policy</a><span class="MuiTouchRipple-root"></span></li></ul>
                    </div>
                    <div style="float: left" class="MuiGrid-root jss813 MuiGrid-item MuiGrid-grid-xs-12 MuiGrid-grid-sm-12 MuiGrid-grid-md-4 MuiGrid-grid-lg-4 MuiGrid-grid-xl-4">
                        <h5 style="text-align: left!important; " class="MuiTypography-root jss810 MuiTypography-h5">©2019 <a target="_blank" style="color: white!important;font-size: 16px" class="active" aria-current="page" href="https://serviceads.co.uk">ServicesAds</a>. All Rights Reserved.</h5>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<style>
    .jss814 ul {
        border: 0;
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
        flex-direction: row;
        justify-content: center;
    }
    .jss814 ul li:hover {
        background-color: transparent;
    }
    .jss814 ul li a:hover {
        color: #d0c782 !important;
        text-decoration: none;
    }
    .jss814 ul li {
        color: #fff;
        padding: 0 .7rem;
        overflow: visible;
        position: relative;
        font-size: 105%;
        min-height: auto;
        font-family: Lato;
        font-weight: 500;
        letter-spacing: 1.5px;
        background-color: transparent;
    }
    .jss814 ul li {
        color: #fff;
        padding: 0 .7rem;
        overflow: visible;
        position: relative;
        font-size: 105%;
        min-height: auto;
        font-family: Lato;
        font-weight: 500;
        letter-spacing: 1.5px;
        background-color: transparent;
    }
    @media (min-width: 1280px)

        .MuiGrid-grid-lg-11 {
            flex-grow: 0;
            max-width: 91.666667%;
            flex-basis: 91.666667%;
        }
        .jss822 {
            display: flex;
            padding: 26px 10px;
            align-items: center;
            border-bottom: 1px solid #FFF8;
            justify-content: center;
        }
        .MuiLis
        .MuiListItem-button {
            color: #262626 !important;
            border: 0px solid #FFF;
            transition: background-color 150ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
            background-color: #FFF;
        }
        @media (min-width: 600px)
            .MuiMenuItem-root {
                min-height: auto;
            }
            .MuiMenuItem-root {
                width: auto;
                overflow: hidden;
                font-size: 1rem;
                box-sizing: border-box;
                min-height: 48px;
                font-family: Lato;
                font-weight: 400;
                line-height: 1.5;
                padding-top: 6px;
                white-space: nowrap;
                padding-bottom: 6px;
            }
            .jss814 ul li {
                color: #fff;
                padding: 0 .7rem;
                overflow: visible;
                position: relative;
                font-size: 105%;
                min-height: auto;
                font-family: Lato;
                font-weight: 500;
                letter-spacing: 1.5px;
                background-color: transparent;
            }
            .MuiList-padding {
                border-left: 2px solid #E6E6E6;
                padding-top: 0px;
                border-right: 2px solid #E6E6E6;
                padding-bottom: 0px;
            }
            .MuiList-root {
                margin: 0;
                padding: 0;
                position: relative;
                list-style: none;
            }
            .jss814 ul {
                border: 0;
                display: flex;
                flex-wrap: wrap;
                list-style: none;
                padding-left: 0;
                margin-bottom: 0;
                flex-direction: row;
                justify-content: center;
            }
            .MuiTypography-root {
                margin: 0;
                display: block;
                flex-wrap: wrap;
                word-break: break-word;
            }
            .jss810 {
                color: #fff;
                opacity: 0.8;
                font-size: 17px;
                word-break: break-word;
                font-family: Lato;
                font-weight: 400;
                margin-bottom: 0;
                letter-spacing: 1px;
            }
            @media (min-width: 1280px)
                .MuiGrid-grid-lg-4 {
                    flex-grow: 0;
                    max-width: 33.333333%;
                    flex-basis: 33.333333%;
                }
                .jss813 {
                    margin: 10px 0px;
                    display: flex;
                    justify-content: flex-start;
                }
                .jss806 {
                    background-color: #E73A34;
                }
                .MuiGrid-justify-xs-center {
                    justify-content: center;
                }
                .MuiGrid-container {
                    width: 100%;
                    display: flex;
                    flex-wrap: wrap;
                    box-sizing: border-box;
                }
                .jss807 {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                .MuiGrid-item {
                    margin: 0;
                    box-sizing: border-box;
                }
                .MuiGrid-justify-xs-center {
                    justify-content: center;
                }
                .MuiGrid-align-items-xs-center {
                    align-items: center;
                }
                .jss822 {
                    display: flex;
                    padding: 26px 10px;
                    align-items: center;
                    border-bottom: 1px solid #FFF8;
                    justify-content: center;
                }
                @media (min-width: 1280px)
                    .MuiGrid-grid-lg-11 {
                        flex-grow: 0;
                        max-width: 91.666667%;
                        flex-basis: 91.666667%;
                    }
</style>
<a href="#" class="totop"> </a>
<!-- End Footer -->
<!--Newsletter Popup Start-->

<!--End of Newsletter Popup-->
</div>


<!-- JS -->
<?php $this->endBody() ?>

<script type="text/javascript">
    /* <![CDATA[ */
    var mega_menu = '0';

    /* ]]> */
</script>

<!-- Revolution Slider -->
<script type="text/javascript">
    jQuery(document).ready(function() {

        if ($('.mainindex').length == 0) {
            jQuery('.mega-menu-category').slideUp();
        }

        <?php
        if(!isset($_SESSION['newspopup']))
        {
        ?>


        <?php
        }
        ?>

    });
</script>
<div class="modal fade wishconfirmmodal" >
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <h4><p class="text-center"><?=Yii::t('app', 'Added!')?>! <i class="glyphicon glyphicon-ok text-success"></i></p></h4>
            </div>
        </div>
    </div>
</div>
<div class="modal fade compareconfirmmodal" >
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <h4><p class="text-center"><?=Yii::t('app', 'Added!')?>! <i class="glyphicon glyphicon-ok text-success"></i></p></h4>
            </div>
        </div>
    </div>
</div>
<div class="modal fade wishexistmodal" >
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <h4><p class="text-center"><?=Yii::t('app', 'Already Exists!')?>! <i class="glyphicon glyphicon-exclamation-sign text-warning"></i></p></h4>
            </div>
        </div>
    </div>
</div>
<div class="modal fade compareexistmodal" >
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <h4><p class="text-center"><?=Yii::t('app', 'Already Exists!')?>! <i class="glyphicon glyphicon-exclamation-sign text-warning"></i></p></h4>
            </div>
        </div>
    </div>
</div>
<div class="modal fade comparemaxmodal" >
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <h4><p class="text-center"><?=Yii::t('app', 'Maximum Items Already Added!')?>! <i class="glyphicon glyphicon-exclamation-sign text-warning"></i></p></h4>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php $this->endPage() ?>

<script>
    function Add_Error(obj,msg){
        $(obj).parents('.form-group').addClass('has-error');
        $(obj).parents('.form-group').append('<div style="color:#D16E6C; clear:both" class="error"><i class="icon-remove-sign"></i> '+msg+'</div>');
        return true;
    }

    function Remove_Error(obj){
        $(obj).parents('.form-group').removeClass('has-error');
        $(obj).parents('.form-group').children('.error').remove();
        return false;
    }

    function Add_ErrorTag(obj,msg){
        obj.css({'border':'1px solid #D16E6C'});

        obj.after('<div style="color:#D16E6C; clear:both" class="error"><i class="icon-remove-sign"></i> '+msg+'</div>');
        return true;
    }

    function Remove_ErrorTag(obj){
        obj.removeAttr('style').next('.error').remove();
        return false;
    }

    //$(document).ready(function () {
    //$(".add_to_wishlist").click(function() {
    $(document).on('click', '.add_to_wishlist', function() {
        $.post("<?=Url::to(['/site/add-to-wishlist'])?>", { 'id': $('input', this).val(), '_csrf' : '<?=Yii::$app->request->csrfToken?>'}) .done(function(result){
            if(result == -1)
            {
                window.location.href = '<?=Url::to(['/site/login'])?>';
            }
            else if(result == -2)
            {
                $('.wishexistmodal').modal('show');
                setTimeout(function() {$('.wishexistmodal').modal('hide');}, 1500);
            }
            else
            {
                $('.mywishlistcount').html(result);
                $('.wishconfirmmodal').modal('show');
                setTimeout(function() {$('.wishconfirmmodal').modal('hide');}, 1500);
            }
        })
    });

    //$(".add_to_compare").click(function() {
    $(document).on('click', '.add_to_compare', function() {
        $.post("<?=Url::to(['/site/add-to-comparelist'])?>", { 'id': $('input', this).val(), '_csrf' : '<?=Yii::$app->request->csrfToken?>'}) .done(function(result){
            if(result == -1)
            {
                $('.compareexistmodal').modal('show');
                setTimeout(function() {$('.compareexistmodal').modal('hide');}, 1500);
            }
            else if(result == -2)
            {
                $('.comparemaxmodal').modal('show');
                setTimeout(function() {$('.comparemaxmodal').modal('hide');}, 1500);
            }
            else
            {
                $('.mycomparelistcount').html(result);
                $('.compareconfirmmodal').modal('show');
                setTimeout(function() {$('.compareconfirmmodal').modal('hide');}, 1500);
            }
        })
    });

    /*$( ".basket" ).click(function() {
          setTimeout(function() {$( ".top-cart-content" ).trigger("click");}, 1);
        });*/

    $('.dropdown-toggle').dropdown();

    $('.multe-rating').rating({
        'showClear': false,
        'showCaption': true,
        'stars': '5',
        'min': '0',
        'max': '5',
        'step': '1',
        'size': 'xs',
        'starCaptions': {0: "<?=Yii::t('app', 'Not Rated')?>", 1: "<?=Yii::t('app', 'Poor')?>", 2: "<?=Yii::t('app', 'Fair')?>", 3: "<?=Yii::t('app', 'Good')?>", 4: "<?=Yii::t('app', 'Very Good')?>", 5: "<?=Yii::t('app', 'Excellent')?>"}
    });

    $('.multe-rating-nocap').rating({
        'showClear': false,
        'showCaption': false,
        'stars': '5',
        'min': '0',
        'max': '5',
        'step': '1',
        'size': 'xs'
    });

    $('.multe-rating-sm').rating({
        'showClear': false,
        'showCaption': true,
        'stars': '5',
        'min': '0',
        'max': '5',
        'step': '1',
        'size': 'xxs',
        'starCaptions': {0: "<?=Yii::t('app', 'Not Rated')?>", 1: "<?=Yii::t('app', 'Poor')?>", 2: "<?=Yii::t('app', 'Fair')?>", 3: "<?=Yii::t('app', 'Good')?>", 4: "<?=Yii::t('app', 'Very Good')?>", 5: "<?=Yii::t('app', 'Excellent')?>"}
    });

    $('.multe-rating-nocap-sm').rating({
        'showClear': false,
        'showCaption': false,
        'stars': '5',
        'min': '0',
        'max': '5',
        'step': '1',
        'size': 'xxs'
    });

    //});

    $(window).load(function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");;
    });

    $(".mainlazy").lazyload({
        event : "turnPage",
        effect : "fadeIn"
    });

</script>