<?php
$this->breadcrumbs = array(
	'ReceiveItem'=>array('admin'),
	'Update',
);
?>

<h1>Penerimaan Barang Penunjang</h1>

<?php echo $this->renderPartial('_form', array(
	'receiveItem'=>$receiveItem,
	'purchaseItemHeader'=>$purchaseItemHeader,
	'purchaseItemHeaderDataProvider'=>$purchaseItemHeaderDataProvider,
	'supplierCompany' => $supplierCompany,
));