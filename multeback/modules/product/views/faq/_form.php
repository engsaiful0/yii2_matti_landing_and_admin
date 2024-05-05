<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var multebox\models\VendorType $model
 * @var yii\widgets\ActiveForm $form
 */

$dFlag=false;
if(Yii::$app->user->identity->entity_type == 'vendor')
{
	$model->active=0;
	$dFlag=true;
}

?>

<script src="<?=Url::base()?>/bower_components/ckeditor/ckeditor.js"></script>

<div class="product-category-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
	'faq_title'=>	['name'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>Yii::t('app', 'Enter FAQ Title...'), 'maxlength'=>255]],
        'faq_details'=>	['name'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>Yii::t('app', 'Enter FAQ Details...'), 'row'=>5]],

	'active' => [ 
					'type' => Form::INPUT_DROPDOWN_LIST,
				//	'label' => 'Status',
					'columnOptions'=>['colspan'=>1],
					'items'=>array('0'=> Yii::t('app', 'No') ,'1'=> Yii::t('app', 'Yes'))  , 
					'options' => [ 
							'prompt' => '--'.Yii::t('app', 'Select').'--',
							'disabled' => $dFlag,	
					]
				],
//'created_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Created At...']], 

//'updated_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated At...']], 

    ]


    ]);

	if($model->isNewRecord)
	{
	?>
		<input type="hidden" name="Faq[added_by_id]" class="form-control" value="<?=Yii::$app->user->identity->id?>">
	<?php
	}


    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm']);
    ActiveForm::end(); ?>

</div>

<script>
  $(function () {
    CKEDITOR.replace('productcategory-description');
  })
</script>