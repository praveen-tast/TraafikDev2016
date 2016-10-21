
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'rating-grid',
	'type'=>'bordered', // 'condensed','striped',
	'dataProvider' => $dataProvider,
	'columns' => array(
		'id',
		'post_id',
		'points',
		array(
				'name' => 'state_id',
				'value'=>'$data->getStatusOptions($data->state_id)',
				'filter'=>Rating::getStatusOptions(),
				),
		array(
				'name' => 'type_id',
				'value'=>'$data->getTypeOptions($data->type_id)',
				'filter'=>Rating::getTypeOptions(),
				),
		array(
			'class' => 'CxButtonColumn',
		),
	),
)); ?>