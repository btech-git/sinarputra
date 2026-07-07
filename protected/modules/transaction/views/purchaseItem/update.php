<?php
$this->breadcrumbs = array(
    'Purchase Item' => array('admin'),
    'Update',
);
?>

<h1>Pembelian Item</h1>

<?php
echo $this->renderPartial('_form', array(
    'purchaseItem' => $purchaseItem,
    'supplier' => $supplier,
    'supplierDataProvider' => $supplierDataProvider,
    'item' => $item,
    'itemDataProvider' => $itemDataProvider,
));
?>
