<article class="leftside">
	<h3>Forgot password ?</h3>
	<article class="login_hding">
		<div class="or_brder"></div>
       <article class="pull-left">
			<h1>
				<?php echo Yii::t('app', 'Recover Your Account') ; ?>
			</h1>
			<?php if(Yii::app()->user->hasFlash('recover')): ?>
			<div class = "alert alert-info">
				<div class="flash-success">
					<?php echo Yii::app()->user->getFlash('recover'); ?>
				</div>
			</div>
			<?php else :?>	
				<!-- form -----------------START-->
				<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
						'id' => 'recover-form',
						'type'=>'horizontal',
						'action' => Yii::app()->createUrl('api/user/recover'),
						'enableClientValidation'=>true,
						'clientOptions'=>array('validateOnSubmit'=>true),
				));
				?>
					<p class="note">Please enter following details:</p>
					<?php //echo $form->errorSummary($model); ?>
					<?php echo $form->textFieldRow($model,'email',array('maxlength'=>256)); ?>
				
					<br>
			        <button class="btn-primary pull-left" type="Submit">Submit</button>
			    	<div class="gap"></div>
				<?php $this->endWidget(); ?>
				<!-- form -----------------END-->
			<?php endif;?>
		</article>
	</article>
</article>