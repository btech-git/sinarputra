<?php
$this->breadcrumbs = array(
	'Employment Types'=>array('admin'),
	$model->name=>array('view', 'id'=>$model->id),
	'Update',
);

$this->menu = array(
	array('label'=>'Create EmploymentType', 'url'=>array('create')),
	array('label'=>'View EmploymentType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EmploymentType', 'url'=>array('admin')),
);
?>

<h1>Update EmploymentType <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>