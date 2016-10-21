
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'message-grid',
	'type'=>'bordered', // 'condensed','striped',
	'dataProvider' => $dataProvider,
	'columns' => array(
		'id',
		array(
			'name'=>'to_id',
			'value'=>'GxHtml::valueEx($data->to)',
			'filter'=>GxHtml::listDataEx(User::model()->findAllAttributes(null, true)),
			),
		array(
			'name'=>'from_id',
			'value'=>'GxHtml::valueEx($data->from)',
			'filter'=>GxHtml::listDataEx(User::model()->findAllAttributes(null, true)),
			),
		'file_path',
		array(
				'name' => 'file_type',
				'value'=>'$data->getTypeOptions($data->file_type)',
				'filter'=>Message::getTypeOptions(),
				),
		'group_id',
		/*
		'session_id',
		'latitude',
		'longitude',
		array(
				'name' => 'type_id',
				'value'=>'$data->getTypeOptions($data->type_id)',
				'filter'=>Message::getTypeOptions(),
				),
		array(
				'name' => 'state_id',
				'value'=>'$data->getStatusOptions($data->state_id)',
				'filter'=>Message::getStatusOptions(),
				),
		'received_time',
		*/
		array(
			'class' => 'CxButtonColumn',
		),
	),
)); ?>