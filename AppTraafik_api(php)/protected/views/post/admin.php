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
	$.fn.yiiGridView.update('post-grid', {
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


<?php

 $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'post-grid',
	'type'=>'striped bordered condensed',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		'id',
	array(
			'name'=>'report_id',
			'value'=>'GxHtml::valueEx($data->report)',
			'filter'=>GxHtml::listDataEx(Report::model()->findAllAttributes(null, true)),
	),
	array(
			'name'=>'report_cause_id',
			'value'=>'GxHtml::valueEx($data->reportCause)',
			'filter'=>GxHtml::listDataEx(ReportCause::model()->findAllAttributes(null, true)),
	),
array(
		'name' => 'side_id',
		'value'=>'$data->getSideOptions($data->side_id)',
		'filter'=>Post::getSideOptions(),
),

		//'file_path',
			array(
					'name' => 'file_path',
					'type' => 'raw',
					'value' => '!empty($data->file_path) ?CHtml::image(Yii::app()->createAbsoluteUrl("post/download",array("file"=>$data->file_path)),"  ",array("width"=>"180px","height"=>"80px")):""'
			
			),
	/*
	
		'latitude',
		'longitude',
			'note_send_time',	array(
				'name' => 'file_ext_type',
				'value'=>'$data->getTypeOptions($data->file_ext_type)',
				'filter'=>Post::getTypeOptions(),
				),
		array(
				'name' => 'state_id',
				'value'=>'$data->getStatusOptions($data->state_id)',
				'filter'=>Post::getStatusOptions(),
				),
		array(
				'name' => 'type_id',
				'value'=>'$data->getTypeOptions($data->type_id)',
				'filter'=>Post::getTypeOptions(),
				),
		'expiry_duration',
		'update_time',*/
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions' => array('nowrap'=>'nowrap'),
		),
	),
)); ?>