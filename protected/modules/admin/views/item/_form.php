<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'item-form',
	'enableAjaxValidation'=>false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'code'); ?>
        <?php echo $form->textField($model, 'code', array('size'=>60, 'maxlength'=>60)); ?>
        <?php echo $form->error($model, 'code'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size'=>60, 'maxlength'=>60)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php echo $form->textField($model, 'description', array('size'=>60, 'maxlength'=>100)); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'item_category_id'); ?>
        <?php echo $form->dropDownList($model, 'item_category_id', CHtml::listData(ItemCategory::model()->findAll(), 'id', 'name'), array('empty' => '-Select Category-')); ?>
        <?php echo $form->error($model, 'item_category_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'Satuan'); ?>
        <?php echo $form->dropDownList($model, 'unit_id', CHtml::listData(Unit::model()->findAll(), 'id', 'name'), array('empty' => '-Select Unit-')); ?>
        <?php echo $form->error($model, 'unit_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'COA Beban'); ?>
        <?php echo $form->dropDownList($model, 'account_id_expense', CHtml::listData(Account::model()->findAll(), 'id', 'name'), array('empty' => '-Select COA Beban-')); ?>
        <?php echo $form->error($model, 'account_id_expense'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'COA Inventory'); ?>
        <?php echo $form->dropDownList($model, 'account_id_inventory', CHtml::listData(Account::model()->findAll(), 'id', 'name'), array('empty' => '-Select COA Inventory-')); ?>
        <?php echo $form->error($model, 'account_id_inventory'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'Status'); ?>
        <?php echo $form->dropDownList($model,'is_inactive', array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive')); ?>
        <?php echo $form->error($model, 'is_inactive'); ?>
    </div>

    <div class="row buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->