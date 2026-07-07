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
		<?php echo $form->textField($model, 'code', array('size'=>60, 'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('size'=>60, 'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'stock_minimum'); ?>
		<?php echo $form->textField($model, 'stock_minimum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'purchasing_price'); ?>
		<?php echo $form->textField($model, 'purchasing_price', array('size'=>18, 'maxlength'=>18)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'selling_price'); ?>
		<?php echo $form->textField($model, 'selling_price', array('size'=>18, 'maxlength'=>18)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'description'); ?>
		<?php echo $form->textArea($model, 'description', array('rows'=>6, 'cols'=>50)); ?>
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