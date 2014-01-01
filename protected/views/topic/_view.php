<?php
/* @var $this TopicController */
/* @var $data Topic */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('slide_url')); ?>:</b>
	<?php echo CHtml::encode($data->slide_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('speaker_name')); ?>:</b>
	<?php echo CHtml::encode($data->speaker_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('speaker_description')); ?>:</b>
	<?php echo CHtml::encode($data->speaker_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('speaker_url')); ?>:</b>
	<?php echo CHtml::encode($data->speaker_url); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	*/ ?>

</div>