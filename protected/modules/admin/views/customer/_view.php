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

	<b><?php echo CHtml::encode($data->getAttributeLabel('company')); ?>:</b>
	<?php echo CHtml::encode($data->company); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address_main')); ?>:</b>
	<?php echo CHtml::encode($data->address_main); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('address_secondary')); ?>:</b>
	<?php echo CHtml::encode($data->address_secondary); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city')); ?>:</b>
	<?php echo CHtml::encode($data->city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('province')); ?>:</b>
	<?php echo CHtml::encode($data->province); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
	<?php echo CHtml::encode($data->phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fax')); ?>:</b>
	<?php echo CHtml::encode($data->fax); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_due_days')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_due_days); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('available_credit')); ?>:</b>
	<?php echo CHtml::encode($data->available_credit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('credit_limit')); ?>:</b>
	<?php echo CHtml::encode($data->credit_limit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount_default')); ?>:</b>
	<?php echo CHtml::encode($data->discount_default); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_tax')); ?>:</b>
	<?php echo CHtml::encode($data->is_tax); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tax_registration_number')); ?>:</b>
	<?php echo CHtml::encode($data->tax_registration_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tax_name')); ?>:</b>
	<?php echo CHtml::encode($data->tax_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tax_address')); ?>:</b>
	<?php echo CHtml::encode($data->tax_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_id')); ?>:</b>
	<?php echo CHtml::encode($data->employee_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_inactive')); ?>:</b>
	<?php echo CHtml::encode($data->is_inactive); ?>
	<br />

	*/ ?>

</div>