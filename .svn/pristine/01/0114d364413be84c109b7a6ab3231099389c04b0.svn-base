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
		<?php echo $form->label($model, 'updated_time'); ?>
		<?php echo $form->textField($model, 'updated_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('size'=>60, 'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'username'); ?>
		<?php echo $form->textField($model, 'username', array('size'=>60, 'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'salt'); ?>
		<?php echo $form->textField($model, 'salt', array('size'=>32, 'maxlength'=>32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'address'); ?>
		<?php echo $form->textArea($model, 'address', array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'phone'); ?>
		<?php echo $form->textField($model, 'phone', array('size'=>60, 'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'cell_phone'); ?>
		<?php echo $form->textField($model, 'cell_phone', array('size'=>60, 'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'email'); ?>
		<?php echo $form->textField($model, 'email', array('size'=>60, 'maxlength'=>60)); ?>
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