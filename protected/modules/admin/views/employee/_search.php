<div class="wide form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'id'); ?>
		<?php echo $form->textField($model, 'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('size'=>60, 'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'job_title'); ?>
		<?php echo $form->textField($model, 'job_title', array('size'=>60, 'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'job_level'); ?>
		<?php echo $form->textField($model, 'job_level', array('size'=>60, 'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'startDate'); ?>
		<?php echo $form->textField($model, 'startDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'company'); ?>
		<?php echo $form->textField($model, 'company', array('size'=>60, 'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'cost_center'); ?>
		<?php echo $form->textField($model, 'cost_center', array('size'=>60, 'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'birth'); ?>
		<?php echo $form->textField($model, 'birth'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'height'); ?>
		<?php echo $form->textField($model, 'height', array('size'=>10, 'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'weight'); ?>
		<?php echo $form->textField($model, 'weight', array('size'=>10, 'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'residential_address'); ?>
		<?php echo $form->textArea($model, 'residential_address', array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'original_address'); ?>
		<?php echo $form->textArea($model, 'original_address', array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'phone'); ?>
		<?php echo $form->textField($model, 'phone', array('size'=>20, 'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'email'); ?>
		<?php echo $form->textField($model, 'email', array('size'=>20, 'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'identity_number'); ?>
		<?php echo $form->textField($model, 'identity_number', array('size'=>30, 'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'identity_expired'); ?>
		<?php echo $form->textField($model, 'identity_expired'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'driver_license_number'); ?>
		<?php echo $form->textField($model, 'driver_license_number', array('size'=>30, 'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'driver_license_expired'); ?>
		<?php echo $form->textField($model, 'driver_license_expired'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'healt_insurance_number'); ?>
		<?php echo $form->textField($model, 'healt_insurance_number', array('size'=>30, 'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'employment_insurance_number'); ?>
		<?php echo $form->textField($model, 'employment_insurance_number', array('size'=>30, 'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'personal_tax'); ?>
		<?php echo $form->textArea($model, 'personal_tax', array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'bank_name'); ?>
		<?php echo $form->textField($model, 'bank_name', array('size'=>30, 'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'bank_account'); ?>
		<?php echo $form->textField($model, 'bank_account', array('size'=>30, 'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'file_extension'); ?>
		<?php echo $form->textField($model, 'file_extension', array('size'=>10, 'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'employee_category_id'); ?>
		<?php echo $form->textField($model, 'employee_category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'employment_type_id'); ?>
		<?php echo $form->textField($model, 'employment_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'ethnic_group_id'); ?>
		<?php echo $form->textField($model, 'ethnic_group_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'religion_id'); ?>
		<?php echo $form->textField($model, 'religion_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'blood_type_id'); ?>
		<?php echo $form->textField($model, 'blood_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'is_female'); ?>
		<?php echo $form->textField($model, 'is_female'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'is_married'); ?>
		<?php echo $form->textField($model, 'is_married'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'is_inactive'); ?>
		<?php echo $form->textField($model, 'is_inactive'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->