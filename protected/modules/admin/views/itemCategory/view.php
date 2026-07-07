<?php
$this->breadcrumbs = array(
	'Item Categories'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create ItemCategory', 'url'=>array('create')),
	array('label'=>'Update ItemCategory', 'url'=>array('update', 'id'=>$model->id)),
        array('label'=>'Manage ItemCategory', 'url'=>array('admin')),
);
?>

<h1>View ItemCategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'status',
	),
)); ?>
