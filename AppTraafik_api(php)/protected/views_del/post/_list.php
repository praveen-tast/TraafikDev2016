
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'post-grid',
	'type'=>'bordered', // 'condensed','striped',
	'dataProvider' => $dataProvider,
	'columns' => array(
		'id',
		'report_id',
		'report_cause_id',
		'side_id',
		'file_path',
		array(
				'name' => 'file_ext_type',
				'value'=>'$data->getTypeOptions($data->file_ext_type)',
				'filter'=>Post::getTypeOptions(),
				),
		/*
		'latitude',
		'longitude',
		'note_send_time',
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
		'update_time',
		*/
		array(
			'class' => 'CxButtonColumn',
		),
	),
)); ?>