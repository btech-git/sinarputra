<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('code')); ?>:</b>
	<?php echo CHtml::encode($data->code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_category_id')); ?>:</b>
	<?php echo CHtml::encode($data->item_category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit_id')); ?>:</b>
	<?php echo CHtml::encode($data->unit_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_inactive')); ?>:</b>
	<?php echo CHtml::encode($data->is_inactive); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('account_id_expense')); ?>:</b>
	<?php echo CHtml::encode($data->account_id_expense); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_id_inventory')); ?>:</b>
	<?php echo CHtml::encode($data->account_id_inventory); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tax_category')); ?>:</b>
	<?php echo CHtml::encode($data->tax_category); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tax_percentage')); ?>:</b>
	<?php echo CHtml::encode($data->tax_percentage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_id_cost_of_goods_sold')); ?>:</b>
	<?php echo CHtml::encode($data->account_id_cost_of_goods_sold); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_id_goods_in_transit')); ?>:</b>
	<?php echo CHtml::encode($data->account_id_goods_in_transit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_id_unbilled_goods')); ?>:</b>
	<?php echo CHtml::encode($data->account_id_unbilled_goods); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_id_sale_transaction')); ?>:</b>
	<?php echo CHtml::encode($data->account_id_sale_transaction); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_id_sale_discount')); ?>:</b>
	<?php echo CHtml::encode($data->account_id_sale_discount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_id_sale_return')); ?>:</b>
	<?php echo CHtml::encode($data->account_id_sale_return); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_id_purchase_return')); ?>:</b>
	<?php echo CHtml::encode($data->account_id_purchase_return); ?>
	<br />

	*/ ?>

</div>