<!--  form code start here -->
<div class="form well">


<?php 
$form = $this->beginWidget ( 'bootstrap.widgets.TbActiveForm', array (
		'id' => 'user-form',
		'type' => 'horizontal',		
	//'action'=>$this->createUrl('api/user/signup'),
	//'action'=>$this->createUrl('api/user/update',array("id"=>$model->id)),
		'enableAjaxValidation' => true,
		'htmlOptions' => array (
				'enctype' => 'multipart/form-data' 
		) 
) );
?>
<p class="help-block" align="right">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldRow($model,'full_name',array('class'=>'span5','maxlength'=>256)); ?>
<?php echo $form->textFieldRow($model,'first_name',array('class'=>'span5','maxlength'=>128)); ?>
<?php echo $form->textFieldRow($model,'last_name',array('class'=>'span5','maxlength'=>128)); ?>
<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>128)); ?>
<?php echo $form->textFieldRow($model,'work_lat',array('class'=>'span5','maxlength'=>128)); ?>
<?php echo $form->textFieldRow($model,'work_long',array('class'=>'span5','maxlength'=>128)); ?>

<?php echo $form->dropDownListRow($model, 'gender',
			$model->getGenderOptions()); ?>
<?php
if($this->action->Id != "update")
 {
	echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>512)); 
 }
?>
<?php echo $form->textFieldRow($model,'mobile',array('class'=>'span5')); ?>
<?php
echo $form->datepickerRow ( $model, 'date_of_birth', array (
		'hint' => 'Click inside! to select a date.',
		'prepend' => '<i class="icon-calendar"></i>',
		'options' => array(
				'dateFormat' => 'Y-m-d'
		)
		
) );

?>


<?php echo  '';$code = $this->richTextEditor() ;

					//if ($code == 1) echo $form->html5EditorRow($model,'about_me', array('class'=>'span4', 'rows'=>5, 'height'=>'200', 'options'=>array('color'=>true)));

					//else if ($code == 2) echo $form->redactorRow($model,'about_me', array('class'=>'span4', 'rows'=>5));

					//else if ($code == 3) echo $form->ckEditorRow($model,'about_me', array('options'=>array('fullpage'=>'js:true', 'width'=>'640', 'resize_maxWidth'=>'640','resize_minWidth'=>'320')));

					//else echo $form->textAreaRow($model,'about_me',  array('class'=>'span4', 'rows'=>5));; ?>


<?php echo $form->fileFieldRow($model, 'image_file'); ?>

<?php echo $form->dropDownListRow($model, 'role_id',
			$model->getRoleOptions()); ?>


<?php echo $form->dropDownListRow($model, 'state_id',
			$model->getStatusOptions()); ?>


<?php /*echo $form->dropDownListRow($model, 'type_id',
			$model->getTypeOptions()); */?>


<?php /*echo $form->datepickerRow($model, 'last_visit_time',
					array('hint'=>'Click inside! to select a date.',
					'prepend'=>'<i class="icon-calendar"></i>'))
; ?>


<?php echo $form->datepickerRow($model, 'last_action_time',
					array('hint'=>'Click inside! to select a date.',
					'prepend'=>'<i class="icon-calendar"></i>'))
; ?>


<?php echo $form->datepickerRow($model, 'last_password_change',
					array('hint'=>'Click inside! to select a date.',
					'prepend'=>'<i class="icon-calendar"></i>'))
; ?>


<?php echo $form->textFieldRow($model,'activation_key',array('class'=>'span5','maxlength'=>512)); ?>


<?php echo $form->textFieldRow($model,'login_error_count',array('class'=>'span5')); */?>


<?php /*if ( count (AuthSession::model()->findAllAttributes(null, true) ) > 0 ): ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('authSessions')); ?></label>
	
		<?php echo $form->checkBoxListRow($model, 'authSessions', GxHtml::encodeEx(GxHtml::listDataEx(AuthSession::model()->findAllAttributes(null, true)), false, true)); ?>
<?php endif; */?>	





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