<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::encode($data->id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('report_id')); ?>:
	<?php echo GxHtml::encode($data->report_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('report_cause_id')); ?>:
	<?php echo GxHtml::encode($data->report_cause_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('side_id')); ?>:
	<?php echo GxHtml::encode($data->side_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('content')); ?>:
	<?php echo GxHtml::encode($data->content); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('file_path')); ?>:
	<?php echo GxHtml::encode($data->file_path); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('file_ext_type')); ?>:
	<?php echo GxHtml::encode($data->file_ext_type); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('latitude')); ?>:
	<?php echo GxHtml::encode($data->latitude); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('longitude')); ?>:
	<?php echo GxHtml::encode($data->longitude); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('note_send_time')); ?>:
	<?php echo GxHtml::encode($data->note_send_time); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('state_id')); ?>:
	<?php echo GxHtml::encode($data->state_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('type_id')); ?>:
	<?php echo GxHtml::encode($data->type_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('expiry_duration')); ?>:
	<?php echo GxHtml::encode($data->expiry_duration); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('create_user_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->createUser)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('create_time')); ?>:
	<?php echo GxHtml::encode($data->create_time); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('update_time')); ?>:
	<?php echo GxHtml::encode($data->update_time); ?>
	<br />
	*/ ?>

</div>