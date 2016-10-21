
<div class="login">

	<div class="auth-form-header">Login</div>
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id' => 'login-form',
			'enableClientValidation'=>true,
		//'action'=>$this->createUrl('api/user/login'),
			'focus'=>array($model,'username'),
			'clientOptions'=>array(
			'validateOnSubmit'=>true,

			)));
	?>
	<div class="auth-form-body">

		<?php echo $form->errorSummary($model); ?>
		<?php if(isset($_GET['action'])) echo CHtml::hiddenField('returnUrl',
			urldecode($_GET['action'])); ?>

		<div class="row-fluid">
			<?php
			echo $form->textField($model,'username',array('maxlength'=>128,'placeholder'=>'Email','class'=>'input-xlarge span12'));
			?>
		</div>
		<div class="row-fluid">
			<?php echo $form->passwordField($model,'password',array('maxlength'=>512,'placeholder'=>'Password','class'=>'input-xlarge span12')); ?>
		</div>
		
		
		<div class="row-fluid">
			<div class="pull-left"><?php echo $form->checkBoxRow($model,'rememberMe',array('style'=>'')); ?></div>
            <div class="frgt-pswrd pull-right"><p><?php echo CHtml::link('Forgot Password?',$this->createUrl('user/recover'),array('style'=>'')); ?></p>
            </div>
            </div>
            
            
		<div class="form-actions ">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Login',
		)); ?>


			<br> <br>
			
		</div>
	</div>


	<?php $this->endWidget(); ?>

</div>
