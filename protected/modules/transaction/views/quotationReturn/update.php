<?php
$this->breadcrumbs = array(
	'Quotation Return' => array('admin'),
	'Update',
);
?>

<h1>Quotation Return Update</h1>

<?php echo $this->renderPartial('_form', array(
	'quotationReturn'=>$quotationReturn,
	'product'=>$product,
	'productDataProvider' => $productDataProvider,
	'customer'=>$customer,
)); ?>



