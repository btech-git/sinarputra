<?php
$this->breadcrumbs = array(
	'Employment Types'=>array('admin'),
	'Create',
);

$this->menu = array(
	array('label'=>'Manage EmploymentType', 'url'=>array('admin')),
);
?>

<h1>Create EmploymentType</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>