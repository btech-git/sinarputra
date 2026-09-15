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
		<?php echo $form->label($model, 'description'); ?>
		<?php echo $form->textField($model, 'description', array('size'=>60, 'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'item_category_id'); ?>
		<?php echo $form->textField($model, 'item_category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'unit_id'); ?>
		<?php echo $form->textField($model, 'unit_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'is_inactive'); ?>
		<?php echo $form->textField($model, 'is_inactive'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'account_id_expense'); ?>
		<?php echo $form->textField($model, 'account_id_expense'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'account_id_inventory'); ?>
		<?php echo $form->textField($model, 'account_id_inventory'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'type'); ?>
		<?php echo $form->textField($model, 'type', array('size'=>20, 'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'tax_category'); ?>
		<?php echo $form->textField($model, 'tax_category'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'tax_percentage'); ?>
		<?php echo $form->textField($model, 'tax_percentage', array('size'=>10, 'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'account_id_cost_of_goods_sold'); ?>
		<?php echo $form->textField($model, 'account_id_cost_of_goods_sold'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'account_id_goods_in_transit'); ?>
		<?php echo $form->textField($model, 'account_id_goods_in_transit'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'account_id_unbilled_goods'); ?>
		<?php echo $form->textField($model, 'account_id_unbilled_goods'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'account_id_sale_transaction'); ?>
		<?php echo $form->textField($model, 'account_id_sale_transaction'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'account_id_sale_discount'); ?>
		<?php echo $form->textField($model, 'account_id_sale_discount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'account_id_sale_return'); ?>
		<?php echo $form->textField($model, 'account_id_sale_return'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'account_id_purchase_return'); ?>
		<?php echo $form->textField($model, 'account_id_purchase_return'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->