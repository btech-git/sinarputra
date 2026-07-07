<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'customer-form',
        'enableAjaxValidation' => false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'customer_type'); ?>
        <?php echo $form->dropDownList($model, 'customer_type', array(Customer::TRADER_VALUE => 'Trader', Customer::USER_VALUE => 'User')); ?>
        <?php echo $form->error($model, 'customer_type'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'code'); ?>
        <?php echo $form->textField($model, 'code', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'code'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'company'); ?>
        <?php echo $form->textField($model, 'company', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model, 'company'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'Alamat Pusat'); ?>
        <?php echo $form->textArea($model, 'address_main', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'address_main'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'Alamat Kirim'); ?>
        <?php echo $form->textArea($model, 'address_secondary', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'address_secondary'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'city'); ?>
        <?php echo $form->textField($model, 'city', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model, 'city'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'province'); ?>
        <?php echo $form->textField($model, 'province', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model, 'province'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'Area'); ?>
        <?php echo $form->dropDownList($model, 'customer_area_id', CHtml::listData(CustomerArea::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-Select Area-')); ?>
        <?php echo $form->error($model, 'customer_area_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'phone'); ?>
        <?php echo $form->textField($model, 'phone', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'phone'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'fax'); ?>
        <?php echo $form->textField($model, 'fax', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'fax'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'note'); ?>
        <?php echo $form->textArea($model, 'note', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'note'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'invoice_due_days'); ?>
        <?php echo $form->textField($model, 'invoice_due_days'); ?>
        <?php echo $form->error($model, 'invoice_due_days'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'available_credit'); ?>
        <?php echo $form->textField($model, 'available_credit', array('size' => 18, 'maxlength' => 18)); ?>
        <?php echo $form->error($model, 'available_credit'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'discount_default'); ?>
        <?php echo $form->textField($model, 'discount_default', array('size' => 10, 'maxlength' => 10)); ?>
        <?php echo $form->error($model, 'discount_default'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'Salesman'); ?>
        <?php echo $form->dropDownList($model, 'employee_id', CHtml::listData(Employee::model()->findAll(array('condition' => 'department_id = 2', 'order' => 'name ASC')), 'id', 'name'), array('empty' => '-Select Employee-')); ?>
        <?php echo $form->error($model, 'employee_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'PPn / Non?'); ?>
        <?php echo $form->dropDownList($model, 'is_tax', array(
            Customer::TAX_VALUE => Customer::TAX_LITERAL,
            Customer::NON_TAX_VALUE => Customer::NON_TAX_LITERAL
        )); ?>
        <?php echo $form->error($model, 'is_tax'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'tax_name'); ?>
        <?php echo $form->textField($model, 'tax_name', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model, 'tax_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'NPWP'); ?>
        <?php echo $form->textField($model, 'tax_registration_number', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'tax_registration_number'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'Alamat NPWP'); ?>
        <?php echo $form->textArea($model, 'tax_address_main', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'tax_address_main'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'Alamat NPWP 2'); ?>
        <?php echo $form->textArea($model, 'tax_address_secondary', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'tax_address_secondary'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'Butuh BTB?'); ?>
        <?php echo $form->dropDownList($model, 'is_delivery_approval_needed', array(
            0 => 'Tidak',
            1 => 'Perlu'
        )); ?>
        <?php echo $form->error($model, 'is_delivery_approval_needed'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'credit_limit'); ?>
        <?php echo $form->textField($model, 'credit_limit', array('size' => 18, 'maxlength' => 18)); ?>
        <?php echo $form->error($model, 'credit_limit'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'Akun Piutang'); ?>
        <?php echo $form->dropDownList($model, 'account_id_receivable', CHtml::listData(Account::model()->findAll(array('condition' => 'account_category_id = 3', 'order' => 'name ASC')), 'id', 'name'), array('empty' => '-Select Akun Piutang-')); ?>
        <?php echo $form->error($model, 'account_id_receivable'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'is_inactive'); ?>
        <?php echo $form->dropDownList($model, 'is_inactive', array(
            ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL,
            ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL
        )); ?>
        <?php echo $form->error($model, 'is_inactive'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php echo IdempotentManager::generate(); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->
