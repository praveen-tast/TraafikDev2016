<div class="wide form">

<?php 	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'id' => 'message-form',
	'type'=>'horizontal',		
)); ; 
?>

	<div class="row">
		<?php echo $form->label($model, 'id'); ?>
		<?php echo $form->textField($model, 'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'content'); ?>
		<?php $this->richTextEditor($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'to_id'); ?>
		<?php echo $form->dropDownList($model, 'to_id', GxHtml::listDataEx(User::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'from_id'); ?>
		<?php echo $form->dropDownList($model, 'from_id', GxHtml::listDataEx(User::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'file_path'); ?>
		<?php echo $form->textField($model, 'file_path', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'file_type'); ?>
		<?php echo $form->textField($model, 'file_type', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'group_id'); ?>
		<?php echo $form->textField($model, 'group_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'session_id'); ?>
		<?php echo $form->textField($model, 'session_id', array('maxlength' => 32)); ?>
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
		<?php echo $form->label($model, 'type_id'); ?>
		<?php 
			$this->widget('ext.widgets.CJuiRadioButtonList', array(
			'model'=>$model,
			'attribute'=>'type_id',
			'data'=>$model->getTypeOptions(),
			)); ?>
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
		<?php echo $form->label($model, 'received_time'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'received_time',
			'value' => $model->received_time,
			'options' => array(
			'showButtonPanel' => true,
			'changeYear' => true,
			'dateFormat' => 'yy-mm-dd',
			),
			));
; ?>
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


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- search-form -->
