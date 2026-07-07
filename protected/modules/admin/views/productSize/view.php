<?php
$this->breadcrumbs = array(
	'Product Sizes'=>array('admin'),
	$model->id,
);

$this->menu = array(
	array('label'=>'Create ProductSize', 'url'=>array('create')),
	array('label'=>'Update ProductSize', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage ProductSize', 'url'=>array('admin')),
);
?>

<h1>View ProductSize #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'product_code',
		'width',
		'height',
		'product.name',
		'is_inactive',
	),
)); ?>
