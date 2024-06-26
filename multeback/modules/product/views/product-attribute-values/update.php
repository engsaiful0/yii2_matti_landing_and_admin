<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var multebox\models\ProductAttributeValues $model
 */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Product Attribute Values',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Attribute Values'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
include_once('script.php');
?>
<div class="product-attribute-values-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
		'ProductAttributeValues' => $ProductAttributeValues,
    ]) ?>

</div>
