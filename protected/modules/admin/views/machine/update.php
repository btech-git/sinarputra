<?php
$this->breadcrumbs = array(
	'Machines'=>array('index'),
	$model->name=>array('view', 'id'=>$model->id),
	'Update',
);

$this->menu = array(
	array('label'=>'List Machine', 'url'=>array('index')),
	array('label'=>'Create Machine', 'url'=>array('create')),
	array('label'=>'View Machine', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Machine', 'url'=>array('admin')),
);
?>

<h1>Update Machine <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>