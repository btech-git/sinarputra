<?php
$this->breadcrumbs = array(
	'Delivery Vehicles'=>array('index'),
	$model->id,
);

$this->menu = array(
	array('label'=>'List DeliveryVehicle', 'url'=>array('index')),
	array('label'=>'Create DeliveryVehicle', 'url'=>array('create')),
	array('label'=>'Update DeliveryVehicle', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete DeliveryVehicle', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete', 'id'=>$model->id), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DeliveryVehicle', 'url'=>array('admin')),
);
?>

<h1>View DeliveryVehicle #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'description',
		'plate_number',
		'is_inactive',
	),
)); ?>
