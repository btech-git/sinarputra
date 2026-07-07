<?php
$this->breadcrumbs = array(
    'Invoice Manual 2' => array('admin'),
    'Update',
);
?>

<h1>Invoice Manual 2</h1>

<?php echo $this->renderPartial('_form', array(
    'materialInvoice' => $materialInvoice,
    'customer' => $customer,
    'customerDataProvider' => $customerDataProvider,
)); ?>
