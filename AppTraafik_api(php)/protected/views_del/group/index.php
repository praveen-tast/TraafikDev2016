<?php

$this->breadcrumbs = array(
	Group::label(2),
	Yii::t('app', 'Index'),
);
?>

<div class="page-header">
<h1><?php echo GxHtml::encode(Group::label(2)); ?></h1>
</div>

<?php 


$this->renderPartial('_list', array(
		'dataProvider'=>$dataProvider,
));

