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
		<?php echo $form->label($model, 'code'); ?>
		<?php echo $form->textField($model, 'code', array('size'=>20, 'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('size'=>60, 'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'exchange_rate'); ?>
		<?php echo $form->textField($model, 'exchange_rate', array('size'=>18, 'maxlength'=>18)); ?>
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