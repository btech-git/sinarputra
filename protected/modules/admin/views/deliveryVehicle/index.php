<?php
$this->breadcrumbs = array(
	'Delivery Vehicles',
);

$this->menu = array(
	array('label'=>'Create DeliveryVehicle', 'url'=>array('create')),
	array('label'=>'Manage DeliveryVehicle', 'url'=>array('admin')),
);
?>

<h1>Delivery Vehicles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
