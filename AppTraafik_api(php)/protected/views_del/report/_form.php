<!--  form code start here -->
<div class="form well">


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id' => 'report-form',
	'type'=>'horizontal',
	//'action' => $this->createUrl('api/post/create'),
	'enableAjaxValidation' => true,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
?>
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>255)); ?>


<?php echo $form->dropDownListRow($model, 'state_id',
			$model->getStatusOptions()); ?>


<?php echo $form->dropDownListRow($model, 'type_id',
			$model->getTypeOptions()); ?>


<?php echo $form->textFieldRow($model,'expiry_duration',array('class'=>'span5','maxlength'=>128)); ?>


<?php if ( count (ReportCause::model()->findAllAttributes(null, true) ) > 0 ): ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('reportCauses')); ?></label>
	
		<?php echo $form->checkBoxListRow($model, 'reportCauses', GxHtml::encodeEx(GxHtml::listDataEx(ReportCause::model()->findAllAttributes(null, true)), false, true)); ?>
<?php endif; ?>	



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