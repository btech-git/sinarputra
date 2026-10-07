<?php
Yii::app()->clientScript->registerScript('userRoles', "
    function checkRoles(number, start, end) {
        if ($('#" . CHtml::activeId($model, 'roles') . "_' + number).prop('checked') || $('#" . CHtml::activeId($model, 'roles') . "_' + number).prop('disabled')) {
            for (i = start; i <= end; i++) {
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).removeAttr('checked');
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).attr('disabled', true);
            }
        } else {
            for (i = start; i <= end; i++) {
                $('#" . CHtml::activeId($model, 'roles') . "_' + i).removeAttr('disabled');
            }
        }
        
        console.log($('#" . CHtml::activeId($model, 'roles') . "_' + number).attr('checked'));
    }

    $(document).ready(function(){
        checkRoles(0, 1, 162);
        checkRoles(1, 10, 16);
        checkRoles(2, 17, 26);
        checkRoles(3, 27, 44);
        checkRoles(4, 45, 53);
        checkRoles(5, 54, 63);
        checkRoles(6, 64, 84);
        checkRoles(7, 85, 108);
        checkRoles(8, 109, 132);
        checkRoles(9, 133, 162);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_0').click(function(){
        checkRoles(0, 1, 162);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_1').click(function(){
        checkRoles(1, 10, 16);
    })

    $('#" . CHtml::activeId($model, 'roles') . "_2').click(function(){
        checkRoles(2, 17, 26);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_3').click(function(){
        checkRoles(3, 27, 44);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_4').click(function(){
        checkRoles(4, 45, 53);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_5').click(function(){
        checkRoles(5, 54, 63);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_6').click(function(){
        checkRoles(6, 64, 84);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_7').click(function(){
        checkRoles(7, 85, 108);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_8').click(function(){
        checkRoles(8, 109, 132);
    });

    $('#" . CHtml::activeId($model, 'roles') . "_9').click(function(){
        checkRoles(9, 133, 162);
    });
");
?>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'admin-form',
        'enableAjaxValidation' => false,
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

    <?php if ($model->isNewRecord): ?>
        <div class="formLabel"><?php echo CHtml::label('New Signature: ', FALSE); ?></div>
    <?php else: ?>
        <div class="formLabel"><?php echo CHtml::label('Signature: ', FALSE) . $model->file_extension_signature; ?></div>
    <?php endif; ?> 
    <div class="formInput"><?php echo CHtml::fileField('file_signature'); ?></div>
    <div class="formError"><?php echo CHtml::error($model, 'file_signature'); ?></div>

    <br />

    <div class="row">
        <fieldset style="width: 100%">
            <legend><span style="font-weight: bold">Roles</span></legend>
            <?php $this->renderPartial('_role', array('model' => $model, 'counter' => 0)); ?>
        </fieldset>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'is_inactive', array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive')); ?>
        <?php echo $form->error($model, 'is_inactive'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->