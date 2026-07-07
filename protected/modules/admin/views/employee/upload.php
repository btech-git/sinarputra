<?php if (Yii::app()->user->hasFlash('message')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('message'); ?>
    </div>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('error')): ?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'pendapatanexcel-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
            ));
    ?>

    <h1>Upload Timesheet</h1>
    <div class="row">
        <?php echo $form->labelEx($model, 'file_excel'); ?>
        <?php echo $form->Filefield($model, 'file_excel'); ?>
        <?php echo $form->error($model, 'file_excel'); ?>
    </div>


    <?php echo CHtml::submitButton('Submit'); ?>

    <?php $this->endWidget(); ?>
</div>
