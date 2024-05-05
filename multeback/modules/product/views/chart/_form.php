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
            'chart_title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => Yii::t('app', 'Enter Reference Title...'), 'maxlength' => 255]],

        ]

    ]);


	if(!$model->isNewRecord && $model->chart_file)
	{
	?>
		<div class="row">
			<div class="col-sm-12">
				<img src="<?=Yii::$app->params['web_url'].'/chart_file/'.$model->chart_file?>" class="img-responsive" style="width:35%;border:1px dotted black"></img>
			</div>
		</div>
		<br>
	<?php
		 echo $form->field($model, 'chart_file')->fileInput()->label(Yii::t('app', 'Change Image'));
	}
	else
	{
		echo $form->field($model, 'chart_file')->fileInput()->label(Yii::t('app', 'Add Image(1200x500)'));
	}

    if(!$model->isNewRecord && $model->chart_file_ref_image1)
    {
        ?>
        <div class="row">
            <div class="col-sm-12">
                <img src="<?=Yii::$app->params['web_url'].'/chart_file/'.$model->chart_file_ref_image1?>" class="img-responsive" style="width:35%;border:1px dotted black"></img>
            </div>
        </div>
        <br>
        <?php
        echo $form->field($model, 'chart_file_ref_image1')->fileInput()->label(Yii::t('app', 'Change Ref Image One'));
    }
    else
    {
        echo $form->field($model, 'chart_file_ref_image1')->fileInput()->label(Yii::t('app', 'Add Ref Image One(400x300)'));
    }
    if(!$model->isNewRecord && $model->chart_file_ref_image2)
    {
        ?>
        <div class="row">
            <div class="col-sm-12">
                <img src="<?=Yii::$app->params['web_url'].'/chart_file/'.$model->chart_file_ref_image2?>" class="img-responsive" style="width:35%;border:1px dotted black"></img>
            </div>
        </div>
        <br>
        <?php
        echo $form->field($model, 'chart_file_ref_image2')->fileInput()->label(Yii::t('app', 'Change Ref Image Two'));
    }
    else
    {
        echo $form->field($model, 'chart_file_ref_image2')->fileInput()->label(Yii::t('app', 'Add Ref Image Two(400x300)'));
    }
    if(!$model->isNewRecord && $model->chart_file_ref_image3)
    {
        ?>
        <div class="row">
            <div class="col-sm-12">
                <img src="<?=Yii::$app->params['web_url'].'/chart_file/'.$model->chart_file_ref_image3?>" class="img-responsive" style="width:35%;border:1px dotted black"></img>
            </div>
        </div>
        <br>
        <?php
        echo $form->field($model, 'chart_file_ref_image3')->fileInput()->label(Yii::t('app', 'Change Ref Image Three'));
    }
    else
    {
        echo $form->field($model, 'chart_file_ref_image3')->fileInput()->label(Yii::t('app', 'Add Ref Image Three(400x300)'));
    }

	if($model->isNewRecord)
	{
	?>
		<input type="hidden" name="Chart[added_by_id]" class="form-control" value="<?=Yii::$app->user->identity->id?>">
	<?php
	}

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
