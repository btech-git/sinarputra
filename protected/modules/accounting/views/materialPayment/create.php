<?php
$this->breadcrumbs = array(
	'Manual Payment 2'=>array('admin'),
	'Create',
);
?>

<h1>Pelunasan Penjualan Manual 2</h1>

<?php echo $this->renderPartial('_form', array(
    'materialPayment' => $materialPayment,
    'materialInvoice' => $materialInvoice,
    'materialInvoiceDataProvider' => $materialInvoiceDataProvider,
    'customer' => $customer,
    'customerDataProvider' => $customerDataProvider,
));

