<?php
Yii::app()->clientScript->registerScript('userRoles', "
	function checkRoles(number, start, end)
	{
		if ($('#".CHtml::activeId($model, 'roles')."_' + number).prop('checked') || $('#".CHtml::activeId($model, 'roles')."_' + number).prop('disabled'))
		{
			for (i = start; i <= end; i++)
			{
				$('#".CHtml::activeId($model, 'roles')."_' + i).removeAttr('checked');
				$('#".CHtml::activeId($model, 'roles')."_' + i).attr('disabled', true);
			}
		}
		else
		{
			for (i = start; i <= end; i++)
			{
				$('#".CHtml::activeId($model, 'roles')."_' + i).removeAttr('disabled');
			}
		}
        console.log($('#" . CHtml::activeId($model, 'roles') . "_' + number).attr('checked'));
	}

	$(document).ready(function(){
		checkRoles(0, 1, 101);
		checkRoles(1, 8, 22);
		checkRoles(2, 23, 31);
		checkRoles(3, 32, 41);
		checkRoles(4, 42, 59);
		checkRoles(5, 60, 80);
		checkRoles(6, 81, 89);
		checkRoles(7, 90, 101);
	});

	$('#".CHtml::activeId($model, 'roles')."_0').click(function(){
		checkRoles(0, 1, 101);
	});

	$('#".CHtml::activeId($model, 'roles')."_1').click(function(){
		checkRoles(1, 8, 22);
	})

	$('#".CHtml::activeId($model, 'roles')."_2').click(function(){
		checkRoles(2, 23, 31);
	});

	$('#".CHtml::activeId($model, 'roles')."_3').click(function(){
		checkRoles(3, 32, 41);
	});

	$('#".CHtml::activeId($model, 'roles')."_4').click(function(){
		checkRoles(4, 42, 59);
	});

	$('#".CHtml::activeId($model, 'roles')."_5').click(function(){
		checkRoles(5, 60, 80);
	});
	
	$('#".CHtml::activeId($model, 'roles')."_6').click(function(){
		checkRoles(6, 81, 89);
	});
	
	$('#".CHtml::activeId($model, 'roles')."_7').click(function(){
		checkRoles(7, 90, 101);
	});
	
");
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id'=>'admin-form',
        'enableAjaxValidation'=>false,
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        ),
    )); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

     <?php if ($model->isNewRecord): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'username'); ?>
            <?php echo $form->textField($model, 'username', array('size' => 60, 'maxlength' => 60)); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>

        <div class="row">
            <?php echo CHtml::activeLabelEx($model, 'new_password'); ?>
            <?php echo CHtml::activePasswordField($model, 'new_password', array('size' => 32, 'maxlength' => 32)); ?>
            <?php echo CHtml::error($model, 'new_password'); ?>
        </div>

        <div class="row">
            <?php echo CHtml::activeLabelEx($model, 'confirm_password'); ?>
            <?php echo CHtml::activePasswordField($model, 'confirm_password', array('size' => 32, 'maxlength' => 32)); ?>
            <?php echo CHtml::error($model, 'confirm_password'); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'employee_id'); ?>
        <?php echo $form->dropDownList($model, 'employee_id', CHtml::listData(Employee::model()->findAll(array('order' => 'name ASC')), 'id', 'name')); ?>
        <?php echo $form->error($model, 'employee_id'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('size'=>60, 'maxlength'=>60)); ?>
		<?php echo $form->error($model, 'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'address'); ?>
		<?php echo $form->textArea($model, 'address', array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model, 'address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'phone'); ?>
		<?php echo $form->textField($model, 'phone', array('size'=>60, 'maxlength'=>60)); ?>
		<?php echo $form->error($model, 'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'cell_phone'); ?>
		<?php echo $form->textField($model, 'cell_phone', array('size'=>60, 'maxlength'=>60)); ?>
		<?php echo $form->error($model, 'cell_phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'email'); ?>
		<?php echo $form->textField($model, 'email', array('size'=>60, 'maxlength'=>60)); ?>
		<?php echo $form->error($model, 'email'); ?>
	</div>
       
    <?php if ($model->isNewRecord): ?>
        <div class="formLabel"><?php echo CHtml::label('New Signature: ', FALSE); ?></div>
    <?php else: ?>
        <div class="formLabel"><?php echo CHtml::label('Signature: ', FALSE) . $model->file_extension_signature; ?></div>
    <?php endif; ?> 
        <div class="formInput"><?php echo CHtml::fileField('file_signature'); ?></div>
        <div class="formError"><?php echo CHtml::error($model, 'file_signature'); ?></div>
        
    <div class="row">
        <fieldset style="width: 100%">
            <legend><span style="font-weight: bold">Roles</span></legend>
            <?php $this->renderPartial('_role', array('model' => $model, 'counter' => 0)); ?>
        </fieldset>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model, 'is_inactive'); ?>
		<?php echo $form->dropDownList($model,'is_inactive', array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive')); ?>
		<?php echo $form->error($model, 'is_inactive'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->