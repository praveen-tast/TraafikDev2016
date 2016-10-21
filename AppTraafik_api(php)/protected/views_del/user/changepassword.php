<?php

$this->breadcrumbs = array(
		$model->label(2) => array('index'),
		GxHtml::valueEx($model) => array('view', 'id' => GxActiveRecord::extractPkValue($model, true)),
		Yii::t('app', 'Change Password'),
);

?>
<div class="page-header">
	<h1>
		<?php echo Yii::t('app', 'Change Password') ; ?>
	</h1>
</div>


<div class="form well">

	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id' => 'user-form',
			'type'=>'horizontal',
			//'enableAjaxValidation' => false,
			'enableClientValidation'=>true,
			'action'=>Yii::app()->createUrl('/api/user/changepassword'),
			'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	));
	?>

	<p class="help-block pull-right">
		<?php echo Yii::t('app', 'Fields with'); ?>
		<span class="required">*</span>
		<?php echo Yii::t('app', 'are required'); ?>
		.
	</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'email'); ?>
	<?php echo $form->passwordFieldRow($model,'password',array('maxlength'=>512)); ?>
	<?php echo $form->passwordFieldRow($model,'password_2',array('maxlength'=>512,)); ?>
	<div class="form-actions">
		<?php
	 $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'success',
				'label'=>' Save ',

		));   ?>
	</div>
	<?php $this->endWidget(); ?>

</div>
<!-- form -->
