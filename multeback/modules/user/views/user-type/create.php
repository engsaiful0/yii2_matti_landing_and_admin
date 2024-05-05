<?php
use yii\helpers\Html;
/**
 * @var yii\web\View $this
 * @var common\models\UserType $model
 */
$this->title = Yii::t('app', 'Create User Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Type'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-type-create">
    <div class="box box-default">
        <div class="box-title">
			<h5> <?=$this->title ?></h5>
            <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
			</div>
		</div>
         <div class="box-body">
			<?= $this->render('_form', [
				'model' => $model,
			]) ?>
		</div>
	</div>
</div>