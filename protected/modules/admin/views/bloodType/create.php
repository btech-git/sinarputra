<?php
$this->breadcrumbs = array(
	'Blood Types'=>array('admin'),
	'Create',
);

$this->menu = array(
	array('label'=>'Manage BloodType', 'url'=>array('admin')),
);
?>

<h1>Create BloodType</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>