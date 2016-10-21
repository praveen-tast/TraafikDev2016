
	<?php foreach($this->getRecentComments() as $data){?>
	<div class="well">
	<?php
	$user = $data->createUser;
	$userimage = 'default_user.jpg';?>
	<?php
	$this->beginWidget('CMarkdown', array('purifyOutput'=>true));

	if(!empty($user->image_file))
	{
		$userimage = $user->image_file;
		if($userimage)

			echo CHtml::image(Yii::app()->createUrl('user/thumbnail', array ('file'=> $userimage)), $user->full_name,array('style'=>'width:40px;height:30px;','class'=>'imgleft'));

	}
	else {

		echo CHtml::image(Yii::app()->createUrl('site/thumbnail', array ('file'=> $userimage)), $user->full_name,array('style'=>'width:50px;'));
	}

	echo $data->purifyHtml($data->comment);
	$this->endWidget();
	?>



	<small> <b><?php echo $data->createUser->linkify(); ?> </b> <?php echo ' on date' ?>:
		<?php echo GxHtml::encode($data->create_time); ?> <?php if ($data->create_user_id == Yii::app()->user->id)

			echo CHtml::link('Update', $data->getUrl('update'), array('class'=>'btn btn-mini btn-info pull-right','icon'=>'align-left'));

		?> <?php if ($data->isDeleteAllow() )  echo CHtml::link('Delete','#',
				array('class'=>'btn btn-mini btn-warning pull-right',
		 'submit' => $data->getUrl('delete'),
					'confirm'=>'Are you sure you want to delete this item?')
		 );
			
			
		?>
	</small>

</div>

	<?php } ?>
	<div id="dialog"></div>



<div class="form">

	<?php 	
	$comment =  new Comment();
	$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'id' => 'comment-form',
	//	'type'=>'horizontal',
	//	'enableAjaxValidation' => true,
 	//	'enableClientValidation' => true,
		//'clientOptions' => array('validateOnSubmit'=>true),
		//'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
?>
	<?php echo $form->errorSummary($comment); ?>

	<?php 

	$user = User::model()->findByPk(Yii::app()->user->id);
	$userimage = 'default_user.jpg';
	if(!empty($user->image_file))
	{
		$userimage = $user->image_file;
		if(Yii::app()->user->id == $user->id)

			echo CHtml::image(Yii::app()->createUrl('user/thumbnail', array ('file'=> $userimage)), $user->full_name,array('style'=>'width:50px;'));

	}
	else {

            	echo CHtml::image(Yii::app()->createUrl('site/thumbnail', array ('file'=> $userimage)),$user->full_name,array('style'=>'width:50px;'));

}
?>
	<?php $code = 0 ;

	if ($code == 1) echo $form->html5EditorRow($comment,'comment', array('class'=>'span4', 'rows'=>5, 'height'=>'100', 'width'=>'100%', 'options'=>array('color'=>true)));

	else if ($code == 2) echo $form->redactorRow($comment,'comment', array('class'=>'span4', 'rows'=>5));

	else if ($code == 3) echo $form->ckEditorRow($comment,'comment', array('options'=>array('fullpage'=>'js:true', 'width'=>'640', 'resize_maxWidth'=>'640','resize_minWidth'=>'320')));

	echo $form->textField($comment,'comment',  array('class'=>'span5','placeHolder'=>'Write your comment here'));
	?>
	<div class="clr"></div>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'buttonType'=>'submit',
			'type'=>'success',
			'size' => 'mini',
			'label'=>'Add Comment',
		)); ?>

</div>
<?php $this->endWidget(); ?>
<!-- form -->
