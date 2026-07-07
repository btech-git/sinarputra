<?php
	$this->breadcrumbs = array(
		'Purchase Receipt'=>array('admin'),
		'Update',
	);
?>

<h1>Purchase Receipt Update</h1>

<?php 
	$this->renderPartial('_form', array(
		'model' => $model,
		'purchaseInvoice' => $purchaseInvoice,
		'purchaseInvoiceDataProvider' => $purchaseInvoiceDataProvider,
		'supplier' => $supplier,
		'supplierDataProvider' => $supplierDataProvider
	));
?>