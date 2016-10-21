
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'user-group-grid',
	'type'=>'bordered', // 'condensed','striped',
	'dataProvider' => $dataProvider,
	'columns' => array(
		'id',
		'user_id',
		'group_id',
		array(
				'name' => 'state_id',
				'value'=>'$data->getStatusOptions($data->state_id)',
				'filter'=>UserGroup::getStatusOptions(),
				),
		array(
				'name' => 'type_id',
				'value'=>'$data->getTypeOptions($data->type_id)',
				'filter'=>UserGroup::getTypeOptions(),
				),
		array(
			'class' => 'CxButtonColumn',
		),
	),
)); ?>