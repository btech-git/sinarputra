<?php
$this->breadcrumbs = array(
	'Locations'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create Location', 'url'=>array('create')),
	array('label'=>'Update Location', 'url'=>array('update', 'id'=>$model->id)),
        array('label'=>'Manage Location', 'url'=>array('admin')),
);
?>

<h1>View Location #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'status',
	),
)); ?>
