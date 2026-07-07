<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'delivery-vehicle-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'description'); ?>
		<?php echo $form->textField($model, 'description', array('size'=>60, 'maxlength'=>255)); ?>
		<?php echo $form->error($model, 'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'plate_number'); ?>
		<?php echo $form->textField($model, 'plate_number', array('size'=>20, 'maxlength'=>20)); ?>
		<?php echo $form->error($model, 'plate_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'is_inactive'); ?>
		<?php echo $form->textField($model, 'is_inactive'); ?>
		<?php echo $form->error($model, 'is_inactive'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->