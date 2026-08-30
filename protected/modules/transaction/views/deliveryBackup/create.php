<?php
$this->breadcrumbs = array(
	'Delivery'=>array('admin'),
	'Create',
);
?>

<h1>Pengiriman Barang Manual 2</h1>

<?php echo $this->renderPartial('_form', array(
    'deliveryBackup' => $deliveryBackup,
    'customer' => $customer,
    'customerDataProvider' => $customerDataProvider,
));