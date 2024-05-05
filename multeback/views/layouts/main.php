<?php

/* @var $this \yii\web\View */
/* @var $content string */
use multebox\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use multeback\assets\AppAsset;
use multebox\models\search\MulteModel;

//AppAsset::register($this);

function activeParentMenu($array)
{
	return in_array(Yii::$app->controller->route,$array)?'active':'';	
}

function activeMenu($link)
{
	return Yii::$app->controller->route==$link?'active':'';	
}

function activeEstimateMenu($entity_type)
{
	return ($_REQUEST['entity_type'] == $entity_type ) ? 'active' : '';
}

function activeSubMenu($action, $entity_type)
{
	$path = parse_url( $_SERVER['REQUEST_URI']);
	$route = Yii::$app->controller->route;
	$route = explode( "/", trim( $route, "/" ) );
	return ( $action == $route[2] && $_REQUEST['entity_type'] == $entity_type ) ? 'active' : '';
}

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="<?=Yii::$app->params['web_url']?>/logo/back_favicon.ico" rel="icon" />
	<!-- jQuery 3 -->
<script src="<?=Url::base()?>/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=Url::base()?>/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Fix Bootstrap Dropdown problem -->
<script>
    $(document).ready(function () {
        $('.dropdown-toggle').dropdown();
    });
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=Url::base()?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=Url::base()?>/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->

	<link rel="stylesheet" href="<?=Url::base()?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=Url::base()?>/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=Url::base()?>/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <?php
  if(Yii::$app->params['RTL_THEME'] == 'No')
  {
  ?>
  <link rel="stylesheet" href="<?=Url::base()?>/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?=Url::base()?>/dist/css/skins/_all-skins.min.css">
  <?php
  }
  else
  {
  ?>
  <link rel="stylesheet" href="<?=Url::base()?>/dist/css/AdminLTE-rtl.min.css">
  <link rel="stylesheet" href="<?=Url::base()?>/dist/css/skins/_all-skins-rtl.min.css">
  <?php
  }
  ?>
 
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

	<?php include_once("script.php"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">

<?php $this->beginBody() ?>

<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b><?=Yii::$app->params['APPLICATION_SHORT_NAME']?></b></span>
      <!-- logo for regular state and mobile devices -->
      <!--<span class="logo-lg"><b>Mult</b>-e-Cart</span>-->
	  <span class="logo-lg"><b><?=Yii::$app->params['APPLICATION_NAME']?></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only"><?=Yii::t('app', 'Toggle navigation')?></span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?=Yii::$app->params['web_url']?>/users/<?=Yii::$app->user->identity->id?>.png" class="user-image" alt="">
              <span class="hidden-xs"><?=Yii::$app->user->identity->first_name?> <?=Yii::$app->user->identity->last_name?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?=Yii::$app->params['web_url']?>/users/<?=Yii::$app->user->identity->id?>.png" class="img-circle" alt="">
                <p>
                  <?=Yii::$app->user->identity->first_name?> <?=Yii::$app->user->identity->last_name?>
                  <small>(<?=Yii::$app->user->identity->username?>)</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="text-center">
					  <?php
					    $url1 = Url::to(['/user/user/change-password']);
					  ?>
                    <a href="<?=$url1?>"><i class="fa fa-exchange"></i> <small><?=Yii::t('app', 'Change Password')?></small></a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
					<?php
					    $url1 = Url::to(['/user/user/view', 'id' => Yii::$app->user->getId()]);
					?>
				  <a href="<?=$url1?>" class="btn btn-default btn-flat"><i class="fa fa-user"></i> <?=Yii::t('app', 'Profile')?></a>
                </div>
                <div class="pull-right">
				  <a href="<?= Url::to(['/site/logout'])?>" data-method="post" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> <?=Yii::t('app', 'Sign out')?></a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->

        </ul>
      </div>
    </nav>
  </header>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?=Yii::$app->params['web_url']?>/logo/back_logo.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>
            <?=Yii::$app->user->identity->first_name?> <?=Yii::$app->user->identity->last_name?>
          </p>
          <a href="#"><i class="fa fa-circle text-success"></i> <?=Yii::t('app', 'Online')?></a>
        </div>
      </div>
      <!-- search form -->

      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
		<li class="active">
          <a href="<?=Url::to(['/site/index'])?>">
            <i class="fa fa-dashboard text-yellow"></i> <span><?=Yii::t('app', 'Dashboard')?></span>
          </a>
        </li>
          <li class="treeview ">
              <a href="#">
                  <i class="fa fa-hdd-o text-white"></i> <span><?=Yii::t('app', 'Banner')?></span>
                  <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
              </a>
              <ul class="treeview-menu">
                  <li class="<?=activeMenu('product/product-brand/create')?>"><a href="<?=Url::to(['/product/banner/create'])?>"><i class="fa fa-circle-o text-orange"></i><?=Yii::t('app', 'Add Banner')?></a></li>
                  <li class="<?=activeMenu('product/product-brand/index')?>"><a href="<?=Url::to(['/product/banner/index'])?>"><i class="fa fa-circle-o text-orange"></i><?=Yii::t('app', 'Manage Banner')?></a></li>
              </ul>
          </li>
          <li class="treeview ">
              <a href="#">
                  <i class="fa fa-hdd-o text-white"></i> <span><?=Yii::t('app', 'Title')?></span>
                  <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
              </a>
              <ul class="treeview-menu">
                  <li class="<?=activeMenu('product/title/create')?>"><a href="<?=Url::to(['/product/title/create'])?>"><i class="fa fa-circle-o text-orange"></i><?=Yii::t('app', 'Add Title')?></a></li>
                  <li class="<?=activeMenu('product/title/index')?>"><a href="<?=Url::to(['/product/title/index'])?>"><i class="fa fa-circle-o text-orange"></i><?=Yii::t('app', 'Manage Title')?></a></li>
              </ul>
          </li>
          <li class="treeview ">
              <a href="#">
                  <i class="fa fa-hdd-o text-white"></i> <span><?=Yii::t('app', 'Details')?></span>
                  <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
              </a>
              <ul class="treeview-menu">
                  <li class="<?=activeMenu('product/logodetails/create')?>"><a href="<?=Url::to(['/product/logodetails/create'])?>"><i class="fa fa-circle-o text-orange"></i><?=Yii::t('app', 'Add Details')?></a></li>
                  <li class="<?=activeMenu('product/logodetails/index')?>"><a href="<?=Url::to(['/product/logodetails/index'])?>"><i class="fa fa-circle-o text-orange"></i><?=Yii::t('app', 'Manage Details')?></a></li>
              </ul>
          </li>
<!--          <li>-->
<!--              <a href="--><?//=Url::to(['/user/paidads'])?><!--">-->
<!--                  <i class="fa fa-money text-yellow"></i> <span>--><?//=Yii::t('app', 'Paid Ads')?><!--</span>-->
<!--              </a>-->
<!--          </li>-->
          <li class="treeview ">
              <a href="#">
                  <i class="fa fa-hdd-o text-white"></i> <span><?=Yii::t('app', 'Payment Logo')?></span>
                  <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
              </a>
              <ul class="treeview-menu">
                  <li class="<?=activeMenu('product/paymentlogo/create')?>"><a href="<?=Url::to(['/product/paymentlogo/create'])?>"><i class="fa fa-circle-o text-orange"></i><?=Yii::t('app', 'Add Payment Logo')?></a></li>
                  <li class="<?=activeMenu('product/paymentlogo/index')?>"><a href="<?=Url::to(['/product/paymentlogo/index'])?>"><i class="fa fa-circle-o text-orange"></i><?=Yii::t('app', 'Manage Payment Logo')?></a></li>
              </ul>
          </li>
          <li class="treeview ">
              <a href="#">
                  <i class="fa fa-hdd-o text-white"></i> <span><?=Yii::t('app', 'Reference')?></span>
                  <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
              </a>
              <ul class="treeview-menu">
                  <li class="<?=activeMenu('product/chart/create')?>"><a href="<?=Url::to(['/product/chart/create'])?>"><i class="fa fa-circle-o text-orange"></i><?=Yii::t('app', 'Add Reference')?></a></li>
                  <li class="<?=activeMenu('product/chart/index')?>"><a href="<?=Url::to(['/product/chart/index'])?>"><i class="fa fa-circle-o text-orange"></i><?=Yii::t('app', 'Manage Reference')?></a></li>
              </ul>
          </li>
          <li class="treeview ">
              <a href="#">
                  <i class="fa fa-hdd-o text-white"></i> <span><?=Yii::t('app', 'FAQ')?></span>
                  <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
              </a>
              <ul class="treeview-menu">
                  <li class="<?=activeMenu('product/faq/create')?>"><a href="<?=Url::to(['/product/faq/create'])?>"><i class="fa fa-circle-o text-orange"></i><?=Yii::t('app', 'Add FAQ')?></a></li>
                  <li class="<?=activeMenu('product/faq/index')?>"><a href="<?=Url::to(['/product/faq/index'])?>"><i class="fa fa-circle-o text-orange"></i><?=Yii::t('app', 'Manage FAQ')?></a></li>
              </ul>
          </li>
          <li class="treeview ">
              <a href="#">
                  <i class="fa fa-money text-white"></i> <span><?=Yii::t('app', 'Currency Conversion')?></span>
                  <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
              </a>
              <ul class="treeview-menu">
                  <li class="<?=activeMenu('product/faq/create')?>"><a href="<?=Url::to(['/finance/currency-conversion/create'])?>"><i class="fa fa-circle-o text-orange"></i><?=Yii::t('app', 'Add Currency Conversion')?></a></li>
                  <li class="<?=activeMenu('product/faq/index')?>"><a href="<?=Url::to(['/finance/currency-conversion/index'])?>"><i class="fa fa-circle-o text-orange"></i><?=Yii::t('app', 'Manage Currency Conversion')?></a></li>
              </ul>
          </li>
         <li>
             <a href="<?=Url::to(['/multeobjects/setting'])?>">
                <i class="fa fa-dashboard text-yellow"></i> <span><?=Yii::t('app', 'System settings')?></span>
              </a>
          </li>
          <li>
             <a href="<?=Url::to(['/user/user'])?>">
                 <i class="fa fa-users text-yellow"></i> <span><?=Yii::t('app', 'Users')?></span>
             </a>
            </li>
		<!-- End Support/Ticket Menu -->

	      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

    <div class="content-wrapper">
			<?= Alert::widget() ?>
			     <section class="content-header">
					<h4><?= Html::encode($this->title) ?></h4>
				  <ol class="breadcrumb">
					<?php  echo Breadcrumbs::widget ( [ 'links' => isset ( $this->params ['breadcrumbs'] ) ? $this->params ['breadcrumbs'] : [ ],
															'homeLink' => [
																			'label' => Yii::t('app', 'Home'),
																			'url' => Yii::$app->homeurl,
																			]
														]) ?>
				  </ol>
				</section>

		<!-- Main content -->
		<section class="content">
			<?= $content ?>
		</section>
    </div>

<footer class="main-footer">
    <div class="container">
        <p class="pull-left">&copy; <a href="http://www.serviceads.co.uk">Service Ads</a> <?= date('Y') ?></p>
        <p class="pull-right">Powerd by Service Ads</p>
    </div>
</footer>

<?php
if(Yii::$app->user->can('GlobalSettings.Index'))
{
?>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
<!--    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">-->
<!--      <li class="active" title="--><?//=Yii::t('app', 'System Settings')?><!--"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-gear"></i></a></li>-->
<!--	  <li title="--><?//=Yii::t('app', 'Support Settings')?><!--"><a href="#control-sidebar-support-tab" data-toggle="tab"><i class="fa fa-support"></i></a></li>-->
<!--	  <li title="--><?//=Yii::t('app', 'Other Settings')?><!--"><a href="#control-sidebar-other-tab" data-toggle="tab"><i class="fa fa-diamond"></i></a></li>-->
<!--    </ul>-->
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading"><?=Yii::t('app', 'System Settings')?></h3>
        <ul class="control-sidebar-menu">
		<?php
		if(Yii::$app->user->can('Settings.Index'))
		{
		?>
          <li>
            <a href="<?=Url::to(['/multeobjects/setting'])?>">
              <i class="menu-icon fa fa-plus-circle bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'Advanced System Settings')?></h4>

                <p><?=Yii::t('app', 'Advanced system settings')?></p>
              </div>
            </a>
          </li>

		  <li>
            <a href="<?=Url::to(['/product/banner-data'])?>">
              <i class="menu-icon fa fa-flag bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'Banner Settings')?></h4>

                <p><?=Yii::t('app', 'Add/Edit Frontend Banners')?></p>
              </div>
            </a>
          </li>

		  <li>
            <a href="<?=Url::to(['/user/testimonial'])?>">
              <i class="menu-icon fa fa-edit bg-purple"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'Testimonials')?></h4>

                <p><?=Yii::t('app', 'Add/Edit User Testimonials')?></p>
              </div>
            </a>
          </li>

		   <li>
            <a href="<?=Url::to(['/multeobjects/social'])?>">
              <i class="menu-icon fa fa-connectdevelop bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'Social Links')?></h4>

                <p><?=Yii::t('app', 'View/Update various social media links')?></p>
              </div>
            </a>
          </li>

		  <li>
            <a href="<?=Url::to(['/multeobjects/static-pages'])?>">
              <i class="menu-icon fa fa-paint-brush bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'Static Pages')?></h4>

                <p><?=Yii::t('app', 'View/Update various footer static pages')?></p>
              </div>
            </a>
          </li>
		<?php
		}
		
		if(Yii::$app->user->can('RBAC.Index'))
		{
		?>
		  <li>
            <a href="<?=Url::to(['/multeobjects/setting/rights'])?>">
              <i class="menu-icon fa fa-magic bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'RBAC Settings')?></h4>

                <p><?=Yii::t('app', 'Define role based access control for system')?></p>
              </div>
            </a>
          </li>
		<?php
		}

		if(Yii::$app->user->can('UserSessions.Index'))
		{
		?>
		  <li>
            <a href="<?=Url::to(['/user/user/user-sessions'])?>">
              <i class="menu-icon fa fa-history bg-purple"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'Session History')?></h4>

                <p><?=Yii::t('app', 'Browse session history of different users')?></p>
              </div>
            </a>
          </li>
		<?php
		}
		?>

		<?php
		if(Yii::$app->user->can('EmailTemplates.Index'))
		{
		?>
		  <li>
            <a href="<?=Url::to(['/multeobjects/email-template'])?>">
              <i class="menu-icon fa fa-envelope bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'Email Templates')?></h4>

                <p><?=Yii::t('app', 'Add/Update various email templates')?></p>
              </div>
            </a>
          </li>
          
		<?php
		}
		?>

		<?php
		if(Yii::$app->user->can('Users.Index'))
		{
		?>
		  <li>
            <a href="<?=Url::to(['/user/user'])?>">
              <i class="menu-icon fa fa-group bg-purple"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'Users')?></h4>

                <p><?=Yii::t('app', 'Add/Update various system users')?></p>
              </div>
            </a>
          </li>
		<?php
		}
		?>

		  <li>
            <a href="<?=Url::to(['/multeobjects/setting/license'])?>">
              <i class="menu-icon fa fa-copyright bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'License')?></h4>

                <p><?=Yii::t('app', 'View License')?></p>
              </div>
            </a>
          </li>

        </ul>
        <!-- /.control-sidebar-menu -->
      </div>
      <!-- /.tab-pane -->
	  
	  <!-- Support Settings -->
	  <div class="tab-pane" id="control-sidebar-support-tab">
        <h3 class="control-sidebar-heading"><?=Yii::t('app', 'Support Settings')?></h3>
        <ul class="control-sidebar-menu">
		<?php
		if(Yii::$app->user->can('TicketStatus.Index'))
		{
		?>
		  <li>
            <a href="<?=Url::to(['/support/ticket-status/index'])?>">
              <i class="menu-icon fa fa-ticket bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'Ticket Status')?></h4>

                <p><?=Yii::t('app', 'Change Label Of Various Ticket Status')?></p>
              </div>
            </a>
          </li>
		<?php
		}

		if(Yii::$app->user->can('TicketImpact.Index'))
		{
		?>
		  <li>
            <a href="<?=Url::to(['/support/ticket-impact/index'])?>">
              <i class="menu-icon fa fa-ticket bg-orange"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'Ticket Impact')?></h4>

                <p><?=Yii::t('app', 'Add/Update Ticket Impact')?></p>
              </div>
            </a>
          </li>
		<?php
		}

		if(Yii::$app->user->can('TicketPriority.Index'))
		{
		?>
		  <li>
            <a href="<?=Url::to(['/support/ticket-priority/index'])?>">
              <i class="menu-icon fa fa-ticket bg-purple"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'Ticket Priority')?></h4>

                <p><?=Yii::t('app', 'Add/Update Ticket Priority')?></p>
              </div>
            </a>
          </li>
		<?php
		}

		if(Yii::$app->user->can('TicketSla.Index'))
		{
		?>
		  <li>
            <a href="<?=Url::to(['/support/ticket-sla/index'])?>">
              <i class="menu-icon fa fa-ticket bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'Ticket SLA')?></h4>

                <p><?=Yii::t('app', 'Define Ticket SLA')?></p>
              </div>
            </a>
          </li>
		<?php
		}

		if(Yii::$app->user->can('Department.Index'))
		{
		?>
		  <li>
            <a href="<?=Url::to(['/support/department/index'])?>">
              <i class="menu-icon fa fa-ticket bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'Departments')?></h4>

                <p><?=Yii::t('app', 'Add/Update Various Support Departments')?></p>
              </div>
            </a>
          </li>
		<?php
		}

		if(Yii::$app->user->can('TicketCategory.Index'))
		{
		?>
		  <li>
            <a href="<?=Url::to(['/support/ticket-category/index'])?>">
              <i class="menu-icon fa fa-ticket bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'Ticket Category')?></h4>

                <p><?=Yii::t('app', 'Add/Update Ticket Categories')?></p>
              </div>
            </a>
          </li>
		<?php
		}

		if(Yii::$app->user->can('Queue.Index'))
		{
		?>
		  <li>
            <a href="<?=Url::to(['/support/queue/index'])?>">
              <i class="menu-icon fa fa-ticket bg-orange"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'Queues')?></h4>

                <p><?=Yii::t('app', 'Add/Update Various Support Queues')?></p>
              </div>
            </a>
          </li>

		<?php
		}
		?>
        </ul>
      </div>

	  <!-- Other Settings tab content -->
      <div class="tab-pane" id="control-sidebar-other-tab">
        <h3 class="control-sidebar-heading"><?=Yii::t('app', 'Other Settings')?></h3>
        <ul class="control-sidebar-menu">
		<?php
		if(Yii::$app->user->can('CustomerType.Index'))
		{
		?>
		  <li>
            <a href="<?=Url::to(['/customer/customer-type'])?>">
              <i class="menu-icon fa fa-group bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'Customer Type')?></h4>

                <p><?=Yii::t('app', 'Add/Update various customer types')?></p>
              </div>
            </a>
          </li>
		<?php
		}

		if(Yii::$app->user->can('VendorType.Index'))
		{
		?>
		  <li>
            <a href="<?=Url::to(['/vendor/vendor-type'])?>">
              <i class="menu-icon fa fa-cubes bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'Vendor Type')?></h4>

                <p><?=Yii::t('app', 'Add/Update various vendor types')?></p>
              </div>
            </a>
          </li>
		<?php
		}

		if(Yii::$app->user->can('Tax.Index'))
		{
		?>
		  <li>
            <a href="<?=Url::to(['/finance/tax'])?>">
              <i class="menu-icon fa fa-dollar bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'Tax')?></h4>

                <p><?=Yii::t('app', 'Define various tax parameters')?></p>
              </div>
            </a>
          </li>
		<?php
		}
		if(Yii::$app->user->can('PaymentMethods.Index'))
		{
		?>
		  <li>
            <a href="<?=Url::to(['/finance/payment-methods'])?>">
              <i class="menu-icon fa fa-money bg-purple"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'Payment Methods')?></h4>

                <p><?=Yii::t('app', 'Enable/Disable Various Payment Methods')?></p>
              </div>
            </a>
          </li>

		  <li>
            <a href="<?=Url::to(['/finance/currency-conversion'])?>">
              <i class="menu-icon fa fa-exchange bg-orange"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?=Yii::t('app', 'Currency Conversion')?></h4>

                <p><?=Yii::t('app', 'Define Currency Conversion Rate')?></p>
              </div>
            </a>
          </li>
		<?php
		}
		?>
		</ul>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
