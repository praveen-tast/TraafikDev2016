
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'user-grid',
	'type'=>'bordered condensed striped',
	'selectionChanged'=>"function(id){window.location='" . Yii::app()->createAbsoluteUrl('user/view') . "/' + $.fn.yiiGridView.getSelection(id);}",
	'dataProvider' => $dataProvider,
	'columns' => array(
		'id',
		'full_name',
		'email',
		'date_of_birth',
		//'about_me:html',
		'gender',
		'image_file',
		/*
		'role_id',
		array(
				'name' => 'state_id',
				'value'=>'$data->getStatusOptions($data->state_id)',
				'filter'=>User::getStatusOptions(),
				),
		array(
				'name' => 'type_id',
				'value'=>'$data->getTypeOptions($data->type_id)',
				'filter'=>User::getTypeOptions(),
				),
		'last_visit_time',
		'last_action_time',
		'last_password_change',
		'login_error_count',
		*/
		array(
			'class' => 'CxButtonColumn',
		),
	),
)); ?>