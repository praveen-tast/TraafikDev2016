<!--  form code start here -->
<div class="form well">


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id' => 'message-form',
	'type'=>'horizontal',
	'enableAjaxValidation' => true,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
?>
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


<?php echo  '';$code = $this->richTextEditor() ;

					if ($code == 1) echo $form->html5EditorRow($model,'content', array('class'=>'span4', 'rows'=>5, 'height'=>'200', 'options'=>array('color'=>true)));

					else if ($code == 2) echo $form->redactorRow($model,'content', array('class'=>'span4', 'rows'=>5));

					else if ($code == 3) echo $form->ckEditorRow($model,'content', array('options'=>array('fullpage'=>'js:true', 'width'=>'640', 'resize_maxWidth'=>'640','resize_minWidth'=>'320')));

					else echo $form->textAreaRow($model,'content',  array('class'=>'span4', 'rows'=>5));; ?>


<?php echo $form->radioButtonListRow($model, 'to_id', GxHtml::listDataEx(User::model()->findAllAttributes(null, true))); ?>


<?php echo $form->radioButtonListRow($model, 'from_id', GxHtml::listDataEx(User::model()->findAllAttributes(null, true))); ?>


<?php echo $form->fileFieldRow($model, 'file_path'); ?>


<?php echo $form->fileFieldRow($model, 'file_type'); ?>


<?php echo $form->textFieldRow($model,'group_id',array('class'=>'span5')); ?>


<?php echo $form->textFieldRow($model,'session_id',array('class'=>'span5','maxlength'=>32)); ?>


<?php echo $form->textFieldRow($model,'latitude',array('class'=>'span5','maxlength'=>32)); ?>


<?php echo $form->textFieldRow($model,'longitude',array('class'=>'span5','maxlength'=>32)); ?>


<?php echo $form->dropDownListRow($model, 'type_id',
			$model->getTypeOptions()); ?>


<?php echo $form->dropDownListRow($model, 'state_id',
			$model->getStatusOptions()); ?>


<?php echo $form->datepickerRow($model, 'received_time',
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