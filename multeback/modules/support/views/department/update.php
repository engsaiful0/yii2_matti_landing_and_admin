<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var multebox\models\Department $model
 */

$this->title = Yii::t('app', 'Update Department');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Departments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="department-update">
     <div class="box box-default">
		 <div class="box-header with-border">
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
			</div>
			<div class="box-title">
				<h5> <?=$this->title ?></h5>
			</div>
		</div>

		<div class="box-body">
			<?= $this->render('_form', [
				'model' => $model,
			]) ?>

		</div>
	</div>
</div>
