<!--  form code start here -->
<div class="form well">


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id' => 'invitation-form',
	'type'=>'horizontal',
	'enableAjaxValidation' => true,
		'action'=>Yii::app()->createUrl('api/user/invite'),
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
?>
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


<?php echo $form->textFieldRow($model,'to_user_id',array('class'=>'span5')); ?>


<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>255)); ?>


<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>255)); ?>


<?php //echo $form->textFieldRow($model,'contact_no',array('class'=>'span5','maxlength'=>32)); ?>


<?php echo  '';$code = $this->richTextEditor() ;

					if ($code == 1) echo $form->html5EditorRow($model,'contact_details', array('class'=>'span4', 'rows'=>5, 'height'=>'200', 'options'=>array('color'=>true)));

					else if ($code == 2) echo $form->redactorRow($model,'contact_details', array('class'=>'span4', 'rows'=>5));

					else if ($code == 3) echo $form->ckEditorRow($model,'contact_details', array('options'=>array('fullpage'=>'js:true', 'width'=>'640', 'resize_maxWidth'=>'640','resize_minWidth'=>'320')));

					else echo $form->textAreaRow($model,'contact_details',  array('class'=>'span4', 'rows'=>5));; ?>


<?php echo $form->dropDownListRow($model, 'state_id',
			$model->getStatusOptions()); ?>


<?php echo $form->dropDownListRow($model, 'type_id',
			$model->getTypeOptions()); ?>


<?php echo $form->textFieldRow($model,'invitation_count',array('class'=>'span5')); ?>



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