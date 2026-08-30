<?php
$this->breadcrumbs = array(
    'Delivery' => array('admin'),
    'Update',
);
?>

<h1>Revisi Pengiriman Barang Manual 2</h1>

<?php echo $this->renderPartial('_form', array(
    'deliveryBackup' => $deliveryBackup,
    'customer' => $customer,
    'customerDataProvider' => $customerDataProvider,
)); ?>