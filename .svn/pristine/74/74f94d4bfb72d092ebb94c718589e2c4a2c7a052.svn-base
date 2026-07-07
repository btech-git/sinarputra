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
		<?php echo $form->label($model, 'width'); ?>
		<?php echo $form->textField($model, 'width', array('size'=>10, 'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'height'); ?>
		<?php echo $form->textField($model, 'height', array('size'=>10, 'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'product_id'); ?>
		<?php echo $form->textField($model, 'product_id'); ?>
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