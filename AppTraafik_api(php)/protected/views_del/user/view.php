<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);


?>

<div class="page-header">
<?php 
if(empty($model->image_file))
$url = Yii::app()->createAbsoluteUrl('user/download',array('file'=>$model->image_file));
else 
$url = Yii::app()->createAbsoluteUrl('user/download',array('file'=>'user.png'));

echo CHtml::image($url,'no image',array('style'=>'width:16%'));

?>
<h1><?php echo GxHtml::encode(GxHtml::valueEx($model)); ?></h1>
</div>

<?php   $this->widget('bootstrap.widgets.TbButtonGroup', array(
	'buttons'=>$this->actions,
	'type'=>'success',
	'htmlOptions'=>array('class'=> 'pull-right'),
	));
?>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
'id',
'full_name',
'email',
			'gender',
			'mobile',
'date_of_birth',
//'about_me:html',
//'image_file',
'role_id',
/*array(
				'name' => 'state_id',
				'type' => 'raw',
				'value'=>$model->getStatusOptions($model->state_id),
				),
array(
				'name' => 'type_id',
				'type' => 'raw',
				'value'=>$model->getTypeOptions($model->type_id),
				),*/
//'last_visit_time',
//'last_action_time',
//'last_password_change',
//'login_error_count',
'create_time',
	),
)); ?>

<?php
/* $this->StartPanel(); ?>
<?php  $this->AddPanel($model->getRelationLabel('authSessions'), $model->getRelatedDataProvider('authSessions'),	'authSessions','authSession');?>
<?php  $this->AddPanel($model->getRelationLabel('posts'), $model->getRelatedDataProvider('posts'),	'posts','post');?>
<?php  $this->EndPanel(); ?>

<?php   $this->widget('CommentPortlet', array(
	'model' => $model,
));*/
?>