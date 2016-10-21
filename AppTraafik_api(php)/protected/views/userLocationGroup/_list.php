
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'user-location-group-grid',
	'type'=>'bordered', // 'condensed','striped',
	'dataProvider' => $dataProvider,
	'columns' => array(
		'id',
		'user_id',
		'group_id',
		'duration',
		array(
				'name' => 'state_id',
				'value'=>'$data->getStatusOptions($data->state_id)',
				'filter'=>UserLocationGroup::getStatusOptions(),
				),
		array(
				'name' => 'type_id',
				'value'=>'$data->getTypeOptions($data->type_id)',
				'filter'=>UserLocationGroup::getTypeOptions(),
				),
		array(
			'class' => 'CxButtonColumn',
		),
	),
)); ?>