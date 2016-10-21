<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model) => array('view', 'id' => GxActiveRecord::extractPkValue($model, true)),
	Yii::t('app', 'Update'),
);
?>

<div class="page-header">
<?php 
if(!empty($model->image_file))
$url = Yii::app()->createAbsoluteUrl('user/download',array('file'=>$model->image_file));
else 
$url = Yii::app()->createAbsoluteUrl('user/download',array('file'=>'user.png'));

echo CHtml::image($url,'no image',array('style'=>'width:16%'));

?>
<h1><?php echo Yii::t('app', 'Update') . ' ' . GxHtml::encode($model->label()) . ' : ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>
	<?php   $this->widget('bootstrap.widgets.TbButtonGroup', array(
	'buttons'=>$this->actions,
	'type'=>'success',
	'htmlOptions'=>array('class'=> 'pull-right'),
	));
?>
</div>

<?php
$this->renderPartial('_form', array(
		'model' => $model));
?>