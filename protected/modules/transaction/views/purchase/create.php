<?php
	$this->breadcrumbs = array(
		'Purchase Order'=>array('admin'),
		'Create',
	);
?>

<h1>Pembelian Barang</h1>

<?php echo $this->renderPartial('_form', array(
	'purchase'=>$purchase,
	'supplier'=>$supplier,
	'supplierDataProvider' => $supplierDataProvider,
	'productSize' => $productSize,
	'productSizeDataProvider' => $productSizeDataProvider,
    'workOrderCuttingDetail' => $workOrderCuttingDetail,
    'workOrderCuttingDetailDataProvider' => $workOrderCuttingDetailDataProvider,
    'receiveDetail' => $receiveDetail,
    'receiveDetailDataProvider' => $receiveDetailDataProvider,
    'workOrderCuttingDetailMaterial' => $workOrderCuttingDetailMaterial,
    'workOrderCuttingDetailMaterialDataProvider' => $workOrderCuttingDetailMaterialDataProvider,
//    'productName' => $productName
));?>
