<?php
$this->breadcrumbs = array(
	'Religions'=>array('admin'),
	$model->name=>array('view', 'id'=>$model->id),
	'Update',
);

$this->menu = array(
	array('label'=>'Create Religion', 'url'=>array('create')),
	array('label'=>'View Religion', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Religion', 'url'=>array('admin')),
);
?>

<h1>Update Religion <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>