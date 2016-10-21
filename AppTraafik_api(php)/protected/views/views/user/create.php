<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Create'),
);
?>
<div class="page-header">
<h1><?php echo Yii::t('app', 'Create') . ' ' . GxHtml::encode($model->label()); ?></h1>
</div>
<?php
$this->renderPartial('_form', array(
		'model' => $model,
		'buttons' => 'create'));
?>