<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'employee-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        ),
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model->header); ?>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'code'); ?>
        <?php echo $form->textField($model->header, 'code', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model->header, 'code'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'name'); ?>
        <?php echo $form->textField($model->header, 'name', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model->header, 'name'); ?>
    </div>

    <?php if ($model->header->isNewRecord): ?>
        <div class="formLabel"><?php echo CHtml::label('New Image: ', FALSE); ?></div>
        <div class="formInput"><?php echo CHtml::fileField('file'); // by this we can upload image             ?>  </div>
        <div class="formError"><?php echo CHtml::error($model->header, 'file'); ?></div>
    <?php else: ?>
        <div class="formLabel"><?php echo CHtml::label('Image: ', FALSE) . $model->header->file_extension; ?></div>
        <div class="formInput"><?php echo CHtml::fileField('file'); // by this we can upload image             ?></div>
        <div class="formError"><?php echo CHtml::error($model->header, 'file'); ?></div>
    <?php endif; ?>

    <?php if ($model->header->isNewRecord): ?>
        <div class="formLabel"><?php echo CHtml::label('New Signature: ', FALSE); ?></div>
        <div class="formInput"><?php echo CHtml::fileField('file_signature'); // by this we can upload image             ?>  </div>
        <div class="formError"><?php echo CHtml::error($model->header, 'file_signature'); ?></div>
    <?php else: ?>
        <div class="formLabel"><?php echo CHtml::label('Signature: ', FALSE) . $model->header->file_extension_signature; ?></div>
        <div class="formInput"><?php echo CHtml::fileField('file_signature'); // by this we can upload image             ?></div>
        <div class="formError"><?php echo CHtml::error($model->header, 'file_signature'); ?></div>
    <?php endif; ?>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'start_date'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model->header,
            'attribute' => 'start_date',
            // additional javascript options for the date picker plugin
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
                'changeYear' => true,
            ),
            'htmlOptions' => array(
                'readonly' => true,
            ),
        ));
        ?>
        <?php echo $form->error($model->header, 'start_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'permanent_start_date'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model->header,
            'attribute' => 'permanent_start_date',
            // additional javascript options for the date picker plugin
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
                'changeYear' => true,
            ),
            'htmlOptions' => array(
                'readonly' => true,
            ),
        ));
        ?>
        <?php echo $form->error($model->header, 'permanent_start_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'company'); ?>
        <?php echo $form->textField($model->header, 'company', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model->header, 'company'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'cost_center'); ?>
        <?php echo $form->textField($model->header, 'cost_center', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model->header, 'cost_center'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'Tanggal Lahir'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model->header,
            'attribute' => 'birth_date',
            // additional javascript options for the date picker plugin
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
                'changeYear' => true,
                'yearRange' => '-90:+0',
            ),
            'htmlOptions' => array(
                'readonly' => true,
            ),
        ));
        ?>
        <?php echo $form->error($model->header, 'birth_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'Tempat Lahir'); ?>
        <?php echo $form->textField($model->header, 'birth_place', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model->header, 'birth_place'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'employee_category_id'); ?>
        <?php echo $form->dropDownList($model->header, 'employee_category_id', CHtml::listData(EmployeeCategory::model()->findAll(), 'id', 'name')); ?>
        <?php echo $form->error($model->header, 'employee_category_id'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model->header, 'employment_type_id'); ?>
        <?php echo $form->dropDownList($model->header, 'employment_type_id', CHtml::listData(EmploymentType::model()->findAll(), 'id', 'name')); ?>
        <?php echo $form->error($model->header, 'employment_type_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'department_id'); ?>
        <?php echo $form->dropDownList($model->header, 'department_id', CHtml::listData(Department::model()->findAll(), 'id', 'name')); ?>
        <?php echo $form->error($model->header, 'department_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'division_id'); ?>
        <?php echo $form->dropDownList($model->header, 'division_id', CHtml::listData(Division::model()->findAll(), 'id', 'name')); ?>
        <?php echo $form->error($model->header, 'division_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'Grup'); ?>
        <?php echo $form->textField($model->header, 'job_group', array('size' => 10, 'maxlength' => 2)); ?>
        <?php echo $form->error($model->header, 'job_group'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'ethnic_group_id'); ?>
        <?php echo $form->dropDownList($model->header, 'ethnic_group_id', CHtml::listData(EthnicGroup::model()->findAll(), 'id', 'name')); ?>
        <?php echo $form->error($model->header, 'ethnic_group_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'religion_id'); ?>
        <?php echo $form->dropDownList($model->header, 'religion_id', CHtml::listData(Religion::model()->findAll(), 'id', 'name')); ?>
        <?php echo $form->error($model->header, 'religion_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'blood_type_id'); ?>
        <?php echo $form->dropDownList($model->header, 'blood_type_id', CHtml::listData(BloodType::model()->findAll(), 'id', 'name')); ?>
        <?php echo $form->error($model->header, 'blood_type_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'Gender'); ?>
        <?php
        echo $form->dropDownList($model->header, 'is_female', array(
            Employee::MALE => Employee::MALE_LITERAL,
            Employee::FEMALE => Employee::FEMALE_LITERAL));
        ?>
        <?php echo $form->error($model->header, 'is_female'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'Marital Status'); ?>
        <?php
        echo $form->dropDownList($model->header, 'marital_status', array(
            Employee::SINGLE => Employee::SINGLE_LITERAL,
            Employee::MARRIED => Employee::MARRIED_LITERAL,
            Employee::DIVORCE => Employee::DIVORCE_LITERAL));
        ?>
        <?php echo $form->error($model->header, 'marital_status'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'Tinggi'); ?>
        <?php echo $form->textField($model->header, 'height', array('size' => 10, 'maxlength' => 10)); ?>
        <?php echo $form->error($model->header, 'height'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'Berat'); ?>
        <?php echo $form->textField($model->header, 'weight', array('size' => 10, 'maxlength' => 10)); ?>
        <?php echo $form->error($model->header, 'weight'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'Alamat Tinggal'); ?>
        <?php echo $form->textArea($model->header, 'residential_address', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model->header, 'residential_address'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'Alamat Asal'); ?>
        <?php echo $form->textArea($model->header, 'original_address', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model->header, 'original_address'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'phone'); ?>
        <?php echo $form->textField($model->header, 'phone', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model->header, 'phone'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'email'); ?>
        <?php echo $form->textField($model->header, 'email', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model->header, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'Nama Keluarga'); ?>
        <?php echo $form->textField($model->header, 'family_name', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model->header, 'family_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'Status'); ?>
        <?php
        echo $form->dropDownList($model->header, 'family_status', array(
            Employee::HUSBAND => Employee::HUSBAND_LITERAL,
            Employee::WIFE => Employee::WIFE_LITERAL,
            Employee::CHILD => Employee::CHILD_LITERAL));
        ?>
        <?php echo $form->error($model->header, 'family_status'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'No. Kartu Keluarga'); ?>
        <?php echo $form->textField($model->header, 'family_registration_number', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model->header, 'family_registration_number'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'NIK Keluarga'); ?>
        <?php echo $form->textField($model->header, 'nik_number', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model->header, 'nik_number'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'KTP #'); ?>
        <?php echo $form->textField($model->header, 'identity_number', array('size' => 30, 'maxlength' => 30)); ?>
        <?php echo $form->error($model->header, 'identity_number'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'Tanggal KTP Expired'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model->header,
            'attribute' => 'identity_expired',
            // additional javascript options for the date picker plugin
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
                'changeYear' => true,
            ),
            'htmlOptions' => array(
                'readonly' => true,
            ),
        ));
        ?>
        <?php echo $form->error($model->header, 'identity_expired'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'SIM #'); ?>
        <?php echo $form->textField($model->header, 'driver_license_number', array('size' => 30, 'maxlength' => 30)); ?>
        <?php echo $form->error($model->header, 'driver_license_number'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'Tanggal SIM expired'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model->header,
            'attribute' => 'driver_license_expired',
            // additional javascript options for the date picker plugin
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
                'changeYear' => true,
            ),
            'htmlOptions' => array(
                'readonly' => true,
            ),
        ));
        ?>
        <?php echo $form->error($model->header, 'driver_license_expired'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'BPJS Kesehatan'); ?>
        <?php echo $form->textField($model->header, 'health_insurance_number', array('size' => 30, 'maxlength' => 30)); ?>
        <?php echo $form->error($model->header, 'health_insurance_number'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'BPJS Ketenagakerjaan'); ?>
        <?php echo $form->textField($model->header, 'employment_insurance_number', array('size' => 30, 'maxlength' => 30)); ?>
        <?php echo $form->error($model->header, 'employment_insurance_number'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'NPWP'); ?>
        <?php echo $form->textField($model->header, 'personal_tax_number', array('size' => 30, 'maxlength' => 30)); ?>
        <?php echo $form->error($model->header, 'personal_tax_number'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'Bank'); ?>
        <?php echo $form->textField($model->header, 'bank_name', array('size' => 30, 'maxlength' => 30)); ?>
        <?php echo $form->error($model->header, 'bank_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->header, 'Bank Account #'); ?>
        <?php echo $form->textField($model->header, 'bank_account_number', array('size' => 30, 'maxlength' => 30)); ?>
        <?php echo $form->error($model->header, 'bank_account_number'); ?>
    </div>

    <div class="row">
        <?php echo CHtml::label('PTKP', ''); ?>

        <?php
        echo $form->dropDownList($model->header, 'tax_status', array(
            Employee::L => Employee::L_LITERAL,
            Employee::K0 => Employee::K0_LITERAL,
            Employee::K1 => Employee::K1_LITERAL,
            Employee::K2 => Employee::K2_LITERAL,
            Employee::K3 => Employee::K3_LITERAL));
        ?>
        <?php echo $form->error($model->header, 'tax_status'); ?>
    </div>    

    <div class="row">
        <?php echo $form->labelEx($model->header, 'Effective Date Resign'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model->header,
            'attribute' => 'resignation_date',
            // additional javascript options for the date picker plugin
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
                'changeYear' => true,
            ),
            'htmlOptions' => array(
                'readonly' => true,
            ),
        ));
        ?>
        <?php echo $form->error($model->header, 'resignation_date'); ?>
    </div>


    <div class="row">
        <?php
        echo CHtml::button('Add Family Relationship', array(
            'id' => 'size_button',
            'onclick' => '
                $.ajax({
                    type: "POST",
                    url: "' . CController::createUrl('ajaxHtmlAddDetailRelationship', array('id' => $model->header->id)) . '",
                    data: $("form").serialize(),
                    success: function(html) { 
                        $("#detail_relationship").html(html);
                    }
                })
            '
        ));
        ?>
    </div>

    <div id="detail_relationship">
        <?php $this->renderPartial('_detail_relationship', array('model' => $model)); ?>
    </div>

    <div class="row">
        <?php
        echo CHtml::button('Add Formal Education', array(
            'id' => 'size_button',
            'onclick' => '
                $.ajax({
                    type: "POST",
                    url: "' . CController::createUrl('ajaxHtmlAddDetailEducation', array('id' => $model->header->id)) . '",
                    data: $("form").serialize(),
                    success: function(html) { 
                        $("#detail_education").html(html);
                    }
                })
            '
        ));
        ?>
    </div>

    <div id="detail_education">
        <?php $this->renderPartial('_detail_education', array('model' => $model)); ?>
    </div>

    <div class="row">
        <?php
        echo CHtml::button('Add Job Experience', array(
            'id' => 'size_button',
            'onclick' => '
                $.ajax({
                    type: "POST",
                    url: "' . CController::createUrl('ajaxHtmlAddDetailExperience', array('id' => $model->header->id)) . '",
                    data: $("form").serialize(),
                    success: function(html) { 
                        $("#detail_experience").html(html);
                    }
                })
            '
        ));
        ?>
    </div>

    <div id="detail_experience">
        <?php $this->renderPartial('_detail_experience', array('model' => $model)); ?>
    </div>

    <?php if (!$model->header->isNewRecord): ?>
        <div class="row">
            <?php echo $form->labelEx($model->header, 'status'); ?>
            <?php
            echo $form->dropDownList($model->header, 'is_inactive', array(
                ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL,
                ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL));
            ?>
            <?php echo $form->error($model->header, 'is_inactive'); ?>
        </div>
    <?php endif; ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->header->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->