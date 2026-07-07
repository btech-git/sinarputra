<?php
$this->pageTitle = Yii::app()->name . ' - Master';
$this->breadcrumbs = array(
    'Sinar Putra Metalindo',
);
?>

<h1>Halaman Master</h1>
<div class="form">
	<?php
    if (Yii::app()->user->checkAccess('purchaseCreateMaster') || Yii::app()->user->checkAccess('accountingCreateMaster') || Yii::app()->user->checkAccess('inventoryCreateMaster') || Yii::app()->user->checkAccess('hrgaCreateMaster') || Yii::app()->user->checkAccess('productionCreateMaster')
    ):
	?>
		<fieldset>
			<legend>Data Master</legend>
			<ul style="display: table-cell; width: 800px">
				<?php if (Yii::app()->user->checkAccess('purchaseCreateMaster')): ?>
					<li style="width: 50%"><?php echo CHtml::link('Item', array('/admin/item/admin')); ?></li>
					<br class="clear" />
                <?php endif; ?>
				<?php if (Yii::app()->user->checkAccess('accountingCreateMaster')): ?>
					<li style="width: 50%"><?php echo CHtml::link('Chart of Account', array('/admin/account/admin')); ?></li>
					<br class="clear" />
					<li style="width: 50%"><?php echo CHtml::link('Customer', array('/admin/customer/admin')); ?></li>
					<br class="clear" />
                <?php endif; ?>
				<?php if (Yii::app()->user->checkAccess('inventoryCreateMaster')): ?>
					<li style="width: 50%"><?php echo CHtml::link('Supplier Material', array('/admin/supplier/admin')); ?></li>
					<br class="clear" />
                <?php endif; ?>
				<?php if (Yii::app()->user->checkAccess('purchaseCreateMaster')): ?>
					<li style="width: 50%"><?php echo CHtml::link('Supplier Non Material', array('*')); ?></li>
					<br class="clear" />
                <?php endif; ?>
				<?php if (Yii::app()->user->checkAccess('accountingCreateMaster')): ?>
					<li style="width: 50%"><?php echo CHtml::link('Gudang', array('/admin/warehouse/admin')); ?></li>
					<br class="clear" />
                <?php endif; ?>
				<?php if (Yii::app()->user->checkAccess('hrgaCreateMaster')): ?>
					<li style="width: 50%"><?php echo CHtml::link('Employee', array('/admin/employee/admin')); ?></li>
					<br class="clear" />
                <?php endif; ?>
				<?php if (Yii::app()->user->checkAccess('productionCreateMaster')): ?>
					<li style="width: 50%"><?php echo CHtml::link('Employee Production', array('*')); ?></li>
					<br class="clear" />
                <?php endif; ?>
			</ul>
		</fieldset>
		<fieldset>
			<legend>Data Pembantu</legend>
			<ul style="display: table-cell; width: 800px">
				<li style="width: 50%"><?php echo CHtml::link('Akun Kategori', array('/admin/accountCategory/admin')); ?></li>
				<br class="clear" />
				<?php if (Yii::app()->user->checkAccess('productionCreateMaster')): ?>
					<li style="width: 50%"><?php echo CHtml::link('Mesin', array('/admin/machine/admin')); ?></li>
					<br class="clear" />
                <?php endif; ?>
				<?php if (Yii::app()->user->checkAccess('purchaseCreateMaster')): ?>
					<li style="width: 50%"><?php echo CHtml::link('Item Category', array('/admin/itemCategory/admin')); ?></li>
					<br class="clear" />
                <?php endif; ?>
				<?php if (Yii::app()->user->checkAccess('inventoryCreateMaster')): ?>
					<li style="width: 50%"><?php echo CHtml::link('Product Category', array('/admin/productCategory/admin')); ?></li>
					<br class="clear" />
					<li style="width: 50%"><?php echo CHtml::link('Location', array('/admin/location/admin')); ?></li>
					<br class="clear" />
                <?php endif; ?>
				<li style="width: 50%"><?php echo CHtml::link('Currency', array('/admin/currency/admin')); ?></li>
				<br class="clear" />
				<li style="width: 50%"><?php echo CHtml::link('Satuan', array('/admin/unit/admin')); ?></li>
				<br class="clear" />
				<li style="width: 50%"><?php echo CHtml::link('Payment Type', array('/admin/paymentType/admin')); ?></li>
				<br class="clear" />
				<li style="width: 50%"><?php echo CHtml::link('Kendaraan Operasional', array('/admin/deliveryVehicle/admin')); ?></li>
				<br class="clear" />
			</ul>
		</fieldset>
		<fieldset>
			<legend>Data Pembantu Employee</legend>
			<ul style="display: table-cell; width: 800px">
				<?php if (Yii::app()->user->checkAccess('hrgaCreateMaster')): ?>
					<li style="width: 50%"><?php echo CHtml::link('Employee Category', array('/admin/employeeCategory/admin')); ?></li>
					<br class="clear" />
					<li style="width: 50%"><?php echo CHtml::link('Employee Type', array('/admin/employmentType/admin')); ?></li>
					<br class="clear" />
					<li style="width: 50%"><?php echo CHtml::link('Ethnic Group', array('/admin/ethnicGroup/admin')); ?></li>
					<br class="clear" />
					<li style="width: 50%"><?php echo CHtml::link('Department', array('/admin/department/admin')); ?></li>
					<br class="clear" />
					<li style="width: 50%"><?php echo CHtml::link('Religion', array('/admin/religion/admin')); ?></li>
					<br class="clear" />
					<li style="width: 50%"><?php echo CHtml::link('Blood Type', array('/admin/bloodType/admin')); ?></li>
					<br class="clear" />
					<li style="width: 50%"><?php echo CHtml::link('Production Group', array('/admin/productionGroup/admin')); ?></li>
					<br class="clear" />
    			<?php endif; ?>
			</ul>
		</fieldset>
		<fieldset>
			<legend>Employee</legend>
			<ul style="display: table-cell; width: 800px">
				<?php if (Yii::app()->user->checkAccess('hrgaCreateMaster')): ?>
					<li style="width: 50%"><?php echo CHtml::link('Timesheet', array ('/admin/employee/upload'));     ?></li>
					<br class="clear" />
    			<?php endif; ?>
			</ul>
		</fieldset>
		<fieldset>
			<legend>Transaction</legend>
			<ul style="display: table-cell; width: 800px">
    			<?php if (Yii::app()->user->checkAccess('inventoryCreateMaster')): ?>
					<li style="width: 50%"><?php echo CHtml::link('Material', array ('/admin/item/admin')); ?></li>
					<br class="clear" />
    			<?php endif; ?>
			</ul>
		</fieldset>    

    <?php endif; ?>
</div>