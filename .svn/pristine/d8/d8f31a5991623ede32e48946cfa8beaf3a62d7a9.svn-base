<?php Yii::app()->clientScript->registerScript('form', ''); ?>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'product-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model->header); ?>

	<div class="row">
		<?php echo $form->labelEx($model->header, 'code'); ?>
		<?php echo $form->textField($model->header, 'code', array('size'=>60, 'maxlength'=>60)); ?>
		<?php echo $form->error($model->header, 'code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model->header, 'name'); ?>
		<?php echo $form->textField($model->header, 'name', array('size'=>60, 'maxlength'=>60)); ?>
		<?php echo $form->error($model->header, 'name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model->header, 'product_category_id'); ?>
		<?php echo $form->dropDownList($model->header, 'product_category_id', 
			CHtml::listData(ProductCategory::model()->findAll(), 'id', 'name'),
			array('empty' => '-Select Category-')); ?>
		<?php echo $form->error($model->header, 'product_category_id'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model->header, 'unit_id'); ?>
		<?php echo $form->dropDownList($model->header,'unit_id', 
			CHtml::listData(Unit::model()->findAll(), 'id', 'name'),
			array('empty' => '-Select Unit-')); ?>
		<?php echo $form->error($model->header, 'unit_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model->header, 'stock_minimum'); ?>
		<?php echo $form->textField($model->header, 'stock_minimum'); ?>
		<?php echo $form->error($model->header, 'stock_minimum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model->header, 'purchasing_price'); ?>
		<?php echo $form->textField($model->header, 'purchasing_price', array('size'=>18, 'maxlength'=>18)); ?>
		<?php echo $form->error($model->header, 'purchasing_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model->header, 'selling_price'); ?>
		<?php echo $form->textField($model->header, 'selling_price', array('size'=>18, 'maxlength'=>18)); ?>
		<?php echo $form->error($model->header, 'selling_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model->header, 'description'); ?>
		<?php echo $form->textArea($model->header, 'description', array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model->header, 'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model->header, 'is_inactive'); ?>
		<?php echo $form->dropDownList($model->header,'is_inactive', 
			array(
				ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL,
				ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL)); ?>
		<?php echo $form->error($model->header, 'is_inactive'); ?>
	</div>
	
	<div class="row">
		<?php echo CHtml::button('Add Size', array(
			'id' => 'size_button',
			'onclick'=>'
				$.ajax({
					type: "POST",
					url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $model->header->id)) . '",
					data: $("form").serialize(),
					success: function(html) { 
						$("#detail_div").html(html);
					}
				})
			'
		)); ?>
	</div>
	
	<div class="row">
		<?php echo CHtml::error($model->header, 'error'); ?>
	</div>
	
	<div id="detail_div">
		<?php $this->renderPartial('_detail', array('model' => $model)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->header->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->