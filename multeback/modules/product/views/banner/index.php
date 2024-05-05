<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use multebox\models\User;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var multebox\models\search\ProductBrand $searchModel
 */

$this->title = Yii::t('app', 'Banner');
$this->params['breadcrumbs'][] = $this->title;

function statusLabel($status)
{
	if ($status !='1')
	{
		$label = "<span class=\"label label-danger\">".Yii::t('app', 'Inactive')."</span>";
	}
	else
	{
		$label = "<span class=\"label label-primary\">".Yii::t('app', 'Active')."</span>";
	}
	return $label;
}
$status = array('0'=>Yii::t('app', 'Inactive'),'1'=>Yii::t('app', 'Active'));
?>
<div class="product-brand-index">
    <!--<div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Product Brand',
]), ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'responsiveWrap' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'id',
           'banner_new_name',
           // 'active',

            [

                'attribute' => 'banner_file',

                'label' => Yii::t('app', 'Banner Image'),

                'format' => 'raw',



                'value' => function ($model, $key, $index, $widget)

                {

                    $users = '<div class="project-people">';

                    $path =Yii::$app->params['web_url'].'/banner/' . $model->banner_file;
//                    var_dump(file_exists($path));
//                    print_r($path);
//                   // if (file_exists($path)) {

                    $image = '<img width="400" height="250" src="'.$path. '" class="">';
                    // } else {

                    //  $image = '<img src="'.Url::base().'/nophoto.jpg" class="img-sm">';
                    //}

                    $users .= '<a href="">' . $image . '</a>';

                    $users .= '</div>';

                    return $users;
                }
            ],
             [
				'attribute' => 'active',
			//	'label' => 'Active',
				'format' => 'raw',
				'filterType' => GridView::FILTER_SELECT2,
				'filter' => $status,
				'filterWidgetOptions' => [
						'options' => [
								'placeholder' => Yii::t('app', 'All...')
						],
						'pluginOptions' => [
								'allowClear' => true
						]
				],
				'value' => function ($model, $key, $index, $widget)
				{
						return statusLabel ( $model->active );
				}
			]
            ,
          //  'added_by_id',
         //   'sort_order',
//            'added_at', 
//            'updated_at', 

            [
                'class' => 'yii\grid\ActionColumn',
				'template'=>'{update}  {delete} {action}',
                'buttons' => [
                    'update' => function ($url, $model) {
						if(Yii::$app->params['user_role'] != 'admin' && $model->added_by_id != Yii::$app->user->identity->id)
							return '';
						else
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['/product/banner/update', 'id' => $model->id, 'edit' => 't']),
                            ['title' => Yii::t('app', 'Edit'),]
                        );
                    },

					'delete' => function ($url, $model) {
						if(Yii::$app->user->identity->entity_type=='vendor')
							return '';
						else
						return Html::a('<span class="glyphicon glyphicon-trash"></span>',
							 Yii::$app->urlManager->createUrl(['/product/banner/delete', 'id' => $model->id]),
								['title' => Yii::t('app', 'Delete'), 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this Banner?'), 'data-method' => 'POST']
							);
						},

					'action' => function ($url, $model) {
						if(Yii::$app->user->identity->entity_type=='vendor')
							return '';
						else
						if($model->active == 0)
						{
							return Html::a('<span class="glyphicon glyphicon-ok"></span>',
							 Yii::$app->urlManager->createUrl(['/product/banner/activate', 'id' => $model->id, 'activate' => 't']),
								['title' => Yii::t('app', 'Activate'), 'data-confirm' => Yii::t('app', 'Are you sure you want to activate this Banner?'),]
							);
						}
						else
						{
							return Html::a('<span class="glyphicon glyphicon-remove"></span>',
							 Yii::$app->urlManager->createUrl(['/product/banner/deactivate', 'id' => $model->id, 'deactivate' => 't']),
								['title' => Yii::t('app', 'Deactivate'), 'data-confirm' => Yii::t('app', 'Are you sure you want to deactivate this Banner?'),]
							);
						}
                    }
                ],
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => false,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type' => 'info',
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add'), ['create'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('app', 'Reset List'), ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
