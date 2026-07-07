<?php
$this->breadcrumbs = array(
	'Machines'=>array('index'),
	$model->name,
);

$this->menu = array(
	array('label'=>'List Machine', 'url'=>array('index')),
	array('label'=>'Create Machine', 'url'=>array('create')),
	array('label'=>'Update Machine', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Machine', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete', 'id'=>$model->id), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Machine', 'url'=>array('admin')),
);
?>

<h1>View Machine #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
        array(
            'label' => 'Type',
            'value' => $model->machineType->name,
        ),
		'name',
		'serial_number',
		'grade_classification',
		'cutting_capacity',
		'purchase_year',
		'position',
		'blade_size',
		'cutting_speed',
		'hydrolic_oil_capacity',
		'cutting_oil_capacity',
		'cutting_table_height',
		'net_weight',
		'machine_size',
		'milling_max_capacity',
		'milling_min_capacity',
		'is_milling',
		'is_inactive',
	),
)); ?>
