<!--  form code start here -->
<div class="form well">


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id' => 'auth-session-form',
	'type'=>'horizontal',
	'enableAjaxValidation' => true,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
?>
	<p class="help-block" align="right">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


<?php echo $form->textFieldRow($model,'auth_code',array('class'=>'span5','maxlength'=>256)); ?>


<?php echo $form->textFieldRow($model,'device_token',array('class'=>'span5','maxlength'=>256)); ?>


<?php echo $form->dropDownListRow($model, 'type_id',
			$model->getTypeOptions()); ?>


<?php echo $form->datepickerRow($model, 'update_time',
					array('hint'=>'Click inside! to select a date.',
					'prepend'=>'<i class="icon-calendar"></i>'))
; ?>




	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

</div>
<!-- form code ends here -->