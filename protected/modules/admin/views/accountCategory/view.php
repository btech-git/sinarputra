<?php
$this->breadcrumbs = array(
	'Account Categories'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create AccountCategory', 'url'=>array('create')),
	array('label'=>'Update AccountCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage AccountCategory', 'url'=>array('admin')),
);
?>

<h1>View AccountCategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'code',
		'name',
		'description',
		array(
			'label'=>'Category',
			'value'=> CHtml::encode(CHtml::value($model->accountCategory, 'name')),
		),
		'status',
	),
)); ?>
