<div class="wide form">

<?php 	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'id' => 'report-form',
	'type'=>'horizontal',		
)); ; 
?>

	<div class="row">
		<?php echo $form->label($model, 'id'); ?>
		<?php echo $form->textField($model, 'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'title'); ?>
		<?php echo $form->textField($model, 'title', array('maxlength' => 255)); ?>
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


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- search-form -->
