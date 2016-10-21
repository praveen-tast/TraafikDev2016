<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Manage'),
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('group-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="page-header">
	<h1><?php echo Yii::t('app', 'Manage') . ' : ' . GxHtml::encode($model->label(2)); ?></h1>
</div>
<p>
You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.
</p>


<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'group-grid',
	'type'=>'striped bordered condensed',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		'id',
		'name',
		'limits',
		array(
			'name'=>'user_id',
			'value'=>'GxHtml::valueEx($data->user)',
			'filter'=>GxHtml::listDataEx(User::model()->findAllAttributes(null, true)),
			),
		array(
				'name' => 'type_id',
				'value'=>'$data->getTypeOptions($data->type_id)',
				'filter'=>Group::getTypeOptions(),
				),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions' => array('nowrap'=>'nowrap'),
		),
	),
)); ?>