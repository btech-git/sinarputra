<?php
$this->breadcrumbs = array(
	'Locations'=>array('admin'),
	$model->name=>array('view', 'id'=>$model->id),
	'Update',
);

$this->menu = array(
	array('label'=>'Create Location', 'url'=>array('create')),
	array('label'=>'View Location', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Location', 'url'=>array('admin')),
);
?>

<h1>Update Location <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>