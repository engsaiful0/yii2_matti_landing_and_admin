<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var multebox\models\search\StaticPages $searchModel
 */

$this->title = Yii::t('app', 'Static Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="static-pages-index">
    <!--<div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
    </div>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Static Pages',
]), ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'responsiveWrap' => false,
'pjax' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

		   [ 
					'attribute' => 'page_name',
					'format' => 'raw',
					'value' => function ($model, $key, $index, $widget)
						{
							return '<a href="'. Url::to(['/multeobjects/static-pages/update', 'id' => $model->id]) . '">' . $model->page_name . '</a>';
						} 
			],

			/*[ 
					'attribute' => 'content',
					'format' => 'raw'
			],*/
           // 'added_at',
//            'updated_at', 

            [
                'class' => '\kartik\grid\ActionColumn',
				'template'=>'{update} {view}',
                'buttons' => [
				'view' => function ($url, $model) {
					return'';	
				},
                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['/multeobjects/static-pages/update','id' => $model->id]), [
                                                    'title' => Yii::t('app', 'Edit'),
                                                  ]);}

                ],
            ],
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>false,




        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            //'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add'), ['create'], ['class' => 'btn btn-success btn-sm']),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info btn-sm']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
