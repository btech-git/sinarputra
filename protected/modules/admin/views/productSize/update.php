<?php
$this->breadcrumbs = array(
	'Product Sizes'=>array('admin'),
	$model->id=>array('view', 'id'=>$model->id),
	'Update',
);

$this->menu = array(
	array('label'=>'Create ProductSize', 'url'=>array('create')),
	array('label'=>'View ProductSize', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProductSize', 'url'=>array('admin')),
);
?>

<h1>Update ProductSize <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>