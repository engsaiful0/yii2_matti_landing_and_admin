<?php

use multebox\models\search\ProductCategory;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\web\View;
use yii\widgets\Pjax;
use multebox\models\Paidads;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var multebox\models\search\ProductCategory $searchModel
 */

$this->title = Yii::t('app', 'Paid Ads');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="product-category-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Product Category',
]), ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'pjax' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'full_name',
            'email',
            'price',
            'product_or_service_link',

            //  'sort_order',
//            'added_at',
//            'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{action} {delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['/product/faq/view', 'id' => $model->id, 'edit' => 't']),
                            ['title' => Yii::t('app', 'Edit'),]
                        );
                    },


                ],
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => false,

    ]); Pjax::end(); ?>

</div>
