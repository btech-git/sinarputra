<?php
$this->breadcrumbs = array(
	'Receive'=>array('admin'),
	'Update',
);
?>

<h1>Penerimaan Material</h1>

<?php echo $this->renderPartial('_form', array(
	'receive'=>$receive,
	'purchaseHeader'=>$purchaseHeader,
	'purchaseHeaderDataProvider'=>$purchaseHeaderDataProvider,
	'cnMonth' => strtoupper($cnMonth),
	'productSize' => $productSize,
	'productSizeDataProvider' => $productSizeDataProvider,
	'supplier'=>$supplier,
	'supplierDataProvider' => $supplierDataProvider,
));