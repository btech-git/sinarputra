<?php
$this->breadcrumbs = array(
	'Products'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create Product', 'url'=>array('create')),
	array('label'=>'Update Product', 'url'=>array('update', 'id'=>$model->id)),
        array('label'=>'Manage Product', 'url'=>array('admin')),
);
?>

<style>
	table {
		border-top: 1px solid;
		border-left: 1px solid;
	}
	th, td {
		border-right: 1px solid;
		border-bottom: 1px solid;
	}
</style>

<h1>View Product #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'code',
		'name',
		'stock_minimum',
		'purchasing_price',
		'selling_price',
		'description',
		'status',
	),
)); ?>
<br />

<h2>Sizes</h2>
<table>
	<tr>
		<th>Code</th>
		<th>Width</th>
		<th>Height</th>
	</tr>
	
	<?php foreach ($model->productSizes as $detail): ?>
		<tr>
			<td><?php echo CHtml::value($detail, 'product_code'); ?></td>
			<td><?php echo CHtml::value($detail, 'width'); ?></td>
			<td><?php echo CHtml::value($detail, 'height'); ?></td>
		</tr>
	<?php endforeach; ?>
</table>