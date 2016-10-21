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
'auth_code',
'device_token',
array(
				'name' => 'type_id',
				'type' => 'raw',
				'value'=>$model->getTypeOptions($model->type_id),
				),
array(
			'name' => 'createUser',
			'type' => 'raw',
			'value' => $model->createUser !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->createUser)), array('user/view', 'id' => GxActiveRecord::extractPkValue($model->createUser, true))) : null,
			),
'create_time',
'update_time',
	),
)); ?>


<?php   $this->widget('CommentPortlet', array(
	'model' => $model,
));
?>