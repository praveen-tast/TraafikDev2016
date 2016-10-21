
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'report-cause-grid',
	'type'=>'bordered', // 'condensed','striped',
	'dataProvider' => $dataProvider,
	'columns' => array(
		'id',
		'title',
			'latitude',
			'longitude',
		array(
			'name'=>'report_id',
			'value'=>'GxHtml::valueEx($data->report)',
			'filter'=>GxHtml::listDataEx(Report::model()->findAllAttributes(null, true)),
			),
		array(
				'name' => 'state_id',
				'value'=>'$data->getStatusOptions($data->state_id)',
				'filter'=>ReportCause::getStatusOptions(),
				),
		array(
				'name' => 'type_id',
				'value'=>'$data->getTypeOptions($data->type_id)',
				'filter'=>ReportCause::getTypeOptions(),
				),
		array(
			'class' => 'CxButtonColumn',
		),
	),
)); ?>