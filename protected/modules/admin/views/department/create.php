<?php
$this->breadcrumbs = array(
	'Departments'=>array('admin'),
	'Create',
);

$this->menu = array(
	array('label'=>'Manage Department', 'url'=>array('admin')),
);
?>

<h1>Create Department</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>