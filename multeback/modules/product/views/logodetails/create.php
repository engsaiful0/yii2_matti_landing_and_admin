<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var multebox\models\ProductBrand $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Details',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Logo Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-brand-create">
    <!--<div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>-->
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
