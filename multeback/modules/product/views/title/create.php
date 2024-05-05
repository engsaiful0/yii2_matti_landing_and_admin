<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var multebox\models\ProductCategory $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Title',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Title'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-create">
 <!--   <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div> -->
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