<?php
}
?>
</div>
<?php $this->endBody() ?>

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

  $(document).ready(function(e) {
	$('#w0').submit(function(event){
	var error='';

	$('[data-validation="required"]').each(function(index, element) 
	{
		Remove_Error($(this));
		
		var e=$(this).val();

		if($(this).val() == '' && !$(this).is("[mandatory-field]"))
		{
			Remove_Error($(this));
		}
		else if($(this).val() == '' && $(this).is("[mandatory-field]"))
		{
			error+=Add_Error($(this),"<?=Yii::t('app','This Field is Required!')?>");
		}
		else if($(this).is("[email-validation]"))
		{
			var atpos=e.indexOf("@");
			var dotpos=e.lastIndexOf(".");

			if (atpos<1 || dotpos<atpos+2 || dotpos+2>=e.length)
			{
				error+=Add_Error($(this),"<?=Yii::t('app','Email Address Not Valid!')?>");
			}
			else
			{
				Remove_Error($(this));
			}	
		}
		else if($(this).is("[num-validation]"))
		{
			if (!e.match(/^\d+$/))
			{
				error+=Add_Error($(this),"<?=Yii::t('app','Please enter a valid number!')?>");
			}
			else
			{
				Remove_Error($(this));
			}	
		}
		else if($(this).is("[num-validation-float]"))
		{
			//if (!e.match(/^\d+$/))
			//if (!e.match(/^[-+]?[0-9]*\.?[0-9]+$/))
			if (!e.match(/^[]?[0-9]*\.?[0-9]+$/))
			{
				error+=Add_Error($(this),"<?=Yii::t('app','Please enter a valid number!')?>");
			}
			else
			{
				Remove_Error($(this));
			}	
		}
		else if($(this).val() == '')
		{
			error+=Add_Error($(this),"<?=Yii::t ('app','This Field is Required!')?>");
		}
		else
		{
			Remove_Error($(this));
		}	

		if(error !='')
		{
			event.preventDefault();
		}
		else
		{
			return true;
		}
		});
	});
	$('a[data-toggle="tab"]').bind('click', function () {
		//alert("a");
        localStorage.setItem('lastTab_leadview', $(this).attr('href'));
    });
    //go to the latest tab, if it exists:
    var lastTab_leadview = localStorage.getItem('lastTab_leadview');

    if ($('a[href="' + lastTab_leadview + '"]').length > 0) {
        $('a[href="' + lastTab_leadview + '"]').tab('show');
    }
    else
    {
        // Set the first tab if cookie do not exist
        $('a[data-toggle="tab"]:first').tab('show');
    }
});
</script>
</body>
</html>

<?php
  $this->endPage();
?>