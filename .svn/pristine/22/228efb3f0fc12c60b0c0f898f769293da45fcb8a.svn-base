<?php
$this->breadcrumbs = array(
	'Employee Categories'=>array('index'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create EmployeeCategory', 'url'=>array('create')),
	array('label'=>'Update EmployeeCategory', 'url'=>array('update', 'id'=>$model->id)),
        array('label'=>'Manage EmployeeCategory', 'url'=>array('admin')),
);
?>

<h1>View EmployeeCategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'status',
	),
)); ?>
