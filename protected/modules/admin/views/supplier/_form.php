<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'supplier-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        
        <div class="row">
		<?php echo $form->labelEx($model, 'code'); ?>
		<?php echo $form->textField($model, 'code', array('size'=>20, 'maxlength'=>20)); ?>
		<?php echo $form->error($model, 'code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('size'=>60, 'maxlength'=>60)); ?>
		<?php echo $form->error($model, 'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'company'); ?>
		<?php echo $form->textField($model, 'company', array('size'=>60, 'maxlength'=>60)); ?>
		<?php echo $form->error($model, 'company'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'address_main'); ?>
		<?php echo $form->textArea($model, 'address_main', array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model, 'address_main'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'address_secondary'); ?>
		<?php echo $form->textArea($model, 'address_secondary', array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model, 'address_secondary'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'city'); ?>
		<?php echo $form->textField($model, 'city', array('size'=>60, 'maxlength'=>60)); ?>
		<?php echo $form->error($model, 'city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'province'); ?>
		<?php echo $form->textField($model, 'province', array('size'=>60, 'maxlength'=>60)); ?>
		<?php echo $form->error($model, 'province'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'phone'); ?>
		<?php echo $form->textField($model, 'phone', array('size'=>60, 'maxlength'=>60)); ?>
		<?php echo $form->error($model, 'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'fax'); ?>
		<?php echo $form->textField($model, 'fax', array('size'=>60, 'maxlength'=>60)); ?>
		<?php echo $form->error($model, 'fax'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'email'); ?>
		<?php echo $form->textField($model, 'email', array('size'=>60, 'maxlength'=>60)); ?>
		<?php echo $form->error($model, 'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'N P W P'); ?>
		<?php echo $form->textField($model, 'tax_registration_number', array('size'=>20, 'maxlength'=>20)); ?>
		<?php echo $form->error($model, 'tax_registration_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'bank_account'); ?>
		<?php echo $form->textField($model, 'bank_account', array('size'=>60, 'maxlength'=>60)); ?>
		<?php echo $form->error($model, 'bank_account'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'invoice_due_days'); ?>
		<?php echo $form->textField($model, 'invoice_due_days'); ?>
		<?php echo $form->error($model, 'invoice_due_days'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'note'); ?>
		<?php echo $form->textArea($model, 'note', array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model, 'note'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'available_credit'); ?>
		<?php echo $form->textField($model, 'available_credit', array('size'=>18, 'maxlength'=>18)); ?>
		<?php echo $form->error($model, 'available_credit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'credit_limit'); ?>
		<?php echo $form->textField($model, 'credit_limit', array('size'=>18, 'maxlength'=>18)); ?>
		<?php echo $form->error($model, 'credit_limit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'term_of_payment'); ?>
		<?php echo $form->textField($model, 'term_of_payment', array('size'=>18, 'maxlength'=>6)); ?>
		<?php echo $form->error($model, 'term_of_payment'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'is_tax'); ?>
		<?php echo $form->dropDownList($model,'is_tax', array(
            Supplier::NO_TAX => Supplier::NO_TAX_LITERAL, 
            Supplier::FULL_TAX => Supplier::FULL_TAX_LITERAL,
        )); ?>
		<?php echo $form->error($model, 'is_tax'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'tax_registration_number'); ?>
		<?php echo $form->textField($model, 'tax_registration_number', array('size'=>20, 'maxlength'=>20)); ?>
		<?php echo $form->error($model, 'tax_registration_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'Akun Hutang'); ?>
		<?php echo $form->dropDownList($model, 'account_id_payable', 
			CHtml::listData(Account::model()->findAll(array('condition' => 'account_category_id = 24', 'order' => 'name ASC')), 'id', 'name'),
			array('empty' => '-Select Akun Hutang-')); ?>
		<?php echo $form->error($model, 'account_id_payable'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'is_inactive'); ?>
		<?php echo $form->dropDownList($model,'is_tax', array(
            ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL, 
            ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL,
        )); ?>
		<?php echo $form->error($model, 'is_inactive'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
