<?php
$this->breadcrumbs = array(
	'Ethnic Groups'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create EthnicGroup', 'url'=>array('create')),
	array('label'=>'Update EthnicGroup', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage EthnicGroup', 'url'=>array('admin')),
);
?>

<h1>View EthnicGroup #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'status',
	),
)); ?>
