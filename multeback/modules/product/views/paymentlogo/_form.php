<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var multebox\models\ProductBrand $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="product-brand-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'paymentlogo_title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => Yii::t('app', 'Enter Payment Logo Title...'), 'maxlength' => 255]],


            //'active' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Active...']],
			'active' => [ 
							'type' => Form::INPUT_DROPDOWN_LIST,
						//	'label' => 'Status',
							'options' => [ 
									'placeholder' => Yii::t('app', 'Enter Active ...')
							] ,
							'columnOptions'=>['colspan'=>1],
							'items'=>array('0'=> Yii::t('app', 'No') ,'1'=> Yii::t('app', 'Yes'))  , 
							'options' => [ 
									'prompt' => '--'.Yii::t('app', 'Select').'--'
							]
					],

           // 'added_by_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Added By ID...']],

           // 'sort_order' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Sort Order...']],

          //  'added_at' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Added At...']],

          //  'updated_at' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Updated At...']],

        ]

    ]);


	if(!$model->isNewRecord && $model->paymentlogo_file)
	{
	?>
		<div class="row">
			<div class="col-sm-12">
				<img src="<?=Yii::$app->params['web_url'].'/paymentlogo_file/'.$model->paymentlogo_file?>" class="img-responsive" style="width:35%;border:1px dotted black"></img>
			</div>
		</div>
		<br>
	<?php
		 echo $form->field($model, 'paymentlogo_file')->fileInput()->label(Yii::t('app', 'Change Image'));
	}
	else
	{
		echo $form->field($model, 'paymentlogo_file')->fileInput()->label(Yii::t('app', 'Add Image(600x200)'));
	}

	if($model->isNewRecord)
	{
	?>
		<input type="hidden" name="Paymentlogo[added_by_id]" class="form-control" value="<?=Yii::$app->user->identity->id?>">
	<?php
	}

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
