
<div class ="span4 well">
<?php 
if(!empty($model->file_path)){
$url = Yii::app()->createAbsoluteUrl('post/download',array('file'=>$model->file_path));
echo CHtml::image($url,'no image',array('style'=>'width:25%'));}

?>
<h3><?php echo GxHtml::encode(GxHtml::valueEx($model)); ?></h3>


<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
'id',
array(
		'name' => 'report',
		'type' => 'raw',
		'value' => $model->report !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->report)), array('report/view', 'id' => GxActiveRecord::extractPkValue($model->report, true))) : null,
),
array(
		'name' => 'reportCause',
		'type' => 'raw',
		'value' => $model->reportCause !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->reportCause)), array('reportCause/view', 'id' => GxActiveRecord::extractPkValue($model->reportCause, true))) : null,
),

array(
		'name' => 'side_id',
		'type' => 'raw',
		'value'=>$model->getSideOptions($model->side_id),
),
'content:html',


'latitude',
'longitude',
//'note_send_time',
array(
				'name' => 'state_id',
				'type' => 'raw',
				'value'=>$model->getStatusOptions($model->state_id),
				),
/*array(
				'name' => 'type_id',
				'type' => 'raw',
				'value'=>$model->getTypeOptions($model->type_id),
				),*/
//'expiry_duration',
array(
			'name' => 'createUser',
			'type' => 'raw',
			'value' => $model->createUser !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->createUser)), array('user/view', 'id' => GxActiveRecord::extractPkValue($model->createUser, true))) : null,
			),
'create_time',
'update_time',
	),
)); ?>
<?php   $this->widget('bootstrap.widgets.TbButtonGroup', array(
	'buttons'=>$this->actions,
	'type'=>'success',
	'htmlOptions'=>array('class'=> ''),
	));
?>
</div>


<div class ="span8">
<div class="clearfix"></div>

<?php 

	$url  = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($model->latitude).','.trim($model->longitude).'&sensor=false';
	$json  = @file_get_contents($url);
	$data  = json_decode($json, true);
	/* Specify Postion for formatted address array index */
	 $current_address = $data['results'][0]['formatted_address']; 
	 $address = '<div>'.$current_address.'</div>';
	
	Yii::import('ext.EGMap.*'); 
	$gMap = new EGMap();
	$gMap->setWidth('100%');
	$gMap->setHeight(500);
	$gMap->zoom = 4;
	$gMap->setCenter($model->latitude, $model->longitude); 
	// Create GMapInfoWindow
	$info_window = new EGMapInfoWindow($address); 
	// Create marker
	$marker = new EGMapMarker($model->latitude, $model->longitude, array('title' => ''));
	$marker->addHtmlInfoWindow($info_window);
	$gMap->addMarker($marker);
	 
	$gMap->renderMap();
?>
</div>








