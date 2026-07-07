<?php
$this->breadcrumbs = array(
	'Delivery'=>array('admin'),
	'Create',
);
?>

<h1>Pengiriman Barang MANUAL</h1>

<?php echo $this->renderPartial('_form', array(
	'delivery'=>$delivery,
));