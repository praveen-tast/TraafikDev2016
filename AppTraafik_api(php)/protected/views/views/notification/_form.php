<!--  form code start here -->
<div class="form well">


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id' => 'notification-form',
	'type'=>'horizontal',
	'enableAjaxValidation' => true,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
?>
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


<?php echo $form->textFieldRow($model,'to_user_id',array('class'=>'span5')); ?>


<?php echo  '';$code = $this->richTextEditor() ;

					if ($code == 1) echo $form->html5EditorRow($model,'message', array('class'=>'span4', 'rows'=>5, 'height'=>'200', 'options'=>array('color'=>true)));

					else if ($code == 2) echo $form->redactorRow($model,'message', array('class'=>'span4', 'rows'=>5));

					else if ($code == 3) echo $form->ckEditorRow($model,'message', array('options'=>array('fullpage'=>'js:true', 'width'=>'640', 'resize_maxWidth'=>'640','resize_minWidth'=>'320')));

					else echo $form->textAreaRow($model,'message',  array('class'=>'span4', 'rows'=>5));; ?>


<?php echo $form->textFieldRow($model,'model_id',array('class'=>'span5')); ?>


<?php echo $form->textFieldRow($model,'model_type',array('class'=>'span5','maxlength'=>100)); ?>


<?php echo $form->textFieldRow($model,'model_action',array('class'=>'span5','maxlength'=>100)); ?>


<?php echo $form->dropDownListRow($model, 'state_id',
			$model->getStatusOptions()); ?>


<?php echo $form->dropDownListRow($model, 'type_id',
			$model->getTypeOptions()); ?>



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