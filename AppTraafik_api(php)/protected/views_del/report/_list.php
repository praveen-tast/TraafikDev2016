
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'report-grid',
	'type'=>'bordered', // 'condensed','striped',
	'dataProvider' => $dataProvider,
	'columns' => array(
		'id',
		'title',
		array(
				'name' => 'state_id',
				'value'=>'$data->getStatusOptions($data->state_id)',
				'filter'=>Report::getStatusOptions(),
				),
		array(
				'name' => 'type_id',
				'value'=>'$data->getTypeOptions($data->type_id)',
				'filter'=>Report::getTypeOptions(),
				),
		'expiry_duration',
		array(
			'class' => 'CxButtonColumn',
		),
	),
)); ?>