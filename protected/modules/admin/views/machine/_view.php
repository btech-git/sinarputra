<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('serial_number')); ?>:</b>
	<?php echo CHtml::encode($data->serial_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('grade_classification')); ?>:</b>
	<?php echo CHtml::encode($data->grade_classification); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cutting_capacity')); ?>:</b>
	<?php echo CHtml::encode($data->cutting_capacity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('purchase_year')); ?>:</b>
	<?php echo CHtml::encode($data->purchase_year); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('position')); ?>:</b>
	<?php echo CHtml::encode($data->position); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('blade_size')); ?>:</b>
	<?php echo CHtml::encode($data->blade_size); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cutting_speed')); ?>:</b>
	<?php echo CHtml::encode($data->cutting_speed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hydrolic_oil_capacity')); ?>:</b>
	<?php echo CHtml::encode($data->hydrolic_oil_capacity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cutting_oil_capacity')); ?>:</b>
	<?php echo CHtml::encode($data->cutting_oil_capacity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cutting_table_height')); ?>:</b>
	<?php echo CHtml::encode($data->cutting_table_height); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('net_weight')); ?>:</b>
	<?php echo CHtml::encode($data->net_weight); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('machine_size')); ?>:</b>
	<?php echo CHtml::encode($data->machine_size); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('milling_max_capacity')); ?>:</b>
	<?php echo CHtml::encode($data->milling_max_capacity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('milling_min_capacity')); ?>:</b>
	<?php echo CHtml::encode($data->milling_min_capacity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('machine_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->machine_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_milling')); ?>:</b>
	<?php echo CHtml::encode($data->is_milling); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_inactive')); ?>:</b>
	<?php echo CHtml::encode($data->is_inactive); ?>
	<br />

	*/ ?>

</div>