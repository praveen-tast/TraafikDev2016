
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'notification-grid',
	'type'=>'bordered', // 'condensed','striped',
	'dataProvider' => $dataProvider,
	'columns' => array(
		'id',
		'to_user_id',
		'message:html',
		'model_id',
		array(
				'name' => 'model_type',
				'value'=>'$data->getTypeOptions($data->model_type)',
				'filter'=>Notification::getTypeOptions(),
				),
		'model_action',
		/*
		array(
				'name' => 'state_id',
				'value'=>'$data->getStatusOptions($data->state_id)',
				'filter'=>Notification::getStatusOptions(),
				),
		array(
				'name' => 'type_id',
				'value'=>'$data->getTypeOptions($data->type_id)',
				'filter'=>Notification::getTypeOptions(),
				),
		*/
		array(
			'class' => 'CxButtonColumn',
		),
	),
)); ?>