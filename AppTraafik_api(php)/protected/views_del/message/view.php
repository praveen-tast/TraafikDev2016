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
'content:html',
array(
			'name' => 'to',
			'type' => 'raw',
			'value' => $model->to !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->to)), array('user/view', 'id' => GxActiveRecord::extractPkValue($model->to, true))) : null,
			),
array(
			'name' => 'from',
			'type' => 'raw',
			'value' => $model->from !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->from)), array('user/view', 'id' => GxActiveRecord::extractPkValue($model->from, true))) : null,
			),
'file_path',
array(
				'name' => 'file_type',
				'type' => 'raw',
				'value'=>$model->getTypeOptions($model->file_type),
				),
'group_id',
'session_id',
'latitude',
'longitude',
array(
				'name' => 'type_id',
				'type' => 'raw',
				'value'=>$model->getTypeOptions($model->type_id),
				),
array(
				'name' => 'state_id',
				'type' => 'raw',
				'value'=>$model->getStatusOptions($model->state_id),
				),
'received_time',
'create_time',
	),
)); ?>


<?php   $this->widget('CommentPortlet', array(
	'model' => $model,
));
?>