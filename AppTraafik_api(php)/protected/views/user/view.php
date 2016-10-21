<?php
$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);
?>

<div class ="span4 well">
<?php 
if(!empty($model->image_file))
	$url = Yii::app()->createAbsoluteUrl('user/download',array('file'=>$model->image_file));
else 
	$url = Yii::app()->createAbsoluteUrl('user/download',array('file'=>'user.png'));
	echo CHtml::image($url,'no image',array('style'=>'width:16%'));
?>
<h3><?php echo GxHtml::encode(GxHtml::valueEx($model)); ?></h3>
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
'id',
//'full_name',
'email',
/*array(
	'name' => 'gender',
	'type' => 'raw',
	'value'=>$model->getGenderOptions($model->gender),
),*/
'mobile',
'date_of_birth',
'work_lat',
'work_long',			
//'about_me:html',
//'image_file',
//'role_id',
array(
		'name' => 'role_id',
		'type' => 'raw',
		'value'=>$model->getRoleOptions($model->role_id),
),
array(
				'name' => 'state_id',
				'type' => 'raw',
				'value'=>$model->getStatusOptions($model->state_id),
),
/*array(
				'name' => 'type_id',
				'type' => 'raw',
				'value'=>$model->getTypeOptions($model->type_id),
),
'last_visit_time',
'last_action_time',
'last_password_change',
'login_error_count',*/
'create_time',
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
if($model->work_lat !=null && $model->work_long != null)
	Yii::import('ext.EGMap.*'); 
	$gMap = new EGMap();
	$gMap->setWidth('100%');
	$gMap->setHeight(500);
	$gMap->zoom = 4;
	$i=0;
	foreach ($users as $user)
	{
		if(!empty($user->image_file))
			$imgurl = Yii::app()->createAbsoluteUrl('user/download',array('file'=>$user->image_file));
		else
			$imgurl = Yii::app()->createAbsoluteUrl('user/download',array('file'=>'user.png'));	
		  
		$current_address = $user->userAddress($user->work_lat, $user->work_long,$i);			
		$address = '<div><img src="'.$imgurl.'" width="10%" height="10%">'. $user->full_name.'<br>'.$current_address.'</div>';	
		$gMap->setCenter($user->work_lat, $user->work_long); 
		$info_window = new EGMapInfoWindow($address); 
		$user_marker = Yii::app()->theme->baseUrl.'/images/user_marker.png';
		//$icon = new EGMapMarkerImage("http://google-maps-icons.googlecode.com/files/gazstation.png");
		$icon = new EGMapMarkerImage($user_marker);
		
		$marker = new EGMapMarker($user->work_lat, $user->work_long, array('title' => '','icon'=>$icon));
		$marker->addHtmlInfoWindow($info_window);
		$gMap->addMarker($marker);
	$i++;
	}
	 	
	$gMap->renderMap();
?>
</div>
<?php $this->StartPanel(); ?>
<?php $this->AddPanel($model->getRelationLabel('Reports'),$model->getRelatedDataProvider('posts'),'posts','post');?>
<?php $this->EndPanel(); ?>
