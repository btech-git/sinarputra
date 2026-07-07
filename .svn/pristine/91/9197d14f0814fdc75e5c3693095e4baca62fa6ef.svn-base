<?php
$this->breadcrumbs = array(
	'Departments'=>array('admin'),
	$model->name=>array('view', 'id'=>$model->id),
	'Update',
);

$this->menu = array(
	array('label'=>'Create Department', 'url'=>array('create')),
	array('label'=>'View Department', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Department', 'url'=>array('admin')),
);
?>

<h1>Update Department <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>