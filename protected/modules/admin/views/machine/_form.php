<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'machine-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'machine_type_id'); ?>
        <?php echo $form->dropDownList($model, 'machine_type_id', CHtml::listData(MachineType::model()->findAll(), 'id', 'name'), array('empty' => '-Select Type-')); ?>
        <?php echo $form->error($model, 'machine_type_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'serial_number'); ?>
        <?php echo $form->textField($model, 'serial_number', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model, 'serial_number'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'grade_classification'); ?>
        <?php echo $form->textField($model, 'grade_classification', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'grade_classification'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'cutting_capacity'); ?>
        <?php echo $form->textField($model, 'cutting_capacity', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'cutting_capacity'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'purchase_year'); ?>
        <?php echo $form->textField($model, 'purchase_year', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'purchase_year'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'position'); ?>
        <?php echo $form->textField($model, 'position', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'position'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'blade_size'); ?>
        <?php echo $form->textField($model, 'blade_size', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'blade_size'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'cutting_speed'); ?>
        <?php echo $form->textField($model, 'cutting_speed', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'cutting_speed'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'hydrolic_oil_capacity'); ?>
        <?php echo $form->textField($model, 'hydrolic_oil_capacity', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model, 'hydrolic_oil_capacity'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'cutting_oil_capacity'); ?>
        <?php echo $form->textField($model, 'cutting_oil_capacity', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model, 'cutting_oil_capacity'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'cutting_table_height'); ?>
        <?php echo $form->textField($model, 'cutting_table_height', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model, 'cutting_table_height'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'net_weight'); ?>
        <?php echo $form->textField($model, 'net_weight'); ?>
        <?php echo $form->error($model, 'net_weight'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'machine_size'); ?>
        <?php echo $form->textField($model, 'machine_size', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'machine_size'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'milling_max_capacity'); ?>
        <?php echo $form->textField($model, 'milling_max_capacity', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'milling_max_capacity'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'milling_min_capacity'); ?>
        <?php echo $form->textField($model, 'milling_min_capacity', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'milling_min_capacity'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'is_inactive', array(
            ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL,
            ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL)
        ); ?>
<?php echo $form->error($model, 'is_inactive'); ?>
    </div>

    <div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->