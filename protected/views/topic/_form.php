<?php
/* @var $this TopicController */
/* @var $model Topic */
/* @var $form CActiveForm */
?>

<div class="form" style="margin: 20px">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'topic-form',
	'enableClientValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>60)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'slide_url'); ?>
		<?php echo $form->textField($model,'slide_url',array('size'=>60)); ?>
		<?php echo $form->error($model,'slide_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'language'); ?>
		<?php echo $form->dropDownList($model, 'language', array(
                    'Vietnamese' => 'Vietnamese',
                    'English' => 'English',
                    'Other' => 'Other'));
                ?>
		<?php echo $form->error($model,'language'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'duration'); ?>
		<?php echo $form->dropDownList($model, 'duration', array(
                    '5' => '5 minutes',
                    '15' => '15 minutes',
                    '30' => '30 minutes',
                    '45' => '45 minutes',
                    '60' => '60 minutes')); 
                ?>
		<?php echo $form->error($model,'duration'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'desired_time'); ?>
		<?php echo $form->dropDownList($model, 'desired_time', array(
                    'Morning' => 'Morning',
                    'Early Afternoon' => 'Early Afternoon',
                    'Late Afternoon' => 'Late Afternoon'));
                ?>
		<?php echo $form->error($model,'desired_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'speaker_name'); ?>
		<?php echo $form->textField($model,'speaker_name',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'speaker_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'speaker_description'); ?>
		<?php echo $form->textArea($model,'speaker_description',array('rows'=>6, 'cols'=>60)); ?>
		<?php echo $form->error($model,'speaker_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'speaker_url'); ?>
		<?php echo $form->textField($model,'speaker_url',array('size'=>60)); ?>
		<?php echo $form->error($model,'speaker_url'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->