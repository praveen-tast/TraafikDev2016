<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Manage'),
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="page-header">
	<h1><?php echo Yii::t('app', 'Manage') . ' : ' . GxHtml::encode($model->label(2)); 

	?></h1>
	
	
	<?php   $this->widget('bootstrap.widgets.TbButtonGroup', array(
	'buttons'=>$this->actions,
	'type'=>'success',
	'htmlOptions'=>array('class'=> 'pull-right'),
	));
?>
</div>

<p>
You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.
</p>


<?php

$url =  Yii::app()->request->baseUrl.'/wdir/uploads';
 $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'user-grid',
	'type'=>'striped bordered condensed',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
	//'id',
	/* 	array(
				    'name' => 'image_file',
					'type' => 'raw',
					'value' => '!empty($data->image_file) ?CHtml::image(Yii::app()->createAbsoluteUrl("user/download",array("file"=>$data->image_file)),"  ",array("width"=>"180px","height"=>"80px")):CHtml::image(Yii::app()->createAbsoluteUrl("user/download",array("file"=>"user.png")),"  ",array("width"=>"80px","height"=>"80px"))'
		
			), */
		'full_name',
		'email',
		'mobile',
			/*array(
					'name' => 'role_id',
					'value'=>'$data->getRoleOptions($data->role_id)',
					'filter'=>User::getRoleOptions(),
			),*/
		//'date_of_birth',
		//'about_me:html',
		
		//'image_file',
		//'home_lat',
		//'home_long',
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
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions' => array('nowrap'=>'nowrap'),
		), 
		/* 	array
			(
					'class'=>'CButtonColumn',
					'template'=>'{view}',
					'buttons'=>array(
							'view'=>array(
									'label'=>'view',
							),
								
							)
			) */
	),
)); ?>