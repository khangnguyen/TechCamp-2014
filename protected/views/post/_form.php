<?php
/* @var $this PostController */
/* @var $model Post */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'post-form',
	'enableAjaxValidation'=>false,
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
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'slide_url'); ?>
		<?php echo $form->textField($model,'slide_url',array('size'=>60)); ?>
		<?php echo $form->error($model,'slide_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'speaker_name'); ?>
		<?php echo $form->textField($model,'speaker_name',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'speaker_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'speaker_description'); ?>
		<?php echo $form->textArea($model,'speaker_description',array('rows'=>6, 'cols'=>50)); ?>
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