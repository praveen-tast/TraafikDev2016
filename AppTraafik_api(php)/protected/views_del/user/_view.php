<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::encode($data->id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('full_name')); ?>:
	<?php echo GxHtml::encode($data->full_name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('email')); ?>:
	<?php echo GxHtml::encode($data->email); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('password')); ?>:
	<?php echo GxHtml::encode($data->password); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('date_of_birth')); ?>:
	<?php echo GxHtml::encode($data->date_of_birth); ?>
	<br />
	<?php //echo GxHtml::encode($data->getAttributeLabel('about_me')); ?>:
	<?php //echo GxHtml::encode($data->about_me); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('image_file')); ?>:
	<?php echo GxHtml::encode($data->image_file); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('role_id')); ?>:
	<?php echo GxHtml::encode($data->role_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('state_id')); ?>:
	<?php echo GxHtml::encode($data->state_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('type_id')); ?>:
	<?php echo GxHtml::encode($data->type_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('last_visit_time')); ?>:
	<?php echo GxHtml::encode($data->last_visit_time); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('last_action_time')); ?>:
	<?php echo GxHtml::encode($data->last_action_time); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('last_password_change')); ?>:
	<?php echo GxHtml::encode($data->last_password_change); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('activation_key')); ?>:
	<?php echo GxHtml::encode($data->activation_key); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('login_error_count')); ?>:
	<?php echo GxHtml::encode($data->login_error_count); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('create_time')); ?>:
	<?php echo GxHtml::encode($data->create_time); ?>
	<br />
	*/ ?>

</div>