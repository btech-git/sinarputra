<?php
$this->breadcrumbs = array(
	'Departments'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create Department', 'url'=>array('create')),
	array('label'=>'Update Department', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage Department', 'url'=>array('admin')),
);
?>

<h1>View Department #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'status',
	),
)); ?>
