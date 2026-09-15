<?php
$this->breadcrumbs = array(
	'Items'=>array('index'),
	$model->name,
);

$this->menu = array(
	array('label'=>'List Item', 'url'=>array('index')),
	array('label'=>'Create Item', 'url'=>array('create')),
	array('label'=>'Update Item', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Item', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete', 'id'=>$model->id), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Item', 'url'=>array('admin')),
);
?>

<h1>View Item #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'code',
		'name',
		'description',
		'item_category_id',
		'unit_id',
		'is_inactive',
		'account_id_expense',
		'account_id_inventory',
		'type',
		'tax_category',
		'tax_percentage',
		'account_id_cost_of_goods_sold',
		'account_id_goods_in_transit',
		'account_id_unbilled_goods',
		'account_id_sale_transaction',
		'account_id_sale_discount',
		'account_id_sale_return',
		'account_id_purchase_return',
	),
)); ?>
