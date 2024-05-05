<?php

/* @var $this \yii\web\View */
/* @var $content string */

use kartik\widgets\ActiveForm;
use multebox\models\Paymentlogo;
use multefront\assets\AppAsset;
use multefront\assets\AppAssetRTL;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use multebox\widgets\Alert;
use multebox\models\Banner;
use multebox\models\Title;
use multebox\models\Logodetails;

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
use kartik\growl\Growl;

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
</head>

<body class="cms-index-index cms-home-page">