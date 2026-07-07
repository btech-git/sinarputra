<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'material-form',
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
        <?php echo $form->textField($model, 'name', array('size'=>60, 'maxlength'=>100)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'weight'); ?>
        <?php echo $form->textField($model, 'weight', array('size'=>10, 'maxlength'=>10)); ?>
        <?php echo $form->error($model, 'weight'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'unit_price'); ?>
        <?php echo $form->textField($model, 'unit_price', array('size'=>18, 'maxlength'=>18)); ?>
        <?php echo $form->error($model, 'unit_price'); ?>
    </div>

    <div class="row">
            <?php echo $form->labelEx($model, 'is_inactive'); ?>
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