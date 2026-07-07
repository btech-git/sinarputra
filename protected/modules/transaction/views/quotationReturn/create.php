<?php
$this->breadcrumbs = array(
	'Quotation Return' => array('admin'),
	'Create',
);
?>

<h1>Quotation Return</h1>

<?php echo $this->renderPartial('_form', array(
	'quotationReturn'=>$quotationReturn,
	'product'=>$product,
	'productDataProvider' => $productDataProvider,
	'customer'=>$customer,
	
)); ?>



