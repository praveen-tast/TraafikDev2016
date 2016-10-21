<?php 
$this->widget('bootstrap.widgets.TbBox', array(
		'title' => 'Dear ' .$model->full_name. '  '.' Are You Sure to delete your account  ?',
		'headerIcon' => 'icon-remove',
		'content' => $this->renderPartial('_exit',array('model'=>$model),true)
));
?>
