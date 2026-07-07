<?php
$this->breadcrumbs = array(
	'Currencies'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create Currency', 'url'=>array('create')),
	array('label'=>'Update Currency', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage Currency', 'url'=>array('admin')),
);
?>

<h1>View Currency #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'code',
		'name',
		'exchange_rate',
		'status',
	),
)); ?>
