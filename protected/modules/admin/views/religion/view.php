<?php
$this->breadcrumbs = array(
	'Religions'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create Religion', 'url'=>array('create')),
	array('label'=>'Update Religion', 'url'=>array('update', 'id'=>$model->id)),
        array('label'=>'Manage Religion', 'url'=>array('admin')),
);
?>

<h1>View Religion #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'status',
	),
)); ?>
