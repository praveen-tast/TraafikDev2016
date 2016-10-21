
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'group-grid',
	'type'=>'bordered', // 'condensed','striped',
	'dataProvider' => $dataProvider,
	'columns' => array(
		'id',
		'name',
		'limits',
		array(
			'name'=>'user_id',
			'value'=>'GxHtml::valueEx($data->user)',
			'filter'=>GxHtml::listDataEx(User::model()->findAllAttributes(null, true)),
			),
		array(
				'name' => 'type_id',
				'value'=>'$data->getTypeOptions($data->type_id)',
				'filter'=>Group::getTypeOptions(),
				),
		array(
			'class' => 'CxButtonColumn',
		),
	),
)); ?>