
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'invitation-grid',
	'type'=>'bordered', // 'condensed','striped',
	'dataProvider' => $dataProvider,
	'columns' => array(
		'id',
		'to_user_id',
		'email',
		'name',
		'contact_no',
		'contact_details:html',
		
		array(
				'name' => 'state_id',
				'value'=>'$data->getStatusOptions($data->state_id)',
				'filter'=>Invitation::getStatusOptions(),
				),
		/*array(
				'name' => 'type_id',
				'value'=>'$data->getTypeOptions($data->type_id)',
				'filter'=>Invitation::getTypeOptions(),
				),
		'invitation_count',
		*/
		array(
			'class' => 'CxButtonColumn',
		),
	),
)); ?>