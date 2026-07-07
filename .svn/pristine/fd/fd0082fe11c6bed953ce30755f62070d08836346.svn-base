<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'product-size-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'product_id'); ?>
		<?php echo $form->dropDownList($model, 'product_id', 
			CHtml::listData(Product::model()->findAll(), 'id', 'name'),
			array(
				'empty' => '-Select Product-'
			)); ?>
		<?php echo $form->error($model, 'product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'product_code'); ?>
		<?php echo $form->textField($model, 'product_code', array('size'=>10, 'maxlength'=>20)); ?>
		<?php echo $form->error($model, 'product_code'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'width'); ?>
		<?php echo $form->textField($model, 'width', array('size'=>10, 'maxlength'=>10)); ?>
		<?php echo $form->error($model, 'width'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'height'); ?>
		<?php echo $form->textField($model, 'height', array('size'=>10, 'maxlength'=>10)); ?>
		<?php echo $form->error($model, 'height'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'is_inactive'); ?>
		<?php echo $form->dropDownList($model, 'is_inactive', array(
			0 => 'Active',
			1 => 'Inactive'
		)); ?>
		<?php echo $form->error($model, 'is_inactive'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->