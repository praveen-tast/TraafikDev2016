<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);


?>

<div class="page-header">
<h1><?php echo GxHtml::encode(GxHtml::valueEx($model)); ?></h1>
</div>

<?php   $this->widget('bootstrap.widgets.TbButtonGroup', array(
	'buttons'=>$this->actions,
	'type'=>'success',
	'htmlOptions'=>array('class'=> 'pull-right'),
	));
?>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
'id',
'title',
array(
				'name' => 'state_id',
				'type' => 'raw',
				'value'=>$model->getStatusOptions($model->state_id),
				),
array(
				'name' => 'type_id',
				'type' => 'raw',
				'value'=>$model->getTypeOptions($model->type_id),
				),
'expiry_duration',
	),
)); ?>

<?php
 $this->StartPanel(); ?>
<?php  $this->AddPanel($model->getRelationLabel('reportCauses'), $model->getRelatedDataProvider('reportCauses'),	'reportCauses','reportCause');?>
<?php  $this->EndPanel(); ?>

<?php   $this->widget('CommentPortlet', array(
	'model' => $model,
));
?>