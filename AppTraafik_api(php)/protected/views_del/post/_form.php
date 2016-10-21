<!--  form code start here -->
<div class="form well">


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id' => 'post-form',
	'type'=>'horizontal',
	//'action'=>Yii::app()->createUrl('api/post/getAllTraffic',array('id'=>$model->id)),
		'action' => $this->createUrl('api/post/create'),
	'enableAjaxValidation' => true,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
?>
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


<?php echo $form->dropDownListRow($model, 'report_id',GxHtml::listDataEx(Report::model()->findAll())); ?>

<?php echo $form->textFieldRow($model,'report_cause_id',array('class'=>'span5')); ?>

<?php //echo $form->dropDownListRow($model, 'report_cause_id',GxHtml::listDataEx(ReportCause::model()->findAll()));?>


<?php echo $form->textFieldRow($model,'side_id',array('class'=>'span5')); ?>


<?php echo  '';$code = $this->richTextEditor() ;

					if ($code == 1) echo $form->html5EditorRow($model,'content', array('class'=>'span4', 'rows'=>5, 'height'=>'200', 'options'=>array('color'=>true)));

					else if ($code == 2) echo $form->redactorRow($model,'content', array('class'=>'span4', 'rows'=>5));

					else if ($code == 3) echo $form->ckEditorRow($model,'content', array('options'=>array('fullpage'=>'js:true', 'width'=>'640', 'resize_maxWidth'=>'640','resize_minWidth'=>'320')));

					else echo $form->textAreaRow($model,'content',  array('class'=>'span4', 'rows'=>5));; ?>


<?php echo $form->fileFieldRow($model, 'file_path'); ?>


<?php //echo $form->fileFieldRow($model, 'file_ext_type'); ?>


<?php echo $form->textFieldRow($model,'latitude',array('class'=>'span5','maxlength'=>32)); ?>


<?php echo $form->textFieldRow($model,'longitude',array('class'=>'span5','maxlength'=>32)); ?>


<?php echo $form->textFieldRow($model,'note_send_time',array('class'=>'span5','maxlength'=>50)); ?>


<?php echo $form->dropDownListRow($model, 'state_id',
			$model->getStatusOptions()); ?>


<?php echo $form->dropDownListRow($model, 'type_id',
			$model->getTypeOptions()); ?>


<?php echo $form->textFieldRow($model,'expiry_duration',array('class'=>'span5','maxlength'=>128)); ?>


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