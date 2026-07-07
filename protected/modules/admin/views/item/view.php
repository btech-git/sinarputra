<?php
$this->breadcrumbs = array(
	'Items'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create Item', 'url'=>array('create')),
	array('label'=>'Update Item', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Manage Item', 'url'=>array('admin')),
);
?>

<h1>View Item #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'code',
		'name',
		'description',
		array(
			'label' => 'Category',
			'value' => $model->itemCategory->name
		),
		array(
			'label' => 'Unit',
			'value' => $model->unit->name
		),
		'status',
	),
)); ?>
