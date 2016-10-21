<div class="wide form">

<?php 	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'id' => 'post-form',
	'type'=>'horizontal',		
)); ; 
?>

	<div class="row">
		<?php echo $form->label($model, 'id'); ?>
		<?php echo $form->textField($model, 'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'report_id'); ?>
		<?php echo $form->textField($model, 'report_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'report_cause_id'); ?>
		<?php echo $form->textField($model, 'report_cause_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'side_id'); ?>
		<?php echo $form->textField($model, 'side_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'content'); ?>
		<?php $this->richTextEditor($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'file_path'); ?>
		<?php echo $form->textField($model, 'file_path', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'file_ext_type'); ?>
		<?php echo $form->textField($model, 'file_ext_type', array('maxlength' => 32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'latitude'); ?>
		<?php echo $form->textField($model, 'latitude', array('maxlength' => 32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'longitude'); ?>
		<?php echo $form->textField($model, 'longitude', array('maxlength' => 32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'note_send_time'); ?>
		<?php echo $form->textField($model, 'note_send_time', array('maxlength' => 50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'state_id'); ?>
		<?php 
			$this->widget('ext.widgets.CJuiRadioButtonList', array(
			'model'=>$model,
			'attribute'=>'state_id',
			'data'=>$model->getStatusOptions(),
			)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'type_id'); ?>
		<?php 
			$this->widget('ext.widgets.CJuiRadioButtonList', array(
			'model'=>$model,
			'attribute'=>'type_id',
			'data'=>$model->getTypeOptions(),
			)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'expiry_duration'); ?>
		<?php echo $form->textField($model, 'expiry_duration', array('maxlength' => 128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'create_user_id'); ?>
		<?php echo $form->dropDownList($model, 'create_user_id', GxHtml::listDataEx(User::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'create_time'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'create_time',
			'value' => $model->create_time,
			'options' => array(
			'showButtonPanel' => true,
			'changeYear' => true,
			'dateFormat' => 'yy-mm-dd',
			),
			));
; ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'update_time'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'update_time',
			'value' => $model->update_time,
			'options' => array(
			'showButtonPanel' => true,
			'changeYear' => true,
			'dateFormat' => 'yy-mm-dd',
			),
			));
; ?>
	</div>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- search-form -->
