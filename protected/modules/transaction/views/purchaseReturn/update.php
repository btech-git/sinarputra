<?php
$this->breadcrumbs = array(
	'Purchase Return' => array('admin'),
	'Update',
);
?>

<h1>Retur Pembelian Barang</h1>

<?php echo $this->renderPartial('_form', array(
	'purchaseReturn'=>$purchaseReturn,
	'products' => $products,
	'supplier'=>$supplier,
)); ?>



