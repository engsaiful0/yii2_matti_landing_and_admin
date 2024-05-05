<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use multebox\models\search\MulteModel;
use multebox\models\search\ProductSubCategory as ProductSubCategorySearch;


/**
 * @var yii\web\View $this
 * @var multebox\models\ProductCategory $model
 */

$this->title = $model->faq_title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'FAQ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>

<script src="<?=Url::base()?>/bower_components/ckeditor/ckeditor.js"></script>

<?php $form = ActiveForm::begin ( [ 
						'type' => ActiveForm::TYPE_VERTICAL , 
  						'options'=>array('enctype' => 'multipart/form-data')
				] );?>
<div class="panel panel-info">
	<div class="panel-heading">
    	<h3 class="panel-title"><?php echo Yii::t('app', 'Title'); ?> - <?=$model->faq_title?>
        	<div class="pull-right">
                <a class="close" href="<?=Url::to(['/product/faq/index'])?>" >
                	<span class="glyphicon glyphicon-remove"></span>
                </a>
            </div>
        </h3>
    </div>
    <div class="panel-body">
        	<div class="product-category-update">
        		<div class="row">
                	<div class="col-sm-12">
						<?=  Form::widget ( [ 
                             'model' => $model,
                             'form' => $form,
                             'columns' => 4,
                             'attributes' => [ 
                                     'faq_title' => [
			                                         'type' => Form::INPUT_TEXT,
		                                            'options' => [ 
													'placeholder' => Yii::t('app','Enter Title Name...'),
													'maxlength' => 255 
											],
    
                                            'columnOptions' => [ 
													'colspan' => 3 
											] 
										]
                            ]
                        ]
                   );?>
                        <?=  Form::widget ( [
                                'model' => $model,
                                'form' => $form,
                                'columns' => 4,
                                'attributes' => [
                                    'faq_details' => [
                                        'type' => Form::INPUT_TEXT,
                                        'options' => [
                                            'placeholder' => Yii::t('app','Enter Title Details...'),
                                            'maxlength' => 255
                                        ],

                                        'columnOptions' => [
                                            'colspan' => 3
                                        ]
                                    ]
                                ]
                            ]
                        );?>
					 <?=  Form::widget ( [ 
                             'model' => $model,
                             'form' => $form,
                             'columns' => 4,
                             'attributes' => [ 
                                     'active' => [ 
			                                         'type' => Form::INPUT_DROPDOWN_LIST,
    
                                            'columnOptions'=>['colspan'=>1],
											'items'=>array('0'=> Yii::t('app', 'No') ,'1'=> Yii::t('app', 'Yes'))  , 
											'options' => [ 
                                                'prompt' => '--'.Yii::t('app', 'Select').'--',
												'disabled' => $dFlag,
											],
										]
                            ]
                        ]
                   );
                     ActiveForm::end ();?>
                   </div>
                </div>
	        </div>

			<?php
				echo Html::submitButton ( $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), [ 
                                                'class' => $model->isNewRecord ? 'btn btn-success title_submit' : 'btn btn-primary btn-sm  product_category_submit'
                                        ] );
			?> 
    </div>
    
</div>  

<script>
  $(function () {
    CKEDITOR.replace('productcategory-description');
  })
</script>