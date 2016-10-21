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
			'name' => 'report',
			'type' => 'raw',
			'value' => $model->report !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->report)), array('report/view', 'id' => GxActiveRecord::extractPkValue($model->report, true))) : null,
			),
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
	),
)); ?>


<?php   $this->widget('CommentPortlet', array(
	'model' => $model,
));
?>