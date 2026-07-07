<?php
$this->breadcrumbs = array(
	'Divisions'=>array('index'),
	$model->name=>array('view', 'id'=>$model->id),
	'Update',
);

$this->menu = array(
	array('label'=>'List Division', 'url'=>array('index')),
	array('label'=>'Create Division', 'url'=>array('create')),
	array('label'=>'View Division', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Division', 'url'=>array('admin')),
);
?>

<h1>Update Division <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>