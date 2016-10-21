<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::encode($data->id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('content')); ?>:
	<?php echo GxHtml::encode($data->content); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('to_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->to)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('from_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->from)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('file_path')); ?>:
	<?php echo GxHtml::encode($data->file_path); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('file_type')); ?>:
	<?php echo GxHtml::encode($data->file_type); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('group_id')); ?>:
	<?php echo GxHtml::encode($data->group_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('session_id')); ?>:
	<?php echo GxHtml::encode($data->session_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('latitude')); ?>:
	<?php echo GxHtml::encode($data->latitude); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('longitude')); ?>:
	<?php echo GxHtml::encode($data->longitude); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('type_id')); ?>:
	<?php echo GxHtml::encode($data->type_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('state_id')); ?>:
	<?php echo GxHtml::encode($data->state_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('received_time')); ?>:
	<?php echo GxHtml::encode($data->received_time); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('create_time')); ?>:
	<?php echo GxHtml::encode($data->create_time); ?>
	<br />
	*/ ?>

</div>